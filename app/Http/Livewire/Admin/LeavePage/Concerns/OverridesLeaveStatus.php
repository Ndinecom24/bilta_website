<?php

namespace App\Http\Livewire\Admin\LeavePage\Concerns;

use App\Services\Leave\LeaveStatusOverrideService;

/**
 * Administrator override for leave applications: change the status or move the
 * application to any workflow stage (forwards or backwards).
 *
 * The using component must provide notifyApplicant() and notifyStageApprovers(),
 * and may override afterStatusOverride() to refresh its own view state.
 */
trait OverridesLeaveStatus
{
    public $overridingId = null;
    public $overrideTarget = '';
    public $overrideComment = '';

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

        $this->overridingId = (int) $id;
        $this->overrideTarget = '';
        $this->overrideComment = '';
        $this->resetErrorBag();
    }

    public function cancelOverride()
    {
        $this->overridingId = null;
        $this->overrideTarget = '';
        $this->overrideComment = '';
        $this->resetErrorBag();
    }

    public function submitOverride()
    {
        if (!$this->canOverrideStatus()) {
            abort(403);
        }

        $this->validate([
            'overrideTarget' => 'required|string|max:30',
            'overrideComment' => 'required|string|min:3|max:1000',
        ], [
            'overrideTarget.required' => 'Please choose where to move the application.',
            'overrideComment.required' => 'Please provide a reason for the change.',
        ]);

        $actor = auth()->user();
        $result = app(LeaveStatusOverrideService::class)
            ->apply((int) $this->overridingId, $this->overrideTarget, $this->overrideComment, $actor);

        if (!$result) {
            session()->flash('error', 'The application is already there. No change made.');
            $this->cancelOverride();

            return;
        }

        [$application, $from, $to, $summary] = $result;

        $this->notifyApplicant($application, 'overridden', $summary, $actor->name, 'Administrator Override');

        if ($application->status === 'pending' && $application->currentStage) {
            $this->notifyStageApprovers($application, $application->currentStage);
        }

        session()->flash('success', 'Leave application moved from ' . $from . ' to ' . $to . '.');

        $this->cancelOverride();
        $this->afterStatusOverride();
    }

    protected function afterStatusOverride()
    {
        //
    }
}
