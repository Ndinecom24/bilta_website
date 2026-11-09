<?php

namespace App\Services\Support;

use App\Models\Support\Ticket;
use App\Models\Support\TicketAttachment;
use App\Models\Support\TicketBillingRate;
use App\Models\Support\TicketComment;
use App\Models\Support\TicketEvent;
use App\Models\Support\TicketPriority;
use App\Models\Support\TicketWorkLog;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Single place where every ticket mutation happens: authorisation, workflow
 * rules, the append-only audit trail and notifications.
 *
 * Methods throw AuthorizationException (403) or ValidationException (shown to the user).
 */
class TicketService
{
    private $notifier;

    public function __construct(TicketNotifier $notifier)
    {
        $this->notifier = $notifier;
    }

    /* =====================================================================
     |  Creation
     | ===================================================================== */

    /**
     * @param array $data  subject, description, category_id, system_id (nullable), priority_id
     * @param array $files uploaded files
     */
    public function create(User $submitter, array $data, array $files = []): Ticket
    {
        Gate::forUser($submitter)->authorize('create', Ticket::class);

        $priority = TicketPriority::active()->find($data['priority_id'] ?? null);
        if (!$priority) {
            $this->fail('priority_id', 'Please choose a valid priority.');
        }

        $storedPaths = [];

        try {
            $ticket = DB::transaction(function () use ($submitter, $data, $files, $priority, &$storedPaths) {
                $ticket = Ticket::create([
                    'reference' => $this->nextReference(),
                    'subject' => trim($data['subject']),
                    'description' => trim($data['description']),
                    'status' => Ticket::STATUS_NEW,
                    'category_id' => $data['category_id'],
                    'system_id' => $data['system_id'] ?: null,
                    'priority_id' => $priority->id,
                    'submitted_by' => $submitter->id,
                    'due_date' => now()->addHours((int) $priority->resolution_target_hours)->toDateString(),
                    'last_activity_at' => now(),
                ]);

                $this->record($ticket, $submitter, 'created', null, Ticket::STATUS_NEW);
                $storedPaths = $this->storeAttachments($ticket, null, $submitter, $files);

                return $ticket;
            });
        } catch (Throwable $e) {
            $this->deleteFiles($storedPaths);
            throw $e;
        }

        $this->notifier->ticketCreated($ticket);

        return $ticket;
    }

    /** TKT-2026-0001 style reference, sequence restarts every year. */
    private function nextReference(): string
    {
        $prefix = config('support.reference_prefix', 'TKT') . '-' . now()->format('Y') . '-';

        $last = Ticket::where('reference', 'like', $prefix . '%')
            ->lockForUpdate()
            ->orderByDesc('id')
            ->value('reference');

        $next = $last ? ((int) substr($last, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }

    /* =====================================================================
     |  Conversation
     | ===================================================================== */

    public function addComment(
        Ticket $ticket,
        User $actor,
        string $body,
        array $files = [],
        bool $internal = false,
        bool $clarification = false
    ): TicketComment {
        $gate = Gate::forUser($actor);
        $gate->authorize('comment', $ticket);

        if ($clarification) {
            $gate->authorize('work', $ticket);
            $internal = false;
        } elseif ($internal) {
            $gate->authorize('viewInternal', $ticket);
        }

        $body = trim($body);
        if ($body === '') {
            $this->fail('comment', 'Please enter a message.');
        }

        $storedPaths = [];

        try {
            $comment = DB::transaction(function () use ($ticket, $actor, $body, $files, $internal, $clarification, &$storedPaths) {
                $comment = TicketComment::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $actor->id,
                    'body' => $body,
                    'is_internal' => $internal,
                    'is_clarification_request' => $clarification,
                ]);

                $storedPaths = $this->storeAttachments($ticket, $comment, $actor, $files);

                $event = $clarification ? 'clarification_requested' : ($internal ? 'internal_note' : 'comment');
                $this->record($ticket, $actor, $event, null, null, Str::limit($body, 300));

                $ticket->forceFill(['last_activity_at' => now()])->save();

                return $comment;
            });
        } catch (Throwable $e) {
            $this->deleteFiles($storedPaths);
            throw $e;
        }

        // Side effects on the workflow
        $isOwner = (int) $ticket->submitted_by === (int) $actor->id;

        if ($clarification) {
            if ($ticket->canTransitionTo(Ticket::STATUS_AWAITING_FEEDBACK)) {
                $this->applyStatus($ticket, $actor, Ticket::STATUS_AWAITING_FEEDBACK, 'Clarification requested');
            }
            $this->notifier->clarificationRequested($ticket, $comment, $actor);
        } else {
            if (!$internal && $isOwner && $ticket->status === Ticket::STATUS_AWAITING_FEEDBACK) {
                $this->applyStatus($ticket, $actor, Ticket::STATUS_IN_PROGRESS, 'Reply received from submitter');
            }
            $this->notifier->commentAdded($ticket, $comment, $actor);
        }

        return $comment;
    }

