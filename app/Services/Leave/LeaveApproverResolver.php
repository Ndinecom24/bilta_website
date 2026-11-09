<?php

namespace App\Services\Leave;

use App\Models\Bilta\ApprovalWorkflowStage;
use App\Models\Bilta\BranchApprover;
use App\Models\Bilta\LeaveApplication;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Works out WHO actually reviews a leave application at each workflow stage.
 *
 * Supervisor stage : the applicant's direct supervisor, plus anyone assigned as
 *                    Supervisor for the applicant's branch (Branches > Leave approvers).
 * Any other role   : if the applicant's branch has people assigned for that role,
 *                    only those people. Otherwise everyone holding the role.
 *
 * Nobody ever reviews their own application, and every reviewer must hold the
 * stage role and the "approve-reject-leave" permission.
 */
class LeaveApproverResolver
{
    public const SUPERVISOR_ROLE = 'supervisor';
    public const PERMISSION = 'approve-reject-leave';

    public function isSupervisorStage(ApprovalWorkflowStage $stage): bool
    {
        $stage->loadMissing('role');

        return $stage->role && strtolower($stage->role->slug) === self::SUPERVISOR_ROLE;
    }

    /**
     * The people who can act on this stage for this application.
     *
     * @return Collection<int, User>
     */
    public function approversFor(LeaveApplication $application, ApprovalWorkflowStage $stage): Collection
    {
        $stage->loadMissing('role');
        $application->loadMissing('user');

        $applicant = $application->user;
        if (!$applicant || !$stage->role_id) {
            return collect();
        }

        $branchUserIds = $applicant->branch_id
            ? BranchApprover::where('branch_id', $applicant->branch_id)
                ->where('role_id', $stage->role_id)
                ->pluck('user_id')
            : collect();

        $query = User::whereHas('roles', function ($roles) use ($stage) {
            $roles->where('roles.id', $stage->role_id);
        })->where('users.id', '!=', $applicant->id);

        if ($this->isSupervisorStage($stage)) {
            $candidateIds = $branchUserIds->push($applicant->supervisor_id)->filter()->unique()->values();
            $query->whereIn('users.id', $candidateIds);
        } elseif ($branchUserIds->isNotEmpty()) {
            $query->whereIn('users.id', $branchUserIds);
        }

        return $query->orderBy('name')->get()->filter(function (User $user) {
            return $user->can(self::PERMISSION);
        })->values();
    }

    /**
     * Can this user approve/reject the application at its current stage right now?
     */
    public function canAct(User $actor, LeaveApplication $application): bool
    {
        if ($application->status !== 'pending' || !$application->current_stage_id) {
            return false;
        }

        if ((int) $application->user_id === (int) $actor->id || !$actor->can(self::PERMISSION)) {
            return false;
        }

        $application->loadMissing(['currentStage.role', 'user']);
        if (!$application->currentStage) {
            return false;
        }

        return $this->approversFor($application, $application->currentStage)->contains('id', $actor->id);
    }

    /**
     * The user's direct supervisor (must hold the Supervisor role).
     */
    public function isDirectSupervisor(User $actor, User $applicant): bool
    {
        return $actor->hasRole(self::SUPERVISOR_ROLE)
            && (int) $applicant->supervisor_id === (int) $actor->id;
    }

    /**
     * Has this user been assigned (in any role) to the applicant's branch?
     */
    public function isBranchApproverFor(User $actor, User $applicant): bool
    {
        return $applicant->branch_id
            && BranchApprover::where('user_id', $actor->id)->where('branch_id', $applicant->branch_id)->exists();
    }

    /**
     * Branches where this user has been assigned as an approver.
     *
     * @return Collection<int, int>
     */
    public function branchIdsFor(User $actor): Collection
    {
        return BranchApprover::where('user_id', $actor->id)->pluck('branch_id')->unique()->values();
    }

    /**
     * Stage-by-stage progress for the workflow pipeline shown on an application.
     * Only the people who really work on a stage are listed, never the whole role.
     *
     * Each item: stage, state (done|current|rejected|upcoming), actor (who acted, if
     * known) and approvers (who is able to act, for current/upcoming stages).
     *
     * @return Collection<int, array>
     */
    public function stageProgress(LeaveApplication $application): Collection
    {
        $application->loadMissing(['workflow.stages.role', 'currentStage', 'approvalHistory.actor', 'user']);

        if (!$application->workflow) {
            return collect();
        }

        $stages = $application->workflow->stages;
        $history = $application->approvalHistory;
        $currentOrder = $application->currentStage ? (int) $application->currentStage->stage_order : null;

        $rejectedOrder = null;
        if ($application->status === 'rejected') {
            $rejection = $history->where('action', 'rejected')->last();
            $rejectedStage = $rejection ? $stages->firstWhere('id', $rejection->stage_id) : null;
            $rejectedOrder = $rejectedStage ? (int) $rejectedStage->stage_order : null;
        }

        return $stages->map(function (ApprovalWorkflowStage $stage) use ($application, $history, $currentOrder, $rejectedOrder) {
            $order = (int) $stage->stage_order;
            $lastApproval = $history->where('stage_id', $stage->id)->where('action', 'approved')->last();
            $lastRejection = $history->where('stage_id', $stage->id)->where('action', 'rejected')->last();

            if ($application->status === 'approved') {
                $state = 'done';
            } elseif ($application->status === 'pending' && $currentOrder !== null) {
                $state = $order < $currentOrder ? 'done'
                    : ($order === $currentOrder ? 'current' : 'upcoming');
            } elseif ($rejectedOrder !== null) {
                $state = $order < $rejectedOrder ? 'done'
                    : ($order === $rejectedOrder ? 'rejected' : 'upcoming');
            } else {
                $state = $lastApproval ? 'done' : 'upcoming';
            }

            $actor = null;
            if ($state === 'done' && $lastApproval) {
                $actor = $lastApproval->actor;
            } elseif ($state === 'rejected' && $lastRejection) {
                $actor = $lastRejection->actor;
            }

            $showApprovers = $application->status === 'pending' && in_array($state, ['current', 'upcoming'], true);

            return [
                'stage' => $stage,
                'state' => $state,
                'actor' => $actor,
                'approvers' => $showApprovers ? $this->approversFor($application, $stage) : collect(),
            ];
        })->values();
    }
}
