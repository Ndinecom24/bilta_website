<?php

namespace Tests\Feature;

use App\Mail\Support\TicketNotificationMail;
use App\Models\Support\Ticket;
use App\Models\Support\TicketBillingRate;
use App\Models\Support\TicketWorkLog;
use App\Models\System\Role;
use App\Models\User;
use App\Services\Support\SupportReportService;
use App\Services\Support\TicketService;
use App\Services\Support\XlsxWriter;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use ZipArchive;

class SupportTicketingTest extends TestCase
{
    use DatabaseTransactions;

    private $service;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Storage::fake('local');
        $this->service = app(TicketService::class);
    }

    private function makeUser(string $role): User
    {
        $user = User::create([
            'name' => ucfirst($role) . ' Tester',
            'email' => Str::random(10) . '@example.test',
            'password' => bcrypt('secret-pass'),
            'phone' => '0000000',
            'uuid' => (string) Str::uuid(),
            'status_id' => config('constants.status.active'),
        ]);
        $user->roles()->attach(Role::where('slug', $role)->firstOrFail()->id);

        return User::find($user->id);
    }

    private function ticketFor(User $owner, array $override = []): Ticket
    {
        return $this->service->create($owner, $override + [
            'subject' => 'Cannot upload documents',
            'description' => 'The upload button does nothing when I click it.',
            'category_id' => 1,
            'system_id' => 1,
            'priority_id' => 2,
        ]);
    }

    /** @test */
    public function employee_can_submit_a_ticket_and_it_gets_a_reference_and_due_date()
    {
        $owner = $this->makeUser('employee');

        $ticket = $this->ticketFor($owner);

        $this->assertMatchesRegularExpression('/^TKT-\d{4}-\d{4}$/', $ticket->reference);
        $this->assertSame(Ticket::STATUS_NEW, $ticket->status);
        $this->assertNotNull($ticket->due_date);
        $this->assertDatabaseHas('ticket_events', ['ticket_id' => $ticket->id, 'event' => 'created']);
        Mail::assertSent(TicketNotificationMail::class);
    }

    /** @test */
    public function users_only_see_their_own_tickets_and_cannot_open_others()
    {
        $a = $this->makeUser('employee');
        $b = $this->makeUser('employee');
        $ticket = $this->ticketFor($a);

        $this->assertSame(1, Ticket::visibleTo($a)->where('id', $ticket->id)->count());
        $this->assertSame(0, Ticket::visibleTo($b)->where('id', $ticket->id)->count());

        $this->actingAs($a)->get(route('admin.support.show', $ticket->id))->assertOk()->assertSee($ticket->reference);
        $this->actingAs($b)->get(route('admin.support.show', $ticket->id))->assertNotFound();
    }

    /** @test */
    public function employee_cannot_open_developer_or_admin_pages()
    {
        $owner = $this->makeUser('employee');

        foreach (['workspace', 'all', 'dashboard', 'reports', 'billing', 'settings'] as $page) {
            $this->actingAs($owner)->get(route('admin.support.' . $page))->assertForbidden();
        }
    }

    /** @test */
    public function full_ticket_lifecycle_follows_the_workflow()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $ticket = $this->ticketFor($owner);

        $this->service->accept($ticket, $dev);
        $this->assertSame(Ticket::STATUS_ASSIGNED, $ticket->fresh()->status);

        $this->service->logWork($ticket->fresh(), $dev, ['hours' => 1.5, 'description' => 'Investigated', 'work_type' => 'analysis']);
        $this->assertSame(Ticket::STATUS_IN_PROGRESS, $ticket->fresh()->status);

        // clarification -> awaiting feedback -> owner reply -> back in progress
        $this->service->addComment($ticket->fresh(), $dev, 'Which browser?', [], false, true);
        $this->assertSame(Ticket::STATUS_AWAITING_FEEDBACK, $ticket->fresh()->status);
        $this->service->addComment($ticket->fresh(), $owner, 'Chrome');
        $this->assertSame(Ticket::STATUS_IN_PROGRESS, $ticket->fresh()->status);

        $this->service->resolve($ticket->fresh(), $dev, ['resolution_notes' => 'Fixed the upload handler']);
        $this->assertSame(Ticket::STATUS_RESOLVED, $ticket->fresh()->status);

        $this->service->reopen($ticket->fresh(), $owner, 'Still failing on mobile');
        $reopened = $ticket->fresh();
        $this->assertSame(Ticket::STATUS_REOPENED, $reopened->status);
        $this->assertSame(1, $reopened->reopen_count);

        $this->service->changeStatus($reopened, $dev, Ticket::STATUS_IN_PROGRESS);
        $this->service->resolve($ticket->fresh(), $dev, ['resolution_notes' => 'Mobile layout fixed as well']);
        $this->service->close($ticket->fresh(), $owner);

        $closed = $ticket->fresh();
        $this->assertSame(Ticket::STATUS_CLOSED, $closed->status);
        $this->assertNotNull($closed->closed_at);
        $this->assertGreaterThan(8, $closed->events()->count());
    }

    /** @test */
    public function invalid_transitions_and_unauthorised_actions_are_rejected()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $ticket = $this->ticketFor($owner);

        // owner cannot drive the developer workflow
        try {
            $this->service->changeStatus($ticket, $owner, Ticket::STATUS_IN_PROGRESS);
            $this->fail('Owner should not change status');
        } catch (AuthorizationException $e) {
            $this->assertTrue(true);
        }

        // new -> resolved is not allowed
        try {
            $this->service->changeStatus($ticket, $dev, Ticket::STATUS_RESOLVED);
            $this->fail('new -> resolved must be rejected');
        } catch (ValidationException $e) {
            $this->assertTrue(true);
        }

        // resolving needs notes; on hold needs a reason
        $this->service->accept($ticket, $dev);
        $this->service->changeStatus($ticket->fresh(), $dev, Ticket::STATUS_IN_PROGRESS);
        $this->expectException(ValidationException::class);
        $this->service->changeStatus($ticket->fresh(), $dev, Ticket::STATUS_ON_HOLD);
    }

    /** @test */
    public function work_hours_must_use_quarter_hour_steps_and_resolution_needs_notes()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $ticket = $this->ticketFor($owner);
        $this->service->accept($ticket, $dev);

        try {
            $this->service->logWork($ticket->fresh(), $dev, ['hours' => 1.1, 'description' => 'x']);
            $this->fail('1.1 hours should be rejected');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('hours', $e->errors());
        }

        $this->service->logWork($ticket->fresh(), $dev, ['hours' => 0.25, 'description' => 'Quick look']);

        try {
            $this->service->resolve($ticket->fresh(), $dev, ['resolution_notes' => '']);
            $this->fail('Resolving without notes should be rejected');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('resolution_notes', $e->errors());
        }
    }

    /** @test */
    public function internal_notes_are_hidden_from_the_ticket_owner()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $ticket = $this->ticketFor($owner);
        $this->service->accept($ticket, $dev);

        $this->service->addComment($ticket->fresh(), $dev, 'SECRET-DEV-NOTE-123', [], true);
        $this->service->addComment($ticket->fresh(), $dev, 'Public update for you');

        $this->actingAs($owner)->get(route('admin.support.show', $ticket->id))
            ->assertOk()->assertSee('Public update for you')->assertDontSee('SECRET-DEV-NOTE-123');

        $this->actingAs($dev)->get(route('admin.support.show', $ticket->id))
            ->assertOk()->assertSee('SECRET-DEV-NOTE-123');

        // the owner may not post internal notes
        $this->expectException(AuthorizationException::class);
        $this->service->addComment($ticket->fresh(), $owner, 'sneaky', [], true);
    }

    /** @test */
    public function attachments_are_private_and_authorised_per_ticket()
    {
        $owner = $this->makeUser('employee');
        $other = $this->makeUser('employee');

        $file = UploadedFile::fake()->image('shot.png', 40, 40);
        $ticket = $this->service->create($owner, [
            'subject' => 'With attachment', 'description' => 'See the screenshot attached.',
            'category_id' => 1, 'system_id' => null, 'priority_id' => 2,
        ], [$file]);

        $attachment = $ticket->attachments()->firstOrFail();
        Storage::disk('local')->assertExists($attachment->path);
        $this->assertStringNotContainsString('shot', $attachment->path); // random stored name

        $this->actingAs($owner)->get(route('admin.support.attachment', $attachment->id))->assertOk();
        $this->actingAs($other)->get(route('admin.support.attachment', $attachment->id))->assertNotFound();
    }

    /** @test */
    public function dangerous_file_types_are_rejected()
    {
        $owner = $this->makeUser('employee');

        $this->expectException(ValidationException::class);
        $this->service->create($owner, [
            'subject' => 'Bad file', 'description' => 'Trying to upload a script.',
            'category_id' => 1, 'system_id' => null, 'priority_id' => 2,
        ], [UploadedFile::fake()->create('evil.php', 5, 'text/x-php')]);
    }

    /** @test */
    public function billing_approval_snapshots_the_rate_and_requires_permission()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $admin = $this->makeUser('admin');

        $ticket = $this->ticketFor($owner);
        $this->service->accept($ticket, $dev);
        $log = $this->service->logWork($ticket->fresh(), $dev, ['hours' => 2, 'description' => 'Fix']);

        // developers cannot approve their own billing
        try {
            $this->service->reviewBilling($log, $dev, 'approve');
            $this->fail('Developer must not approve billing');
        } catch (AuthorizationException $e) {
            $this->assertTrue(true);
        }

        $rate = TicketBillingRate::create([
            'name' => 'Test rate', 'hourly_rate' => 50, 'currency' => 'USD',
            'effective_from' => now()->subYear()->toDateString(), 'is_active' => true,
        ]);

        $log = $this->service->reviewBilling($log->fresh(), $admin, 'approve', 1.5);
        $this->assertSame('approved', $log->billing_status);
        $this->assertEquals(2.0, $log->hours);          // actual hours untouched
        $this->assertEquals(1.5, $log->billable_hours); // billable differs from actual
        $this->assertEquals(75.0, $log->billable_amount);

        // changing the rate later does not change approved work
        $rate->update(['hourly_rate' => 999]);
        $this->assertEquals(75.0, $log->fresh()->billable_amount);

        // cannot bill more than was worked
        $second = $this->service->logWork($ticket->fresh(), $dev, ['hours' => 1, 'description' => 'More']);
        $this->expectException(ValidationException::class);
        $this->service->reviewBilling($second, $admin, 'approve', 5);
    }

    /** @test */
    public function admin_pages_render()
    {
        $admin = $this->makeUser('admin');
        $owner = $this->makeUser('employee');
        $ticket = $this->ticketFor($owner);

        $routes = [
            route('admin.support.submit'),
            route('admin.support.my'),
            route('admin.support.all'),
            route('admin.support.show', $ticket->id),
            route('admin.support.workspace'),
            route('admin.support.dashboard'),
            route('admin.support.reports'),
            route('admin.support.billing'),
            route('admin.support.settings'),
        ];

        foreach ($routes as $url) {
            $this->actingAs($admin)->get($url)->assertOk();
        }
    }

    /** @test */
    public function every_report_builds_and_exports_to_excel_and_pdf()
    {
        $admin = $this->makeUser('admin');
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');

        $ticket = $this->ticketFor($owner, ['category_id' => 3]); // feature request
        $this->service->accept($ticket, $dev);
        $this->service->logWork($ticket->fresh(), $dev, ['hours' => 1, 'description' => 'Built it']);
        $this->service->resolve($ticket->fresh(), $dev, ['resolution_notes' => 'Feature delivered']);

        $service = app(SupportReportService::class);

        foreach (array_keys(SupportReportService::TYPES) as $type) {
            $report = $service->build($type, [], true);
            $this->assertNotEmpty($report['columns'], $type);
            foreach ($report['rows'] as $row) {
                $this->assertCount(count($report['columns']), $row, $type . ' row width');
            }

            // Excel file is a valid zip with the data in it
            $path = XlsxWriter::build($report['title'], $report['subtitle'], $report['columns'], $report['rows'], $report['totals']);
            $zip = new ZipArchive();
            $this->assertTrue($zip->open($path) === true, $type . ' xlsx opens');
            $this->assertNotFalse($zip->getFromName('xl/worksheets/sheet1.xml'));
            $zip->close();
            @unlink($path);

            $this->actingAs($admin)
                ->get(route('admin.support.reports.export', ['type' => $type, 'format' => 'xlsx']))
                ->assertOk();
            $this->actingAs($admin)
                ->get(route('admin.support.reports.export', ['type' => $type, 'format' => 'pdf']))
                ->assertOk()->assertHeader('content-type', 'application/pdf');
        }

        $delivered = $service->build('delivered', ['from' => now()->subDay()->toDateString(), 'to' => now()->toDateString()]);
        $this->assertGreaterThanOrEqual(1, count($delivered['rows']));
    }

    /** @test */
    public function report_exports_require_permission()
    {
        $owner = $this->makeUser('employee');

        $this->actingAs($owner)
            ->get(route('admin.support.reports.export', ['type' => 'received', 'format' => 'xlsx']))
            ->assertForbidden();
    }
}