    /* =====================================================================
     |  Workflow
     | ===================================================================== */

    /**
     * Move a ticket to another status (validates permissions and the workflow map).
     */
    public function changeStatus(Ticket $ticket, User $actor, string $to, ?string $note = null): Ticket
    {
        $ability = $to === Ticket::STATUS_CLOSED ? 'close'
            : ($to === Ticket::STATUS_REOPENED ? 'reopen' : 'work');
        Gate::forUser($actor)->authorize($ability, $ticket);

        if (!$ticket->canTransitionTo($to)) {
            $this->fail('ticket', sprintf(
                'A ticket that is "%s" cannot be moved to "%s".',
                $ticket->status_label,
                Ticket::STATUSES[$to]['label'] ?? $to
            ));
        }

        $note = $note !== null ? trim($note) : null;

        if (in_array($to, [Ticket::STATUS_ON_HOLD, Ticket::STATUS_REOPENED], true) && ($note === null || $note === '')) {
            $this->fail('note', 'A reason is required for this status change.');
        }

        if ($to === Ticket::STATUS_RESOLVED && trim((string) $ticket->resolution_notes) === '') {
            $this->fail('resolution_notes', 'Resolution notes are required before a ticket can be resolved.');
        }

        if ($to === Ticket::STATUS_ASSIGNED && $ticket->assigned_to === null) {
            $this->fail('ticket', 'Assign a developer first.');
        }

        return $this->applyStatus($ticket, $actor, $to, $note);
    }

    /**
     * Internal status mutation (no authorisation) used by workflow side effects.
     */
    private function applyStatus(Ticket $ticket, User $actor, string $to, ?string $note = null, bool $notify = true): Ticket
    {
        $from = $ticket->status;

        $attrs = ['status' => $to, 'last_activity_at' => now()];

        switch ($to) {
            case Ticket::STATUS_ACKNOWLEDGED:
                $attrs['acknowledged_at'] = $ticket->acknowledged_at ?: now();
                break;

            case Ticket::STATUS_IN_PROGRESS:
                $attrs['started_at'] = $ticket->started_at ?: now();
                break;

            case Ticket::STATUS_RESOLVED:
                $attrs['resolved_at'] = now();
                break;

            case Ticket::STATUS_CLOSED:
                $attrs['closed_at'] = now();
                break;

            case Ticket::STATUS_REOPENED:
                $attrs['reopen_count'] = (int) $ticket->reopen_count + 1;
                $attrs['resolved_at'] = null;
                $attrs['closed_at'] = null;
                break;
        }

        DB::transaction(function () use ($ticket, $actor, $attrs, $from, $to, $note) {
            $ticket->forceFill($attrs)->save();
            $this->record($ticket, $actor, 'status_changed', $from, $to, $note);
        });

        if ($notify) {
            $this->notifier->statusChanged($ticket->fresh(['submitter', 'assignee']), $actor, $from, $to, $note);
        }

        return $ticket;
    }

