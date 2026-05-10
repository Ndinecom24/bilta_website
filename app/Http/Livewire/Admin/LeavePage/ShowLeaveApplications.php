<?php

namespace App\Http\Livewire\Admin\LeavePage;

use App\Mail\LeaveApprovalRequestMail;
use App\Mail\LeaveStatusUpdateMail;
use App\Models\Bilta\ApprovalHistory;
use App\Models\Bilta\LeaveApplication;
use App\Models\Bilta\LeaveBalance;
use App\Models\Bilta\LeaveType;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;

class ShowLeaveApplications extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $filterYear = '';
    public $filterUser = '';

    // Review modal
    public $reviewingId = null;
    public $reviewComment = '';
    public $reviewAction = '';

    // View detail
    public $viewingApplication = null;

    protected $listeners = ['deleteLeaveApplication' => 'destroy'];

    public function render()
    {
        $query = LeaveApplication::with(['user', 'leaveType', 'reviewer', 'currentStage.role', 'workflow'])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected', 'cancelled')")
            ->orderBy('created_at', 'desc');

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }
        if ($this->filterYear) {
            $query->whereYear('start_date', $this->filterYear);
        }
        if ($this->filterUser) {
            $query->where('user_id', $this->filterUser);
        }

        $applications = $query->paginate(20);
        $users = User::orderBy('name')->get(['id', 'name']);

        // Summary stats
        $stats = [
            'pending' => LeaveApplication::where('status', 'pending')->count(),
            'approved' => LeaveApplication::where('status', 'approved')->whereYear('start_date', date('Y'))->count(),
            'rejected' => LeaveApplication::where('status', 'rejected')->whereYear('start_date', date('Y'))->count(),
            'total' => LeaveApplication::whereYear('start_date', date('Y'))->count(),
        ];

        return view('livewire.admin.leave-page.leave-applications', compact('applications', 'users', 'stats'));
    }

    public function viewApplication($id)
    {
        $this->viewingApplication = LeaveApplication::with([
            'user', 'leaveType', 'reviewer',
            'currentStage.role.users', 'workflow.stages.role.users',
            'approvalHistory.actor', 'approvalHistory.stage',
        ])->findOrFail($id);
    }

    public function closeView()
    {
        $this->viewingApplication = null;
    }

    /**
     * Check if the current user can act on an application at its current stage.
     */
    public function canActOnApplication(LeaveApplication $application): bool
    {
        if ($application->status !== 'pending' || !$application->currentStage) {
            return false;
        }

        // Check if current user has the role required for this stage
        $requiredRoleId = $application->currentStage->role_id;
        return auth()->user()->roles->contains('id', $requiredRoleId);
    }

    public function startReview($id, $action)
    {
        $application = LeaveApplication::with('currentStage')->findOrFail($id);

        if (!$this->canActOnApplication($application)) {
            session()->flash('error', 'You do not have the required role to act on this application at its current stage.');
            return;
        }

        $this->reviewingId = $id;
        $this->reviewAction = $action;
        $this->reviewComment = '';
    }

    public function cancelReview()
    {
        $this->reviewingId = null;
        $this->reviewComment = '';
        $this->reviewAction = '';
    }

    public function submitReview()
    {
        $application = LeaveApplication::with(['currentStage', 'user', 'leaveType'])->findOrFail($this->reviewingId);

        if ($application->status !== 'pending') {
            session()->flash('error', 'This application has already been finalized.');
            $this->cancelReview();
            return;
        }

        if (!$this->canActOnApplication($application)) {
            session()->flash('error', 'You do not have the required role for this approval stage.');
            $this->cancelReview();
            return;
        }

        $currentStage = $application->currentStage;
        $actorName = auth()->user()->name;

        // Record approval history
        ApprovalHistory::create([
            'leave_application_id' => $application->id,
            'stage_id' => $currentStage->id,
            'acted_by' => auth()->id(),
            'action' => $this->reviewAction,
            'comment' => $this->reviewComment,
        ]);

        if ($this->reviewAction === 'rejected') {
            // Rejected at any stage → application is rejected
            $application->update([
                'status' => 'rejected',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_comment' => $this->reviewComment,
            ]);

            $this->notifyApplicant($application, 'rejected', $this->reviewComment, $actorName, $currentStage->name);
            session()->flash('success', 'Leave application rejected at "' . $currentStage->name . '".');

        } elseif ($this->reviewAction === 'approved') {
            $nextStage = $currentStage->nextStage();

            if ($currentStage->is_end || !$nextStage) {
                // Final stage approved → fully approved
                $application->update([
                    'status' => 'approved',
                    'current_stage_id' => null,
                    'reviewed_by' => auth()->id(),
                    'reviewed_at' => now(),
                    'review_comment' => $this->reviewComment,
                ]);

                // Update leave balance
                $balance = LeaveBalance::firstOrCreate(
                    [
                        'user_id' => $application->user_id,
                        'leave_type_id' => $application->leave_type_id,
                        'year' => $application->start_date->year,
                    ],
                    [
                        'total_days' => LeaveType::find($application->leave_type_id)->default_days ?? 0,
                        'used_days' => 0,
                        'carried_over' => 0,
                    ]
                );
                $balance->increment('used_days', $application->days_requested);

                $this->notifyApplicant($application, 'approved', $this->reviewComment, $actorName, $currentStage->name);
                session()->flash('success', 'Leave application FULLY APPROVED (final stage: "' . $currentStage->name . '").');

            } else {
                // Move to next stage
                $application->update([
                    'current_stage_id' => $nextStage->id,
                ]);

                // Notify applicant of stage progress
                $this->notifyApplicant($application, 'approved', $this->reviewComment, $actorName, $currentStage->name);

                // Notify next stage approvers
                $this->notifyStageApprovers($application, $nextStage);

                session()->flash('success', 'Approved at "' . $currentStage->name . '". Application moved to: "' . $nextStage->name . '".');
            }
        }

        $this->cancelReview();
    }

    public function destroy($id)
    {
        try {
            LeaveApplication::find($id)->delete();
            session()->flash('success', 'Leave application deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting application.');
        }
    }

    public function clearFilters()
    {
        $this->filterStatus = '';
        $this->filterYear = '';
        $this->filterUser = '';
        $this->resetPage();
    }

    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingFilterYear()   { $this->resetPage(); }
    public function updatingFilterUser()   { $this->resetPage(); }

    /* ---- Email helpers ---- */

    private function notifyApplicant(LeaveApplication $application, string $action, ?string $comment, string $actorName, string $stageName)
    {
        try {
            Mail::to($application->user->email)->send(
                new LeaveStatusUpdateMail($application, $action, $comment, $actorName, $stageName)
            );
        } catch (\Exception $e) {
            // Silently fail
        }
    }

    private function notifyStageApprovers(LeaveApplication $application, $stage)
    {
        try {
            $approvers = User::whereHas('roles', function ($q) use ($stage) {
                $q->where('roles.id', $stage->role_id);
            })->get();

            foreach ($approvers as $approver) {
                Mail::to($approver->email)->send(new LeaveApprovalRequestMail($application, $stage));
            }
        } catch (\Exception $e) {
            // Silently fail
        }
    }
}
