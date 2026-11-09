<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\Support\BillingReview;
use App\Http\Livewire\Admin\Support\DeveloperWorkspace;
use App\Http\Livewire\Admin\Support\MyTickets;
use App\Http\Livewire\Admin\Support\SubmitTicket;
use App\Http\Livewire\Admin\Support\SupportSettings;
use App\Http\Livewire\Admin\Support\TicketShow;
use App\Models\Support\Ticket;
use App\Models\Support\TicketBillingRate;
use App\Models\System\Role;
use App\Models\User;
use App\Services\Support\TicketService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class SupportTicketingLivewireTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Storage::fake('local');
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

    private function ticketFor(User $owner): Ticket
    {
        return app(TicketService::class)->create($owner, [
            'subject' => 'Livewire ticket', 'description' => 'Something is wrong on the page.',
            'category_id' => 1, 'system_id' => 1, 'priority_id' => 2,
        ]);
    }

    /** @test */
    public function submit_form_validates_and_creates_a_ticket_with_an_attachment()
    {
        $owner = $this->makeUser('employee');
        $this->actingAs($owner);

        Livewire::test(SubmitTicket::class)
            ->set('subject', 'abc')
            ->call('submit')
            ->assertHasErrors(['subject', 'description', 'category_id']);

        Livewire::test(SubmitTicket::class)
            ->set('subject', 'Printer page is broken')
            ->set('description', 'The print preview shows a blank page every time.')
            ->set('category_id', 1)
            ->set('priority_id', 2)
            ->set('attachments', [UploadedFile::fake()->image('error.png', 30, 30)])
            ->call('submit')
            ->assertHasNoErrors()
            ->assertRedirect();

        $ticket = Ticket::where('submitted_by', $owner->id)->latest('id')->firstOrFail();
        $this->assertSame('Printer page is broken', $ticket->subject);
        $this->assertSame(1, $ticket->attachments()->count());
    }

    /** @test */
    public function submit_form_rejects_executable_uploads()
    {
        $this->actingAs($this->makeUser('employee'));

        Livewire::test(SubmitTicket::class)
            ->set('attachments', [UploadedFile::fake()->create('run.exe', 10, 'application/x-msdownload')])
            ->assertHasErrors(['attachments.0']);
    }

    /** @test */
    public function my_tickets_lists_only_own_tickets()
    {
        $a = $this->makeUser('employee');
        $b = $this->makeUser('employee');
        $mine = $this->ticketFor($a);
        $theirs = $this->ticketFor($b);

        $this->actingAs($a);
        Livewire::test(MyTickets::class)
            ->assertSee($mine->reference)
            ->assertDontSee($theirs->reference)
            ->set('search', 'nothing-matches-this')
            ->assertDontSee($mine->reference);
    }

    /** @test */
    public function owner_and_developer_can_converse_and_resolve_through_the_ticket_page()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $ticket = $this->ticketFor($owner);

        $this->actingAs($dev);
        Livewire::test(TicketShow::class, ['ticket' => $ticket->id])
            ->call('acceptTicket')
            ->set('work_hours', 1.5)
            ->set('work_description', 'Reproduced the problem')
            ->call('logWork')
            ->assertHasNoErrors()
            ->set('commentBody', 'Please send a screenshot')
            ->set('commentType', 'clarification')
            ->call('postComment')
            ->assertHasNoErrors();

        $this->assertSame(Ticket::STATUS_AWAITING_FEEDBACK, $ticket->fresh()->status);

        $this->actingAs($owner);
        Livewire::test(TicketShow::class, ['ticket' => $ticket->id])
            ->set('commentBody', 'Here you go')
            ->call('postComment')
            ->assertHasNoErrors();
        $this->assertSame(Ticket::STATUS_IN_PROGRESS, $ticket->fresh()->status);

        $this->actingAs($dev);
        Livewire::test(TicketShow::class, ['ticket' => $ticket->id])
            ->call('resolveTicket')
            ->assertHasErrors(['resolution_notes'])
            ->set('resolution_notes', 'Replaced the broken template')
            ->call('resolveTicket')
            ->assertHasNoErrors();
        $this->assertSame(Ticket::STATUS_RESOLVED, $ticket->fresh()->status);

        $this->actingAs($owner);
        Livewire::test(TicketShow::class, ['ticket' => $ticket->id])
            ->call('closeTicket');
        $this->assertSame(Ticket::STATUS_CLOSED, $ticket->fresh()->status);
    }

    /** @test */
    public function the_ticket_page_hides_developer_forms_from_the_owner()
    {
        $owner = $this->makeUser('employee');
        $ticket = $this->ticketFor($owner);

        $this->actingAs($owner);
        Livewire::test(TicketShow::class, ['ticket' => $ticket->id])
            ->assertDontSee('Developer Actions')
            ->assertDontSee('Log Work')
            ->assertDontSee('Work Log');
    }

    /** @test */
    public function developer_workspace_lets_a_developer_accept_from_the_queue()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $ticket = $this->ticketFor($owner);

        $this->actingAs($dev);
        Livewire::test(DeveloperWorkspace::class)
            ->call('setTab', 'unassigned')
            ->assertSee($ticket->reference)
            ->call('accept', $ticket->id);

        $this->assertSame($dev->id, $ticket->fresh()->assigned_to);
    }

    /** @test */
    public function billing_review_approves_with_the_applicable_rate()
    {
        $owner = $this->makeUser('employee');
        $dev = $this->makeUser('support-developer');
        $admin = $this->makeUser('admin');
        $service = app(TicketService::class);

        $ticket = $this->ticketFor($owner);
        $service->accept($ticket, $dev);
        $log = $service->logWork($ticket->fresh(), $dev, ['hours' => 2, 'description' => 'Work']);
        TicketBillingRate::create([
            'name' => 'Rate', 'hourly_rate' => 40, 'currency' => 'USD',
            'effective_from' => now()->subYear()->toDateString(), 'is_active' => true,
        ]);

        $this->actingAs($admin);
        Livewire::test(BillingReview::class)
            ->call('approve', $log->id)
            ->assertHasNoErrors();

        $log = $log->fresh();
        $this->assertSame('approved', $log->billing_status);
        $this->assertEquals(80.0, $log->billable_amount);
    }

    /** @test */
    public function settings_page_manages_lookups_and_rates()
    {
        $admin = $this->makeUser('admin');
        $this->actingAs($admin);

        Livewire::test(SupportSettings::class)
            ->set('name', 'Security Concern')
            ->set('sort_order', 9)
            ->call('save')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('ticket_categories', ['name' => 'Security Concern', 'slug' => 'security-concern']);

        Livewire::test(SupportSettings::class)
            ->call('setTab', 'rates')
            ->set('name', 'Standard')
            ->set('hourly_rate', 35)
            ->set('currency', 'usd')
            ->set('effective_from', now()->toDateString())
            ->call('save')
            ->assertHasNoErrors();
        $this->assertDatabaseHas('ticket_billing_rates', ['name' => 'Standard', 'currency' => 'USD']);
    }
}