    /** Owner (or an assigner) confirms a resolved ticket. */
    public function close(Ticket $ticket, User $actor): Ticket
    {
        return $this->changeStatus($ticket, $actor, Ticket::STATUS_CLOSED, 'Resolution confirmed');
    }

    /** Re-open a resolved/closed ticket. The reason becomes a visible comment. */
    public function reopen(Ticket $ticket, User $actor, string $reason): Ticket
    {
        $reason = trim($reason);
        if ($reason === '') {
            $this->fail('note', 'Please explain why the ticket is being reopened.');
        }

        $this->changeStatus($ticket, $actor, Ticket::STATUS_REOPENED, $reason);

        TicketComment::create([
            'ticket_id' => $ticket->id,
            'user_id' => $actor->id,
            'body' => 'Reopened: ' . $reason,
            'is_internal' => false,
            'is_clarification_request' => false,
        ]);

        return $ticket;
    }

    /**
     * Mark the ticket as resolved, storing the developer's documentation.
     *
     * @param array $data resolution_notes (required), technical_findings, outstanding_requirements
     */
    public function resolve(Ticket $ticket, User $actor, array $data): Ticket
    {
        Gate::forUser($actor)->authorize('work', $ticket);

        $notes = trim((string) ($data['resolution_notes'] ?? ''));
        if (mb_strlen($notes) < 5) {
            $this->fail('resolution_notes', 'Describe what was done to resolve this ticket.');
        }

        if (!$ticket->canTransitionTo(Ticket::STATUS_RESOLVED)) {
            $this->fail('ticket', 'Only tickets that are in progress can be resolved.');
        }

        $this->updateDetails($ticket, $actor, [
            'resolution_notes' => $notes,
            'technical_findings' => $data['technical_findings'] ?? $ticket->technical_findings,
            'outstanding_requirements' => $data['outstanding_requirements'] ?? $ticket->outstanding_requirements,
        ]);

        return $this->changeStatus($ticket, $actor, Ticket::STATUS_RESOLVED, Str::limit($notes, 300));
    }

    /* =====================================================================
     |  Assignment
     | ===================================================================== */

    public function assign(Ticket $ticket, User $actor, int $developerId): Ticket
    {
        Gate::forUser($actor)->authorize('assign', $ticket);

        $developer = User::where('status_id', config('constants.status.active'))
            ->withPermission('work-support-tickets')
            ->find($developerId);

        if (!$developer) {
            $this->fail('assignee', 'Choose an active support developer.');
        }

        return $this->applyAssignment($ticket, $actor, $developer);
    }

    /** A developer picks up an unassigned ticket. */
    public function accept(Ticket $ticket, User $actor): Ticket
    {
        Gate::forUser($actor)->authorize('accept', $ticket);

        return $this->applyAssignment($ticket, $actor, $actor);
    }

    private function applyAssignment(Ticket $ticket, User $actor, User $developer): Ticket
    {
        if (!$ticket->isOpen()) {
            $this->fail('ticket', 'Resolved or closed tickets cannot be reassigned. Reopen the ticket first.');
        }

        if ((int) $ticket->assigned_to === (int) $developer->id) {
            return $ticket;
        }

        $previous = $ticket->assignee;
        $oldStatus = $ticket->status;
        $newStatus = in_array($oldStatus, [Ticket::STATUS_NEW, Ticket::STATUS_ACKNOWLEDGED, Ticket::STATUS_REOPENED], true)
            ? Ticket::STATUS_ASSIGNED
            : $oldStatus;

        DB::transaction(function () use ($ticket, $actor, $developer, $previous, $oldStatus, $newStatus) {
            $ticket->forceFill([
                'assigned_to' => $developer->id,
                'status' => $newStatus,
                'last_activity_at' => now(),
            ])->save();

            $this->record(
                $ticket,
                $actor,
                'assigned',
                $previous ? $previous->name : null,
                $developer->name,
                null,
                ['developer_id' => $developer->id]
            );

            if ($newStatus !== $oldStatus) {
                $this->record($ticket, $actor, 'status_changed', $oldStatus, $newStatus, 'Assigned to a developer');
            }
        });

        $fresh = $ticket->fresh(['submitter', 'assignee']);
        $this->notifier->assigned($fresh, $developer, $actor);

        if ($newStatus !== $oldStatus) {
            $this->notifier->statusChanged($fresh, $actor, $oldStatus, $newStatus, 'Assigned to ' . $developer->name);
        }

        return $ticket;
    }

