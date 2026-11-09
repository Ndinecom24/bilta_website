<?php

namespace App\Policies;

use App\Models\Support\Ticket;
use App\Models\User;

class TicketPolicy
{
    private function isOwner(User $user, Ticket $ticket): bool
    {
        return $ticket->submitted_by !== null && (int) $ticket->submitted_by === (int) $user->id;
    }

    /** Ticket handling staff: developers and anyone allowed to assign. */
    public static function isStaff(User $user): bool
    {
        return $user->can('work-support-tickets') || $user->can('assign-support-tickets');
    }

    public function create(User $user): bool
    {
        return $user->can('submit-support-tickets');
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return Ticket::visibleTo($user)->whereKey($ticket->getKey())->exists();
    }

    /** May the user read internal (developer-only) notes? */
    public function viewInternal(User $user, Ticket $ticket): bool
    {
        return self::isStaff($user) && $this->view($user, $ticket);
    }

    public function comment(User $user, Ticket $ticket): bool
    {
        return $ticket->status !== Ticket::STATUS_CLOSED && $this->view($user, $ticket);
    }

    /**
     * Developer actions (status, estimates, work logs, documentation).
     * Developers act on tickets assigned to them or still unassigned (to accept them).
     * People who can assign tickets may act on any ticket.
     */
    public function work(User $user, Ticket $ticket): bool
    {
        if ($user->can('assign-support-tickets')) {
            return true;
        }

        return $user->can('work-support-tickets')
            && ($ticket->assigned_to === null || (int) $ticket->assigned_to === (int) $user->id);
    }

    public function assign(User $user, Ticket $ticket): bool
    {
        return $user->can('assign-support-tickets');
    }

    /** A developer can accept (self-assign) an unassigned ticket. */
    public function accept(User $user, Ticket $ticket): bool
    {
        return $user->can('work-support-tickets')
            && $ticket->assigned_to === null
            && $ticket->isOpen();
    }

    /** Owner confirms the resolution (closes the ticket). */
    public function close(User $user, Ticket $ticket): bool
    {
        return $ticket->status === Ticket::STATUS_RESOLVED
            && ($this->isOwner($user, $ticket) || $user->can('assign-support-tickets'));
    }

    public function reopen(User $user, Ticket $ticket): bool
    {
        return in_array($ticket->status, [Ticket::STATUS_RESOLVED, Ticket::STATUS_CLOSED], true)
            && ($this->isOwner($user, $ticket) || $user->can('assign-support-tickets'));
    }
}
