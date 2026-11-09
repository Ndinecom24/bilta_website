<?php

namespace App\Http\Livewire\Admin\Support;

use App\Models\Support\Ticket;
use App\Models\Support\TicketPriority;
use App\Models\User;
use App\Services\Support\TicketService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketShow extends Component
{
    use WithFileUploads;

    public $ticketId;

    // Conversation
    public $commentBody = '';
    public $commentType = 'public';   // public | clarification | internal
    public $commentFiles = [];

    // Owner actions
    public $reopenReason = '';

    // Assignment
    public $assigneeId = '';

    // Developer: details & documentation
    public $priority_id = '';
    public $due_date = '';
    public $estimated_hours = '';
    public $technical_findings = '';
    public $resolution_notes = '';
    public $outstanding_requirements = '';

    // Developer: status change
    public $newStatus = '';
    public $statusNote = '';

    // Developer: work log
    public $work_date = '';
    public $work_hours = '';
    public $work_type = 'development';
    public $work_description = '';
    public $work_billable = true;

    public function mount($ticket)
    {
        $this->ticketId = (int) $ticket;
        $model = $this->loadTicket();
        $this->fillForms($model);
        $this->work_date = now()->toDateString();
    }

    /* ------------------------------------------------------------------ */

    private function service(): TicketService
    {
        return app(TicketService::class);
    }

    private function loadTicket(): Ticket
    {
        $ticket = Ticket::findOrFail($this->ticketId);
        abort_unless(auth()->user()->can('view', $ticket), 404);

        return $ticket;
    }

    private function fillForms(Ticket $ticket): void
    {
        $this->priority_id = $ticket->priority_id;
        $this->due_date = $ticket->due_date ? $ticket->due_date->format('Y-m-d') : '';
        $this->estimated_hours = $ticket->estimated_hours !== null ? $ticket->estimated_hours : '';
        $this->technical_findings = (string) $ticket->technical_findings;
        $this->resolution_notes = (string) $ticket->resolution_notes;
        $this->outstanding_requirements = (string) $ticket->outstanding_requirements;
        $this->assigneeId = $ticket->assigned_to ?: '';
        $this->newStatus = '';
        $this->statusNote = '';
    }

    private function done(string $message): void
    {
        $this->fillForms(Ticket::findOrFail($this->ticketId));
        session()->flash('success', $message);
    }

    private function attachmentRules(): array
    {
        $cfg = config('support.attachments');

        return [
            'commentFiles' => 'array|max:' . $cfg['max_files'],
            'commentFiles.*' => 'file|max:' . $cfg['max_kb'] . '|mimes:' . implode(',', $cfg['mimes']),
        ];
    }

    /* ---- Conversation ---- */

    public function updatedCommentFiles()
    {
        try {
            $this->validate($this->attachmentRules());
        } catch (ValidationException $e) {
            $this->commentFiles = [];
            throw $e;
        }
    }

    public function clearCommentFiles()
    {
        $this->commentFiles = [];
    }

    public function postComment()
    {
        $ticket = $this->loadTicket();

        $this->validate(['commentBody' => 'required|string|max:10000'] + $this->attachmentRules(), [
            'commentBody.required' => 'Please enter a message.',
            'commentFiles.*.max' => 'Each attachment must be smaller than 10 MB.',
            'commentFiles.*.mimes' => 'That file type is not allowed.',
        ]);

        $this->service()->addComment(
            $ticket,
            auth()->user(),
            $this->commentBody,
            $this->commentFiles,
            $this->commentType === 'internal',
            $this->commentType === 'clarification'
        );

        $this->reset(['commentBody', 'commentFiles']);
        $this->commentType = 'public';
        $this->done('Your message was posted.');
    }

    /* ---- Owner ---- */

    public function closeTicket()
    {
        $this->service()->close($this->loadTicket(), auth()->user());
        $this->done('Thank you. The ticket has been closed.');
    }

    public function reopenTicket()
    {
        $this->validate(['reopenReason' => 'required|string|min:5|max:2000'], [
            'reopenReason.required' => 'Please explain why the ticket is being reopened.',
            'reopenReason.min' => 'Please give a little more detail.',
        ]);

        $this->service()->reopen($this->loadTicket(), auth()->user(), $this->reopenReason);
        $this->reopenReason = '';
        $this->done('The ticket has been reopened and the support team was notified.');
    }

    /* ---- Assignment ---- */

    public function acceptTicket()
    {
        $this->service()->accept($this->loadTicket(), auth()->user());
        $this->done('You are now assigned to this ticket.');
    }

    public function assignTicket()
    {
        $this->validate(['assigneeId' => 'required|integer'], ['assigneeId.required' => 'Choose a developer.']);

        $this->service()->assign($this->loadTicket(), auth()->user(), (int) $this->assigneeId);
        $this->done('The ticket was assigned.');
    }

    /* ---- Developer ---- */

    public function saveDetails()
    {
        $this->validate([
            'priority_id' => 'required|exists:ticket_priorities,id',
            'due_date' => 'nullable|date',
            'estimated_hours' => 'nullable|numeric|min:0|max:9999',
            'technical_findings' => 'nullable|string|max:10000',
            'resolution_notes' => 'nullable|string|max:10000',
            'outstanding_requirements' => 'nullable|string|max:10000',
        ]);

        $this->service()->updateDetails($this->loadTicket(), auth()->user(), [
            'priority_id' => $this->priority_id,
            'due_date' => $this->due_date,
            'estimated_hours' => $this->estimated_hours,
            'technical_findings' => $this->technical_findings,
            'resolution_notes' => $this->resolution_notes,
            'outstanding_requirements' => $this->outstanding_requirements,
        ]);

        $this->done('Ticket details saved.');
    }

    public function changeStatus()
    {
        $this->validate([
            'newStatus' => 'required|in:' . implode(',', array_keys(Ticket::STATUSES)),
            'statusNote' => 'nullable|string|max:2000',
        ], ['newStatus.required' => 'Choose the new status.']);

        $this->service()->changeStatus($this->loadTicket(), auth()->user(), $this->newStatus, $this->statusNote);
        $this->done('Status updated.');
    }

    public function resolveTicket()
    {
        $this->validate([
            'resolution_notes' => 'required|string|min:5|max:10000',
            'technical_findings' => 'nullable|string|max:10000',
            'outstanding_requirements' => 'nullable|string|max:10000',
        ], ['resolution_notes.required' => 'Resolution notes are required to resolve a ticket.']);

        $this->service()->resolve($this->loadTicket(), auth()->user(), [
            'resolution_notes' => $this->resolution_notes,
            'technical_findings' => $this->technical_findings,
            'outstanding_requirements' => $this->outstanding_requirements,
        ]);

        $this->done('Ticket marked as resolved. The submitter was asked to confirm.');
    }

    public function logWork()
    {
        $this->validate([
            'work_date' => 'required|date|before_or_equal:today',
            'work_hours' => 'required|numeric|min:0.25|max:24',
            'work_type' => 'required|in:' . implode(',', array_keys(config('support.work_types'))),
            'work_description' => 'required|string|min:3|max:2000',
        ], [
            'work_date.before_or_equal' => 'Work cannot be logged for a future date.',
            'work_hours.required' => 'Enter the hours worked.',
            'work_description.required' => 'Describe the work that was done.',
        ]);

        $this->service()->logWork($this->loadTicket(), auth()->user(), [
            'work_date' => $this->work_date,
            'hours' => $this->work_hours,
            'work_type' => $this->work_type,
            'description' => $this->work_description,
            'is_billable' => (bool) $this->work_billable,
        ]);

        $this->reset(['work_hours', 'work_description']);
        $this->work_billable = true;
        $this->done('Work logged.');
    }

    /* ------------------------------------------------------------------ */

    /** Events that only support staff should see. */
    private const STAFF_EVENTS = ['internal_note', 'work_logged', 'estimate_changed', 'attachment_added', 'documentation_updated', 'billing_reviewed'];

    public function render()
    {
        $ticket = $this->loadTicket();
        $user = auth()->user();
        $isStaff = $user->can('viewInternal', $ticket);

        $ticket->load(['category', 'system', 'priority', 'submitter', 'assignee']);

        $comments = $ticket->comments()
            ->with(['author', 'attachments'])
            ->when(!$isStaff, function ($q) {
                $q->where('is_internal', false);
            })
            ->get();

        $initialAttachments = $ticket->attachments()->whereNull('comment_id')->get();

        $events = $ticket->events()->with('actor')
            ->when(!$isStaff, function ($q) {
                $q->whereNotIn('event', self::STAFF_EVENTS);
            })
            ->get();

        $workLogs = $isStaff ? $ticket->workLogs()->with('developer')->get() : collect();

        $canWork = $user->can('work', $ticket) && $ticket->status !== Ticket::STATUS_CLOSED;

        $manualStatuses = [];
        if ($canWork) {
            foreach ($ticket->allowedTransitions() as $to) {
                if (in_array($to, [Ticket::STATUS_ACKNOWLEDGED, Ticket::STATUS_IN_PROGRESS, Ticket::STATUS_AWAITING_FEEDBACK, Ticket::STATUS_ON_HOLD], true)) {
                    $manualStatuses[$to] = Ticket::STATUSES[$to]['label'];
                }
            }
        }

        $developers = collect();
        if ($user->can('assign', $ticket) && $ticket->isOpen()) {
            $developers = User::where('status_id', config('constants.status.active'))
                ->withPermission('work-support-tickets')
                ->orderBy('name')
                ->get(['id', 'name']);
        }

        return view('livewire.admin.support.ticket-show', [
            'ticket' => $ticket,
            'comments' => $comments,
            'initialAttachments' => $initialAttachments,
            'events' => $events,
            'workLogs' => $workLogs,
            'isStaff' => $isStaff,
            'canWork' => $canWork,
            'canAccept' => $user->can('accept', $ticket),
            'canAssign' => $user->can('assign', $ticket) && $ticket->isOpen(),
            'canClose' => $user->can('close', $ticket),
            'canReopen' => $user->can('reopen', $ticket),
            'canComment' => $user->can('comment', $ticket),
            'canResolve' => $canWork && $ticket->canTransitionTo(Ticket::STATUS_RESOLVED),
            'canLogWork' => $canWork && $ticket->isOpen(),
            'manualStatuses' => $manualStatuses,
            'developers' => $developers,
            'priorities' => TicketPriority::ordered()->get(),
            'workTypes' => config('support.work_types'),
            'estimated' => $ticket->estimated_hours,
            'actual' => $isStaff ? (float) $workLogs->sum('hours') : null,
            'billable' => $isStaff ? (float) $workLogs->where('billing_status', 'approved')->sum('billable_hours') : null,
        ]);
    }
}