    /* =====================================================================
     |  Developer details & work
     | ===================================================================== */

    /**
     * Update priority, due date, estimate and the technical documentation.
     * Only the keys present in $data are touched.
     */
    public function updateDetails(Ticket $ticket, User $actor, array $data): Ticket
    {
        Gate::forUser($actor)->authorize('work', $ticket);

        if ($ticket->status === Ticket::STATUS_CLOSED) {
            $this->fail('ticket', 'Closed tickets cannot be edited. Reopen the ticket first.');
        }

        $changes = [];
        $events = [];

        if (array_key_exists('priority_id', $data) && (int) $data['priority_id'] !== (int) $ticket->priority_id) {
            $priority = TicketPriority::active()->find($data['priority_id']);
            if (!$priority) {
                $this->fail('priority_id', 'Please choose a valid priority.');
            }
            $events[] = ['priority_changed', optional($ticket->priority)->name, $priority->name, null];
            $changes['priority_id'] = $priority->id;
        }

        if (array_key_exists('due_date', $data)) {
            $new = $data['due_date'] ?: null;
            $old = $ticket->due_date ? $ticket->due_date->toDateString() : null;
            if ($new !== $old) {
                $events[] = ['due_date_changed', $old, $new, null];
                $changes['due_date'] = $new;
            }
        }

        if (array_key_exists('estimated_hours', $data)) {
            $new = ($data['estimated_hours'] === null || $data['estimated_hours'] === '') ? null : round((float) $data['estimated_hours'], 2);
            $old = $ticket->estimated_hours;
            if ($new !== $old) {
                $events[] = ['estimate_changed', $old === null ? null : (string) $old, $new === null ? null : (string) $new, null];
                $changes['estimated_hours'] = $new;
            }
        }

        $docChanged = [];
        foreach (['technical_findings', 'resolution_notes', 'outstanding_requirements'] as $field) {
            if (array_key_exists($field, $data)) {
                $new = trim((string) $data[$field]) === '' ? null : trim((string) $data[$field]);
                if ($new !== $ticket->{$field}) {
                    $changes[$field] = $new;
                    $docChanged[] = str_replace('_', ' ', $field);
                }
            }
        }
        if ($docChanged) {
            $events[] = ['documentation_updated', null, null, 'Updated: ' . implode(', ', $docChanged)];
        }

        if (!$changes) {
            return $ticket;
        }

        DB::transaction(function () use ($ticket, $actor, $changes, $events) {
            $ticket->forceFill($changes + ['last_activity_at' => now()])->save();

            foreach ($events as [$event, $from, $to, $note]) {
                $this->record($ticket, $actor, $event, $from, $to, $note);
            }
        });

        return $ticket;
    }

