<?php

namespace App\Http\Livewire\Admin\LeavePage;

use App\Mail\LeaveApprovalRequestMail;
use App\Mail\LeaveStatusUpdateMail;
use App\Models\Bilta\ApprovalHistory;
use Illuminate\Support\Facades\DB;
use App\Models\Bilta\LeaveApplication;
use App\Models\Bilta\LeaveBalance;
use App\Models\Bilta\LeaveType;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    public $signatureData = '';

    // Admin status override
    public $overridingId = null;
    public $overrideStatus = '';
    public $overrideComment = '';

    // View detail
    public $viewingApplication = null;

    protected $listeners = ['deleteLeaveApplication' => 'destroy'];

    public function render()
    {
        $actor = auth()->user();
        $visibleApplications = $this->visibleApplicationsQuery($actor);
        $query = (clone $visibleApplications)
            ->with(['user', 'leaveType', 'reviewer', 'currentStage.role', 'workflow'])
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
        $users = User::whereIn('id', (clone $visibleApplications)->select('user_id')->distinct())
            ->orderBy('name')
            ->get(['id', 'name']);

        // Keep the summary counts within the same visibility boundary as the queue.
        $stats = [
            'pending' => (clone $visibleApplications)->where('status', 'pending')->count(),
            'approved' => (clone $visibleApplications)->where('status', 'approved')->whereYear('start_date', date('Y'))->count(),
            'rejected' => (clone $visibleApplications)->where('status', 'rejected')->whereYear('start_date', date('Y'))->count(),
            'total' => (clone $visibleApplications)->whereYear('start_date', date('Y'))->count(),
        ];

        return view('livewire.admin.leave-page.leave-applications', compact('applications', 'users', 'stats'));
    }

    private function visibleApplicationsQuery(User $actor)
    {
        $query = LeaveApplication::query();

        // Managers, executives, and users with global visibility can see all applications
        if ($actor->can('manage-leave-applications') || $actor->can('view-all-leave-applications') || $actor->can('override-leave-status') || $actor->hasRole('senior-executive')) {
            return $query;
        }

        $departmentIds = $this->teamDepartmentIds($actor);
        $query->where(function ($visible) use ($actor) {
            $visible->where('user_id', $actor->id);
        });

        $query->orWhere(function ($visible) use ($actor, $departmentIds) {
            if ($actor->can('approve-reject-leave')) {
                $visible->whereHas('user', function ($applicant) use ($actor, $departmentIds) {
                    $applicant->where('supervisor_id', $actor->id);
                    if ($departmentIds->isNotEmpty()) {
                        $applicant->orWhereIn('department_id', $departmentIds)
                            ->orWhereHas('departmentResponsibilities', function ($responsibilities) use ($departmentIds) {
                                $responsibilities->whereIn('departments.id', $departmentIds);
                            });
                    }
                });
            }

            if ($actor->hasRole('supervisor')) {
                $visible->orWhereHas('user', function ($applicant) use ($actor) {
                    $applicant->where('supervisor_id', $actor->id);
                });
            }
        });

        return $query;
    }

    private function teamDepartmentIds(User $actor)
    {
        return collect([$actor->department_id])
            ->merge($actor->departmentResponsibilities()->pluck('departments.id'))
            ->filter()
            ->unique()
            ->values();
    }

    public function viewApplication($id)
    {
        $application = $this->visibleApplicationsQuery(auth()->user())->with([
            'user', 'leaveType', 'reviewer',
            'currentStage.role.users', 'workflow.stages.role.users',
            'approvalHistory.actor', 'approvalHistory.stage',
        ])->findOrFail($id);

        $this->viewingApplication = $application;
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
        $actor = auth()->user();
        if (!$actor || (int) $application->user_id === (int) $actor->id || !$actor->can('approve-reject-leave') || $application->status !== 'pending' || !$application->currentStage) {
            return false;
        }

        if (!$this->visibleApplicationsQuery($actor)->whereKey($application->id)->exists()) {
            return false;
        }

        $stageRole = $application->currentStage->role;
        if (!$stageRole || !$actor->roles->contains('id', $stageRole->id)) {
            return false;
        }

        if (strtolower($stageRole->slug) === 'supervisor') {
            return $actor->hasRole('supervisor') && (int) $application->user->supervisor_id === (int) $actor->id;
        }

        return true;
    }

    public function startReview($id, $action)
    {
        if (!in_array($action, ['approved', 'rejected'], true)) {
            abort(422, 'Invalid review action.');
        }

        $application = LeaveApplication::with('currentStage')->findOrFail($id);

        if (!$this->canActOnApplication($application)) {
            session()->flash('error', 'You do not have the required role to act on this application at its current stage.');
            return;
        }

        $this->reviewingId = $id;
        $this->reviewAction = $action;
        $this->reviewComment = '';
        $this->signatureData = '';
    }

    public function cancelReview()
    {
        $this->reviewingId = null;
        $this->reviewComment = '';
        $this->reviewAction = '';
        $this->signatureData = '';
    }

    private function storeSignature(): ?string
    {
        if (!$this->signatureData) {
            return null;
        }

        if (!preg_match('/^data:image\/png;base64,([A-Za-z0-9+\/=]+)$/', $this->signatureData, $matches)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'signatureData' => 'The signature image is invalid. Please sign again or clear it.',
            ]);
        }

        $image = base64_decode($matches[1], true);
        $imageInfo = $image === false ? false : @getimagesizefromstring($image);
        if ($image === false || strlen($image) > 500000 || !$imageInfo || $imageInfo['mime'] !== 'image/png') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'signatureData' => 'The signature must be a valid PNG under 500 KB.',
            ]);
        }

        $path = 'leave-signatures/' . auth()->id() . '/' . Str::uuid() . '.png';
        Storage::disk('local')->put($path, $image);

        return $path;
    }

    public function submitReview()
    {
        $this->validate([
            'reviewAction' => 'required|in:approved,rejected',
            'reviewComment' => 'required|string|min:3|max:1000',
            'signatureData' => 'nullable|string|max:1000000',
        ]);

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
        $signaturePath = $this->storeSignature();

        // Record approval history
        ApprovalHistory::create([
            'leave_application_id' => $application->id,
            'stage_id' => $currentStage->id,
            'acted_by' => auth()->id(),
            'action' => $this->reviewAction,
            'comment' => $this->reviewComment,
            'signature_path' => $signaturePath,
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

    /* ---- Admin status override ---- */

    public function canOverrideStatus(): bool
    {
        $actor = auth()->user();

        return $actor && $actor->can('override-leave-status');
    }

    public function startOverride($id)
    {
        if (!$this->canOverrideStatus()) {
            abort(403);
        }

        $application = LeaveApplication::findOrFail($id);

        $this->overridingId = $application->id;
        $this->overrideStatus = '';
        $this->overrideComment = '';
    }

    public function cancelOverride()
    {
        $this->overridingId = null;
        $this->overrideStatus = '';
        $this->overrideComment = '';
        $this->resetErrorBag();
    }

    public function submitOverride()
    {
        if (!$this->canOverrideStatus()) {
            abort(403);
        }

        $this->validate([
            'overrideStatus' => 'required|in:pending,approved,rejected,cancelled',
            'overrideComment' => 'required|string|min:3|max:1000',
        ], [
            'overrideStatus.required' => 'Please select the new status.',
            'overrideComment.required' => 'Please provide a reason for changing the status.',
        ]);

        $newStatus = $this->overrideStatus;
        $comment = $this->overrideComment;
        $actor = auth()->user();

        $result = DB::transaction(function () use ($newStatus, $comment, $actor) {
            return $this->applyStatusOverride((int) $this->overridingId, $newStatus, $comment, $actor);
        });

        if (!$result) {
            session()->flash('error', 'The application is already ' . $newStatus . '. No change made.');
            $this->cancelOverride();
            return;
        }

        [$application, $oldStatus] = $result;
        $summary = 'Status changed from ' . ucfirst($oldStatus) . ' to ' . ucfirst($newStatus) . '. Reason: ' . $comment;

        $this->notifyApplicant($application, 'overridden', $summary, $actor->name, 'Administrator Override');

        if ($newStatus === 'pending' && $application->currentStage) {
            $this->notifyStageApprovers($application, $application->currentStage);
        }

        session()->flash('success', 'Leave application status changed from ' . ucfirst($oldStatus) . ' to ' . ucfirst($newStatus) . '.');

        $this->cancelOverride();
        $this->viewingApplication = null;
    }

    /**
     * Apply the override inside a transaction.
     *
     * @return array|null [LeaveApplication, oldStatus], or null when nothing changed.
     */
    private function applyStatusOverride(int $id, string $newStatus, string $comment, User $actor): ?array
    {
        $application = LeaveApplication::with(['workflow', 'user', 'leaveType'])
            ->lockForUpdate()
            ->findOrFail($id);

        $oldStatus = $application->status;
        if ($oldStatus === $newStatus) {
            return null;
        }

        $historyStageId = $application->current_stage_id;
        if (!$historyStageId && $application->workflow) {
            $endStage = $application->workflow->endStage();
            $historyStageId = $endStage ? $endStage->id : null;
        }

        $this->adjustBalanceForOverride($application, $oldStatus, $newStatus);

        $update = ['status' => $newStatus];
        if ($newStatus === 'pending') {
            // Re-open: send it back to the first workflow stage.
            $startStage = $application->workflow ? $application->workflow->startStage() : null;
            $update['current_stage_id'] = $startStage ? $startStage->id : null;
            $update['reviewed_by'] = null;
            $update['reviewed_at'] = null;
            $update['review_comment'] = null;
        } else {
            $update['current_stage_id'] = null;
            $update['reviewed_by'] = $actor->id;
            $update['reviewed_at'] = now();
            $update['review_comment'] = $comment;
        }
        $application->update($update);

        ApprovalHistory::create([
            'leave_application_id' => $application->id,
            'stage_id' => $historyStageId,
            'acted_by' => $actor->id,
            'action' => 'overridden',
            'comment' => 'Status changed from ' . ucfirst($oldStatus) . ' to ' . ucfirst($newStatus) . '. Reason: ' . $comment,
        ]);

        return [$application->fresh(['currentStage', 'user', 'leaveType']), $oldStatus];
    }

    /**
     * Keep the leave balance consistent with an admin status change.
     */
    private function adjustBalanceForOverride(LeaveApplication $application, string $oldStatus, string $newStatus): void
    {
        $year = $application->start_date->year;

        if ($oldStatus === 'approved') {
            $balance = LeaveBalance::where('user_id', $application->user_id)
                ->where('leave_type_id', $application->leave_type_id)
                ->where('year', $year)
                ->lockForUpdate()
                ->first();
            if ($balance) {
                $balance->update(['used_days' => max(0, $balance->used_days - $application->days_requested)]);
            }
            return;
        }

        if ($newStatus === 'approved') {
            $balance = LeaveBalance::firstOrCreate(
                ['user_id' => $application->user_id, 'leave_type_id' => $application->leave_type_id, 'year' => $year],
                [
                    'total_days' => LeaveType::find($application->leave_type_id)->default_days ?? 0,
                    'used_days' => 0,
                    'carried_over' => 0,
                ]
            );
            $balance->increment('used_days', $application->days_requested);
        }
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete-leave-applications') && !auth()->user()->can('manage-leave-applications')) {
            abort(403);
        }

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
            $stage->loadMissing('role');
            if ($stage->role && strtolower($stage->role->slug) === 'supervisor') {
                $supervisorId = $application->user()->value('supervisor_id');
                $approvers = $supervisorId
                    ? User::whereKey($supervisorId)->whereHas('roles', function ($query) {
                        $query->where('roles.slug', 'supervisor');
                    })->get()->filter(function ($user) {
                        return $user->can('approve-reject-leave');
                    })
                    : collect();
            } else {
                $approvers = User::whereHas('roles', function ($query) use ($stage) {
                    $query->where('roles.id', $stage->role_id);
                })->get()->filter(function ($user) {
                    return $user->can('approve-reject-leave');
                });
            }

            foreach ($approvers as $approver) {
                Mail::to($approver->email)->send(new LeaveApprovalRequestMail($application, $stage));
            }
        } catch (\Exception $e) {
            // Silently fail
        }
    }
}
