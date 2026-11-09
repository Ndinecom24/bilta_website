<?php

namespace App\Services\Support;

use App\Mail\Support\TicketNotificationMail;
use App\Models\Support\Ticket;
use App\Models\Support\TicketComment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

/**
 * Decides who is told about what. Mail failures never break a ticket action.
 *
 * Event                     -> Recipients
 *  new ticket               -> developers (+ optional shared inbox)
 *  assigned                 -> the assigned developer
 *  status changed           -> the submitter (closed / reopened -> the assigned developer)
 *  clarification requested  -> the submitter
 *  comment                  -> the other participants (internal notes: staff only)
 *
 * The person who performed the action is never emailed about it, and every
 * recipient must be allowed to view the ticket.
 */
class TicketNotifier
{
    public function ticketCreated(Ticket $ticket): void
    {
        $ticket->loadMissing(['submitter', 'category', 'priority', 'system']);

        $this->dispatch(
            $ticket,
            $this->developers(),
            'New support ticket',
            'A new support ticket has been submitted' . ($ticket->submitter ? ' by ' . $ticket->submitter->name : '') . '.',
            $ticket->submitter,
            false,
            array_filter([config('support.notify_inbox')])
        );
    }

    public function assigned(Ticket $ticket, User $developer, User $actor): void
    {
        $this->dispatch(
            $ticket,
            collect([$developer]),
            'Ticket assigned to you',
            $actor->name . ' assigned this ticket to you.',
            $actor
        );
    }

    public function statusChanged(Ticket $ticket, User $actor, string $from, string $to, ?string $note = null): void
    {
        $label = Ticket::STATUSES[$to]['label'] ?? $to;

        if (in_array($to, [Ticket::STATUS_CLOSED, Ticket::STATUS_REOPENED], true)) {
            $recipients = $ticket->assignee ? collect([$ticket->assignee]) : $this->developers();
            $headline = $to === Ticket::STATUS_CLOSED ? 'Ticket closed' : 'Ticket reopened';
            $body = $to === Ticket::STATUS_CLOSED
                ? $actor->name . ' confirmed the resolution and closed this ticket.'
                : $actor->name . ' reopened this ticket.' . ($note ? ' Reason: ' . $note : '');
        } elseif ($to === Ticket::STATUS_RESOLVED) {
            $recipients = $ticket->submitter ? collect([$ticket->submitter]) : collect();
            $headline = 'Ticket resolved - please confirm';
            $body = 'Your ticket has been marked as resolved. Please review the resolution and confirm, or reopen the ticket if the problem persists.'
                . ($ticket->resolution_notes ? "\n\nResolution: " . $ticket->resolution_notes : '');
        } else {
            $recipients = $ticket->submitter ? collect([$ticket->submitter]) : collect();
            $headline = 'Status updated: ' . $label;
            $body = 'The status of your ticket changed from "' . (Ticket::STATUSES[$from]['label'] ?? $from) . '" to "' . $label . '".'
                . ($note ? "\n\n" . $note : '');
        }

        $this->dispatch($ticket, $recipients, $headline, $body, $actor);
    }

    public function clarificationRequested(Ticket $ticket, TicketComment $comment, User $actor): void
    {
        $this->dispatch(
            $ticket,
            $ticket->submitter ? collect([$ticket->submitter]) : collect(),
            'More information needed',
            $actor->name . " needs more information to continue:\n\n" . $comment->body,
            $actor
        );
    }

    public function commentAdded(Ticket $ticket, TicketComment $comment, User $actor): void
    {
        $internal = (bool) $comment->is_internal;

        $ids = collect([$ticket->assigned_to]);
        if (!$internal) {
            $ids->push($ticket->submitted_by);
        }

        $ids = $ids->merge(
            TicketComment::where('ticket_id', $ticket->id)
                ->where('is_internal', $internal)
                ->pluck('user_id')
        )->filter()->unique();

        $recipients = User::whereIn('id', $ids)->get();

        $this->dispatch(
            $ticket,
            $recipients,
            $internal ? 'New internal note' : 'New comment',
            $actor->name . ($internal ? ' added an internal note:' : ' commented:') . "\n\n" . $comment->body,
            $actor,
            $internal
        );
    }

    /* ------------------------------------------------------------------ */

    private function developers(): Collection
    {
        return User::where('status_id', config('constants.status.active'))
            ->withPermission('work-support-tickets')
            ->get();
    }

    /**
     * @param Collection|iterable $users
     * @param bool  $staffOnly   recipients must also be allowed to read internal notes
     * @param array $extraEmails plain addresses (e.g. shared inbox) that skip the view check
     */
    private function dispatch(
        Ticket $ticket,
        $users,
        string $headline,
        ?string $body,
        ?User $actor = null,
        bool $staffOnly = false,
        array $extraEmails = []
    ): void {
        if (!config('support.emails_enabled', true)) {
            return;
        }

        $addresses = [];

        foreach ($users as $user) {
            if (!$user || !$user->email || !filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }
            if ($actor && (int) $actor->id === (int) $user->id) {
                continue;
            }
            if (isset($addresses[strtolower($user->email)])) {
                continue;
            }

            $gate = Gate::forUser($user);
            if (!$gate->allows('view', $ticket) || ($staffOnly && !$gate->allows('viewInternal', $ticket))) {
                continue;
            }

            $addresses[strtolower($user->email)] = $user->email;
        }

        foreach ($extraEmails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) && !isset($addresses[strtolower($email)])) {
                $addresses[strtolower($email)] = $email;
            }
        }

        foreach ($addresses as $email) {
            try {
                Mail::to($email)->send(new TicketNotificationMail($ticket, $headline, $body, $actor ? $actor->name : null));
            } catch (Throwable $e) {
                Log::warning('Support ticket email failed', [
                    'ticket' => $ticket->reference,
                    'to' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}