    /**
     * Log hours actually worked. Billing is reviewed separately.
     *
     * @param array $data work_date, hours, work_type, description, is_billable
     */
    public function logWork(Ticket $ticket, User $actor, array $data): TicketWorkLog
    {
        Gate::forUser($actor)->authorize('work', $ticket);

        if (!$ticket->isOpen()) {
            $this->fail('ticket', 'Reopen the ticket before logging more work.');
        }

        $hours = round((float) ($data['hours'] ?? 0), 2);
        $step = (float) config('support.hours_step', 0.25);

        if ($hours <= 0 || $hours > 24) {
            $this->fail('hours', 'Hours must be between 0.25 and 24 for one entry.');
        }
        if ($step > 0 && abs(round($hours / $step) * $step - $hours) > 0.0001) {
            $this->fail('hours', 'Hours must be in steps of ' . $step . '.');
        }

        $description = trim((string) ($data['description'] ?? ''));
        if ($description === '') {
            $this->fail('description', 'Describe the work that was done.');
        }

        $workType = $data['work_type'] ?? 'development';
        if (!array_key_exists($workType, config('support.work_types', []))) {
            $workType = 'other';
        }

        $log = DB::transaction(function () use ($ticket, $actor, $data, $hours, $description, $workType) {
            $log = TicketWorkLog::create([
                'ticket_id' => $ticket->id,
                'developer_id' => $actor->id,
                'work_date' => $data['work_date'] ?? now()->toDateString(),
                'hours' => $hours,
                'work_type' => $workType,
                'description' => $description,
                'is_billable' => (bool) ($data['is_billable'] ?? true),
                'billing_status' => TicketWorkLog::BILLING_UNREVIEWED,
            ]);

            $this->record($ticket, $actor, 'work_logged', null, (string) $hours, Str::limit($description, 300), [
                'work_log_id' => $log->id,
                'work_type' => $workType,
            ]);

            $ticket->forceFill(['last_activity_at' => now()])->save();

            return $log;
        });

        // Logging work implies the developer owns and has started the ticket.
        if ($ticket->assigned_to === null && $actor->can('work-support-tickets')) {
            $this->applyAssignment($ticket, $actor, $actor);
        }

        if (in_array($ticket->status, [
            Ticket::STATUS_NEW, Ticket::STATUS_ACKNOWLEDGED, Ticket::STATUS_ASSIGNED, Ticket::STATUS_REOPENED,
        ], true)) {
            $this->applyStatus($ticket, $actor, Ticket::STATUS_IN_PROGRESS, 'Work started');
        }

        return $log;
    }

    /* =====================================================================
     |  Billing review (separate from the hours actually worked)
     | ===================================================================== */

    /**
     * @param string     $decision      approve | non_billable | reset
     * @param float|null $billableHours hours to bill when approving (defaults to the hours worked)
     *
     * Approving snapshots the rate and currency in force on the work date so later rate changes
     * never alter approved work. No invoice is generated.
     */
    public function reviewBilling(TicketWorkLog $log, User $actor, string $decision, ?float $billableHours = null): TicketWorkLog
    {
        if (!$actor->can('manage-support-billing')) {
            throw new \Illuminate\Auth\Access\AuthorizationException('You are not allowed to review billing.');
        }

        $ticket = $log->ticket;
        $before = $log->billing_status;

        if ($decision === 'approve') {
            $hours = $billableHours !== null ? round($billableHours, 2) : (float) $log->hours;
            if ($hours <= 0 || $hours > (float) $log->hours) {
                $this->fail('billable_hours', 'Billable hours must be more than 0 and not more than the ' . $log->hours . ' hours worked.');
            }

            $rate = TicketBillingRate::resolve($log->developer_id, $log->work_date);
            if (!$rate) {
                $this->fail('rate', 'No active billing rate covers ' . $log->work_date->format('d M Y') . '. Add one under Billing Rates first.');
            }

            $log->forceFill([
                'billing_status' => TicketWorkLog::BILLING_APPROVED,
                'is_billable' => true,
                'billable_hours' => $hours,
                'rate_applied' => $rate->hourly_rate,
                'currency' => $rate->currency,
                'billing_approved_by' => $actor->id,
                'billing_approved_at' => now(),
            ])->save();
        } elseif ($decision === 'non_billable') {
            $log->forceFill([
                'billing_status' => TicketWorkLog::BILLING_NON_BILLABLE,
                'is_billable' => false,
                'billable_hours' => null,
                'rate_applied' => null,
                'currency' => null,
                'billing_approved_by' => $actor->id,
                'billing_approved_at' => now(),
            ])->save();
        } elseif ($decision === 'reset') {
            $log->forceFill([
                'billing_status' => TicketWorkLog::BILLING_UNREVIEWED,
                'billable_hours' => null,
                'rate_applied' => null,
                'currency' => null,
                'billing_approved_by' => null,
                'billing_approved_at' => null,
            ])->save();
        } else {
            $this->fail('decision', 'Unknown billing decision.');
        }

        $this->record($ticket, $actor, 'billing_reviewed', $before, $log->billing_status, null, [
            'work_log_id' => $log->id,
            'billable_hours' => $log->billable_hours,
            'rate' => $log->rate_applied,
        ]);

        return $log;
    }

