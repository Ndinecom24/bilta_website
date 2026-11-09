<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\LeavePage\MyLeaveApplications;
use App\Http\Livewire\Admin\LeavePage\ShowLeaveApplications;
use App\Http\Livewire\Admin\ShowBranches;
use App\Models\Bilta\ApprovalWorkflow;
use App\Models\Bilta\ApprovalWorkflowStage;
use App\Models\Bilta\Branch;
use App\Models\Bilta\BranchApprover;
use App\Models\Bilta\LeaveApplication;
use App\Models\Bilta\LeaveBalance;
use App\Models\Bilta\LeaveType;
use App\Models\System\Role;
use App\Models\User;
use App\Services\Leave\LeaveApproverResolver;
use App\Services\Leave\LeaveStatusOverrideService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class LeaveBranchApprovalTest extends TestCase
{
    use DatabaseTransactions;

    private $resolver;
    private $leaveType;
    private $workflow;
    private $stages = [];

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        $this->resolver = app(LeaveApproverResolver::class);

        $this->leaveType = LeaveType::create([
            'name' => 'Test Leave',
            'slug' => 'test-leave-' . Str::random(6),
            'default_days' => 21,
            'status_id' => 1,
        ]);

        // 1. Supervisor  ->  2. HR Manager  ->  3. Company Secretariat (end)
        $this->workflow = ApprovalWorkflow::create([
            'name' => 'Test flow ' . Str::random(4),
            'form_type' => 'leave',
            'is_active' => false,
        ]);
        $definition = [
            1 => ['Supervisor review', 'supervisor', true, false],
            2 => ['HR review', 'hr-manager', false, false],
            3 => ['Secretariat sign-off', 'company-secretariat', false, true],
        ];
        foreach ($definition as $order => [$name, $role, $start, $end]) {
            $this->stages[$order] = ApprovalWorkflowStage::create([
                'workflow_id' => $this->workflow->id,
                'name' => $name,
                'role_id' => $this->role($role)->id,
                'stage_order' => $order,
                'is_start' => $start,
                'is_end' => $end,
            ]);
        }
    }

    /* ---------- helpers ---------- */

    private function role(string $slug): Role
    {
        return Role::where('slug', $slug)->firstOrFail();
    }

    private function makeUser(array $roles = [], array $attributes = [], bool $canApprove = false): User
    {
        $user = User::create($attributes + [
            'name' => 'Tester ' . Str::random(6),
            'email' => Str::random(10) . '@example.test',
            'password' => bcrypt('secret-pass'),
            'phone' => '0000000',
            'uuid' => (string) Str::uuid(),
            'status_id' => config('constants.status.active'),
        ]);

        foreach ($roles as $slug) {
            $user->roles()->attach($this->role($slug)->id);
        }
        if ($canApprove) {
            $user->givePermissionsTo('approve-reject-leave');
        }

        return User::find($user->id);
    }

    private function makeBranch(string $name = null): Branch
    {
        $name = $name ?: 'Branch ' . Str::random(5);

        return Branch::create(['name' => $name, 'slug' => Str::slug($name) . '-' . Str::random(4), 'status_id' => 1]);
    }

    private function assign(Branch $branch, string $roleSlug, User ...$users): void
    {
        foreach ($users as $user) {
            BranchApprover::create(['branch_id' => $branch->id, 'role_id' => $this->role($roleSlug)->id, 'user_id' => $user->id]);
        }
    }

    private function makeApplication(User $applicant, int $stageOrder = 1, array $override = []): LeaveApplication
    {
        return LeaveApplication::create($override + [
            'user_id' => $applicant->id,
            'leave_type_id' => $this->leaveType->id,
            'start_date' => '2026-12-01',
            'end_date' => '2026-12-03',
            'days_requested' => 3,
            'reason' => 'Family matter at home',
            'status' => 'pending',
            'workflow_id' => $this->workflow->id,
            'current_stage_id' => $this->stages[$stageOrder]->id,
        ]);
    }

    private function ids($users): array
    {
        return collect($users)->pluck('id')->sort()->values()->all();
    }

    /* ---------- who reviews at each stage ---------- */

    /** @test */
    public function supervisor_stage_shows_only_the_direct_supervisor()
    {
        $tembo = $this->makeUser(['supervisor'], ['name' => 'Tembo'], true);
        $otherSupervisor = $this->makeUser(['supervisor'], [], true);
        $applicant = $this->makeUser(['employee'], ['supervisor_id' => $tembo->id]);

        $application = $this->makeApplication($applicant);
        $approvers = $this->resolver->approversFor($application, $this->stages[1]);

        $this->assertSame([$tembo->id], $this->ids($approvers));
        $this->assertFalse($approvers->contains('id', $otherSupervisor->id));
    }

    /** @test */
    public function supervisor_stage_also_includes_supervisors_assigned_to_the_applicants_branch()
    {
        $branch = $this->makeBranch();
        $tembo = $this->makeUser(['supervisor'], [], true);
        $branchSupervisor = $this->makeUser(['supervisor'], [], true);
        $elsewhere = $this->makeUser(['supervisor'], [], true);
        $this->assign($branch, 'supervisor', $branchSupervisor);
        $this->assign($this->makeBranch(), 'supervisor', $elsewhere);

        $applicant = $this->makeUser(['employee'], ['supervisor_id' => $tembo->id, 'branch_id' => $branch->id]);
        $application = $this->makeApplication($applicant);

        $approvers = $this->resolver->approversFor($application, $this->stages[1]);

        $this->assertSame($this->ids([$tembo, $branchSupervisor]), $this->ids($approvers));
        $this->assertFalse($approvers->contains('id', $elsewhere->id));
    }

    /** @test */
    public function one_person_can_supervise_several_branches()
    {
        $me = $this->makeUser(['supervisor'], [], true);
        $branchOne = $this->makeBranch();
        $branchTwo = $this->makeBranch();
        $this->assign($branchOne, 'supervisor', $me);
        $this->assign($branchTwo, 'supervisor', $me);

        foreach ([$branchOne, $branchTwo] as $branch) {
            $applicant = $this->makeUser(['employee'], ['branch_id' => $branch->id]);
            $approvers = $this->resolver->approversFor($this->makeApplication($applicant), $this->stages[1]);
            $this->assertSame([$me->id], $this->ids($approvers));
        }
    }

    /** @test */
    public function other_roles_are_limited_to_the_people_assigned_for_the_branch()
    {
        $branch = $this->makeBranch();
        $hrForBranch = $this->makeUser(['hr-manager'], [], true);
        $hrOther = $this->makeUser(['hr-manager'], [], true);
        $this->assign($branch, 'hr-manager', $hrForBranch);

        $applicant = $this->makeUser(['employee'], ['branch_id' => $branch->id]);
        $approvers = $this->resolver->approversFor($this->makeApplication($applicant, 2), $this->stages[2]);

        $this->assertSame([$hrForBranch->id], $this->ids($approvers));
        $this->assertFalse($approvers->contains('id', $hrOther->id));
    }

    /** @test */
    public function a_role_with_no_branch_assignment_falls_back_to_everyone_holding_the_role()
    {
        $hrOne = $this->makeUser(['hr-manager'], [], true);
        $hrTwo = $this->makeUser(['hr-manager'], [], true);

        // applicant with no branch at all
        $noBranch = $this->makeUser(['employee']);
        // applicant in a branch that has nobody assigned for HR
        $branch = $this->makeBranch();
        $withBranch = $this->makeUser(['employee'], ['branch_id' => $branch->id]);

        foreach ([$noBranch, $withBranch] as $applicant) {
            $approvers = $this->resolver->approversFor($this->makeApplication($applicant, 2), $this->stages[2]);
            $this->assertTrue($approvers->contains('id', $hrOne->id));
            $this->assertTrue($approvers->contains('id', $hrTwo->id));
        }
    }

    /** @test */
    public function assigned_people_must_still_hold_the_role_and_the_approval_permission_and_cannot_review_themselves()
    {
        $branch = $this->makeBranch();
        $noRole = $this->makeUser(['employee'], [], true);         // assigned, but lost the supervisor role
        $noPermission = $this->makeUser(['supervisor'], [], false); // role without permission
        $noPermission->permissions()->detach();
        $this->assign($branch, 'supervisor', $noRole, $noPermission);

        $selfApprover = $this->makeUser(['supervisor'], ['branch_id' => $branch->id], true);
        $this->assign($branch, 'supervisor', $selfApprover);

        $application = $this->makeApplication($selfApprover);
        $approvers = $this->resolver->approversFor($application, $this->stages[1]);

        $this->assertFalse($approvers->contains('id', $noRole->id));
        $this->assertFalse($approvers->contains('id', $selfApprover->id));
    }

    /** @test */
    public function only_the_listed_approvers_can_act_on_the_application()
    {
        $branch = $this->makeBranch();
        $tembo = $this->makeUser(['supervisor'], [], true);
        $branchSupervisor = $this->makeUser(['supervisor'], [], true);
        $stranger = $this->makeUser(['supervisor'], [], true);
        $this->assign($branch, 'supervisor', $branchSupervisor);

        $applicant = $this->makeUser(['employee'], ['supervisor_id' => $tembo->id, 'branch_id' => $branch->id]);
        $application = $this->makeApplication($applicant);

        $this->assertTrue($this->resolver->canAct($tembo, $application));
        $this->assertTrue($this->resolver->canAct($branchSupervisor, $application));
        $this->assertFalse($this->resolver->canAct($stranger, $application));
        $this->assertFalse($this->resolver->canAct($applicant, $application));

        // once finalised nobody can act any more
        $application->update(['status' => 'approved', 'current_stage_id' => null]);
        $this->assertFalse($this->resolver->canAct($tembo, $application->fresh()));
    }

    /** @test */
    public function stage_progress_lists_only_the_people_who_will_work_on_each_stage()
    {
        $branch = $this->makeBranch();
        $tembo = $this->makeUser(['supervisor'], ['name' => 'Tembo'], true);
        $hrForBranch = $this->makeUser(['hr-manager'], ['name' => 'Branch HR'], true);
        $this->makeUser(['supervisor'], ['name' => 'Unrelated Supervisor'], true);
        $this->assign($branch, 'hr-manager', $hrForBranch);

        $applicant = $this->makeUser(['employee'], ['supervisor_id' => $tembo->id, 'branch_id' => $branch->id]);
        $application = $this->makeApplication($applicant);

        $progress = $this->resolver->stageProgress($application);

        $this->assertSame(['current', 'upcoming', 'upcoming'], $progress->pluck('state')->all());
        $this->assertSame([$tembo->id], $this->ids($progress[0]['approvers']));
        $this->assertSame([$hrForBranch->id], $this->ids($progress[1]['approvers']));
    }

    /* ---------- admin: move forwards / backwards ---------- */

    /** @test */
    public function admin_can_move_an_application_backwards_and_forwards_between_stages()
    {
        $admin = $this->makeUser(['admin']);
        $applicant = $this->makeUser(['employee']);
        $application = $this->makeApplication($applicant, 2);
        $service = app(LeaveStatusOverrideService::class);

        // back to stage 1
        $result = $service->apply($application->id, 'stage:' . $this->stages[1]->id, 'Sent back for correction', $admin);
        $this->assertNotNull($result);
        $application->refresh();
        $this->assertSame('pending', $application->status);
        $this->assertSame($this->stages[1]->id, (int) $application->current_stage_id);
        $this->assertStringContainsString('Moved back', $result[3]);

        // forward to the last stage
        $result = $service->apply($application->id, 'stage:' . $this->stages[3]->id, 'Urgent - skip HR', $admin);
        $application->refresh();
        $this->assertSame($this->stages[3]->id, (int) $application->current_stage_id);
        $this->assertStringContainsString('Moved forward', $result[3]);

        // moving to where it already is changes nothing
        $this->assertNull($service->apply($application->id, 'stage:' . $this->stages[3]->id, 'Again', $admin));

        $this->assertSame(2, $application->approvalHistory()->where('action', 'overridden')->count());
    }

    /** @test */
    public function moving_an_approved_application_back_gives_the_leave_days_back()
    {
        $admin = $this->makeUser(['admin']);
        $applicant = $this->makeUser(['employee']);
        $application = $this->makeApplication($applicant, 3);
        $service = app(LeaveStatusOverrideService::class);

        $service->apply($application->id, 'approved', 'Approved on paper', $admin);
        $used = function () use ($applicant) {
            return (float) LeaveBalance::where('user_id', $applicant->id)
                ->where('leave_type_id', $this->leaveType->id)->where('year', 2026)->value('used_days');
        };
        $this->assertSame(3.0, $used());
        $this->assertSame('approved', $application->fresh()->status);

        $service->apply($application->id, 'stage:' . $this->stages[2]->id, 'Approved by mistake', $admin);
        $application->refresh();
        $this->assertSame(0.0, $used());
        $this->assertSame('pending', $application->status);
        $this->assertSame($this->stages[2]->id, (int) $application->current_stage_id);
        $this->assertNull($application->reviewed_by);
    }

    /** @test */
    public function a_stage_from_another_workflow_is_rejected()
    {
        $admin = $this->makeUser(['admin']);
        $application = $this->makeApplication($this->makeUser(['employee']));

        $this->expectException(\Illuminate\Validation\ValidationException::class);
        app(LeaveStatusOverrideService::class)->apply($application->id, 'stage:99999999', 'Nope', $admin);
    }

    /** @test */
    public function override_targets_list_every_stage_except_where_the_application_already_is()
    {
        $application = $this->makeApplication($this->makeUser(['employee']), 2);
        $targets = app(LeaveStatusOverrideService::class)->targetsFor($application->load('workflow.stages'));

        $this->assertArrayHasKey('stage:' . $this->stages[1]->id, $targets);
        $this->assertArrayNotHasKey('stage:' . $this->stages[2]->id, $targets);
        $this->assertArrayHasKey('stage:' . $this->stages[3]->id, $targets);
        $this->assertArrayHasKey('approved', $targets);
        $this->assertArrayHasKey('rejected', $targets);
        $this->assertArrayHasKey('cancelled', $targets);
    }

    /** @test */
    public function the_my_applications_page_lets_a_permitted_admin_move_the_application()
    {
        $admin = $this->makeUser(['admin']);
        $admin->givePermissionsTo('override-leave-status');
        $admin = User::find($admin->id);
        $application = $this->makeApplication($admin, 2);

        Livewire::actingAs($admin)->test(MyLeaveApplications::class)
            ->call('viewApplication', $application->id)
            ->call('startOverride', $application->id)
            ->set('overrideTarget', 'stage:' . $this->stages[1]->id)
            ->set('overrideComment', 'Moving back to the supervisor')
            ->call('submitOverride')
            ->assertHasNoErrors();

        $this->assertSame($this->stages[1]->id, (int) $application->fresh()->current_stage_id);
    }

    /** @test */
    public function people_without_the_override_permission_cannot_move_an_application()
    {
        $employee = $this->makeUser(['employee']);
        $application = $this->makeApplication($employee, 2);

        Livewire::actingAs($employee)->test(MyLeaveApplications::class)
            ->call('viewApplication', $application->id)
            ->call('startOverride', $application->id)
            ->assertStatus(403);

        $this->assertSame($this->stages[2]->id, (int) $application->fresh()->current_stage_id);
    }

    /* ---------- visibility ---------- */

    /** @test */
    public function branch_approvers_see_applications_from_their_branch_only()
    {
        $branch = $this->makeBranch();
        $otherBranch = $this->makeBranch();
        $approver = $this->makeUser(['supervisor'], ['name' => 'Branch Approver'], true);
        $this->assign($branch, 'supervisor', $approver);

        $inBranch = $this->makeUser(['employee'], ['name' => 'Zed Insidebranch', 'branch_id' => $branch->id]);
        $outside = $this->makeUser(['employee'], ['name' => 'Yan Outsidebranch', 'branch_id' => $otherBranch->id]);
        $this->makeApplication($inBranch);
        $this->makeApplication($outside);

        Livewire::actingAs($approver)->test(ShowLeaveApplications::class)
            ->assertSee('Zed Insidebranch')
            ->assertDontSee('Yan Outsidebranch');
    }

    /* ---------- branch management ---------- */

    /** @test */
    public function branch_manager_assigns_people_to_a_role_for_a_branch()
    {
        $manager = $this->makeUser(['employee']);
        $manager->givePermissionsTo('edit-branches');
        $manager = User::find($manager->id);

        $branch = $this->makeBranch();
        $supervisorOne = $this->makeUser(['supervisor']);
        $supervisorTwo = $this->makeUser(['supervisor']);
        $notASupervisor = $this->makeUser(['employee']);
        $roleId = $this->role('supervisor')->id;

        $component = Livewire::actingAs($manager)->test(ShowBranches::class)
            ->call('viewBranch', $branch->id)
            ->set('approverRoleId', $roleId)
            ->set('approverUserIds', [(string) $supervisorOne->id, (string) $supervisorTwo->id, (string) $notASupervisor->id])
            ->call('saveApprovers')
            ->assertHasNoErrors();

        $saved = BranchApprover::where('branch_id', $branch->id)->where('role_id', $roleId)->pluck('user_id')->all();
        $this->assertEqualsCanonicalizing([$supervisorOne->id, $supervisorTwo->id], $saved);

        // re-selecting the role pre-ticks the saved people; unticking one removes them
        $component->set('approverRoleId', '')
            ->set('approverRoleId', $roleId)
            ->assertSet('approverUserIds', [(string) $supervisorOne->id, (string) $supervisorTwo->id])
            ->set('approverUserIds', [(string) $supervisorTwo->id])
            ->call('saveApprovers');

        $this->assertSame([$supervisorTwo->id], BranchApprover::where('branch_id', $branch->id)->pluck('user_id')->all());
    }

    /** @test */
    public function branch_approvers_cannot_be_changed_without_the_edit_permission()
    {
        $viewer = $this->makeUser(['employee']);
        $branch = $this->makeBranch();
        $supervisor = $this->makeUser(['supervisor']);

        Livewire::actingAs($viewer)->test(ShowBranches::class)
            ->call('viewBranch', $branch->id)
            ->set('approverRoleId', $this->role('supervisor')->id)
            ->set('approverUserIds', [(string) $supervisor->id])
            ->call('saveApprovers');

        $this->assertSame(0, BranchApprover::where('branch_id', $branch->id)->count());
    }
}
