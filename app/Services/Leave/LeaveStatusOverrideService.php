<?php

namespace App\Services\Leave;

use App\Models\Bilta\ApprovalHistory;
use App\Models\Bilta\ApprovalWorkflowStage;
use App\Models\Bilta\LeaveApplication;
use App\Models\Bilta\LeaveBalance;
use App\Models\Bilta\LeaveType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Administrator override: move a leave application to any workflow stage
 * (forwards or backwards) or force a final status, with a full audit trail.
 *
 * Targets:  "stage:{id}"  -> pending at that stage
 *           "approved" | "rejected" | "cancelled"
 *           "pending"     -> pending at the first stage (kept for backwards compatibility)
 */
class LeaveStatusOverrideService
{
    public const FINAL_STATUSES = ['approved', 'rejected', 'cancelled'];

    /**
     * Options for the "move to" dropdown, excluding where the application already is.
     *
     * @return array<string, string> value => label
     */
    public function targetsFor(LeaveApplication $application): array
    {
        $options = [];

        if ($application->workflow) {
            foreach ($application->workflow->stages as $stage) {
                if ($application->status === 'pending' && (int) $application->current_stage_id === (int) $stage->id) {
                    continue;
                }
                $options['stage:' . $stage->id] = 'Pending at stage ' . $stage->stage_order . ': ' . $stage->name;
            }
        }

        $labels = ['approved' => 'Approved (final)', 'rejected' => 'Rejected', 'cancelled' => 'Cancelled'];
        foreach ($labels as $status => $label) {
            if ($application->status !== $status) {
                $options[$status] = $label;
            }
        }

        return $options;
    }

    /**
     * @return array|null [LeaveApplication $fresh, string $fromLabel, string $toLabel, string $summary], or null when nothing changed.
     */
    public function apply(int $applicationId, string $target, string $reason, User $actor): ?array
    {
        return DB::transaction(function () use ($applicationId, $target, $reason, $actor) {
            $application = LeaveApplication::with(['workflow.stages', 'currentStage', 'user', 'leaveType'])
                ->lockForUpdate()
                ->findOrFail($applicationId);

            [$newStatus, $targetStage] = $this->resolveTarget($application, $target);

            $oldStatus = $application->status;
            $oldStage = $application->currentStage;

            $sameStage = $newStatus !== 'pending'
                || ($targetStage && (int) $application->current_stage_id === (int) $targetStage->id);
            if ($oldStatus === $newStatus && $sameStage) {
                return null;
            }

            $fromLabel = $this->label($oldStatus, $oldStage);
            $toLabel = $this->label($newStatus, $targetStage);

            $verb = 'Status changed';
            if ($oldStatus === 'pending' && $newStatus === 'pending' && $oldStage && $targetStage) {
                $verb = (int) $targetStage->stage_order > (int) $oldStage->stage_order ? 'Moved forward' : 'Moved back';
            }
            $summary = $verb . ' from ' . $fromLabel . ' to ' . $toLabel . '. Reason: ' . $reason;

            $historyStageId = $application->current_stage_id;
            if (!$historyStageId && $application->workflow) {
                $endStage = $application->workflow->endStage();
                $historyStageId = $endStage ? $endStage->id : null;
            }

            $this->adjustBalance($application, $oldStatus, $newStatus);

            if ($newStatus === 'pending') {
                $update = [
                    'status' => 'pending',
                    'current_stage_id' => $targetStage->id,
                    'reviewed_by' => null,
                    'reviewed_at' => null,
                    'review_comment' => null,
                ];
            } else {
                $update = [
                    'status' => $newStatus,
                    'current_stage_id' => null,
                    'reviewed_by' => $actor->id,
                    'reviewed_at' => now(),
                    'review_comment' => $reason,
                ];
            }
            $application->update($update);

            ApprovalHistory::create([
                'leave_application_id' => $application->id,
                'stage_id' => $historyStageId,
                'acted_by' => $actor->id,
                'action' => 'overridden',
                'comment' => $summary,
            ]);

            return [$application->fresh(['currentStage', 'user', 'leaveType']), $fromLabel, $toLabel, $summary];
        });
    }

    /**
     * @return array [string $newStatus, ApprovalWorkflowStage|null $stage]
     */
    private function resolveTarget(LeaveApplication $application, string $target): array
    {
        if (in_array($target, self::FINAL_STATUSES, true)) {
            return [$target, null];
        }

        $stage = null;
        if ($target === 'pending') {
            $stage = $application->workflow ? $application->workflow->startStage() : null;
        } elseif (strpos($target, 'stage:') === 0 && $application->workflow) {
            $stage = $application->workflow->stages->firstWhere('id', (int) substr($target, 6));
        }

        if (!$stage) {
            throw ValidationException::withMessages([
                'overrideTarget' => 'That stage is not part of this application\'s approval workflow.',
            ]);
        }

        return ['pending', $stage];
    }

    private function label(string $status, ?ApprovalWorkflowStage $stage): string
    {
        if ($status === 'pending') {
            return $stage ? 'Pending at "' . $stage->name . '"' : 'Pending';
        }

        return ucfirst($status);
    }

    /**
     * Keep the leave balance consistent: leaving "approved" gives the days back,
     * entering "approved" uses them.
     */
    private function adjustBalance(LeaveApplication $application, string $oldStatus, string $newStatus): void
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
}