    /* =====================================================================
     |  Attachments
     | ===================================================================== */

    /**
     * Validate and store uploaded files on the private disk.
     *
     * @return string[] stored paths (so callers can clean up on failure)
     */
    public function storeAttachments(Ticket $ticket, ?TicketComment $comment, User $actor, array $files): array
    {
        $files = array_values(array_filter($files));
        if (!$files) {
            return [];
        }

        $cfg = config('support.attachments');

        if (count($files) > $cfg['max_files']) {
            $this->fail('attachments', 'You can attach at most ' . $cfg['max_files'] . ' files at a time.');
        }

        $disk = $cfg['disk'];
        $stored = [];

        try {
            foreach ($files as $file) {
                $original = $this->sanitizeName($file->getClientOriginalName());
                $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));

                if (!in_array($extension, $cfg['mimes'], true)) {
                    $this->fail('attachments', '"' . $original . '" is not an allowed file type.');
                }
                if ($file->getSize() > $cfg['max_kb'] * 1024) {
                    $this->fail('attachments', '"' . $original . '" is larger than ' . round($cfg['max_kb'] / 1024) . ' MB.');
                }

                $contents = $file->get();
                $path = trim($cfg['directory'], '/') . '/' . $ticket->id . '/' . Str::uuid()->toString() . '.' . $extension;

                Storage::disk($disk)->put($path, $contents);
                $stored[] = $path;

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'comment_id' => $comment ? $comment->id : null,
                    'uploaded_by' => $actor->id,
                    'original_name' => $original,
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => strlen($contents),
                    'checksum' => hash('sha256', $contents),
                ]);

                $this->record($ticket, $actor, 'attachment_added', null, $original);
            }
        } catch (Throwable $e) {
            $this->deleteFiles($stored);
            throw $e;
        }

        return $stored;
    }

    private function sanitizeName(string $name): string
    {
        $name = basename(str_replace('\\', '/', $name));
        $name = preg_replace('/[^\w\-. ()]+/u', '_', $name);

        return Str::limit($name !== '' ? $name : 'file', 150, '');
    }

    private function deleteFiles(array $paths): void
    {
        if (!$paths) {
            return;
        }

        $disk = config('support.attachments.disk');
        foreach ($paths as $path) {
            try {
                Storage::disk($disk)->delete($path);
            } catch (Throwable $e) {
                // best effort
            }
        }
    }

    /* =====================================================================
     |  Helpers
     | ===================================================================== */

    private function record(
        Ticket $ticket,
        ?User $actor,
        string $event,
        ?string $from = null,
        ?string $to = null,
        ?string $note = null,
        ?array $meta = null
    ): TicketEvent {
        return TicketEvent::create([
            'ticket_id' => $ticket->id,
            'user_id' => $actor ? $actor->id : null,
            'event' => $event,
            'from_value' => $from,
            'to_value' => $to,
            'note' => $note,
            'meta' => $meta,
            'created_at' => now(),
        ]);
    }

    private function fail(string $field, string $message): void
    {
        throw ValidationException::withMessages([$field => $message]);
    }
}
