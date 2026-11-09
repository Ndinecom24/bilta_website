<?php

namespace App\Models\Support;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public const STATUS_NEW = 'new';
    public const STATUS_ACKNOWLEDGED = 'acknowledged';
    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_AWAITING_FEEDBACK = 'awaiting_feedback';
    public const STATUS_ON_HOLD = 'on_hold';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_CLOSED = 'closed';
    public const STATUS_REOPENED = 'reopened';

    /** label + bootstrap colour for every status */
    public const STATUSES = [
        'new'               => ['label' => 'New',               'color' => 'primary'],
        'acknowledged'      => ['label' => 'Acknowledged',      'color' => 'info'],
        'assigned'          => ['label' => 'Assigned',          'color' => 'info'],
        'in_progress'       => ['label' => 'In Progress',       'color' => 'warning'],
        'awaiting_feedback' => ['label' => 'Awaiting Feedback', 'color' => 'dark'],
        'on_hold'           => ['label' => 'On Hold',           'color' => 'secondary'],
        'resolved'          => ['label' => 'Resolved',          'color' => 'success'],
        'closed'            => ['label' => 'Closed',            'color' => 'dark'],
        'reopened'          => ['label' => 'Reopened',          'color' => 'danger'],
    ];

    /** Allowed status transitions (from => [to, ...]). */
    public const TRANSITIONS = [
        'new'               => ['acknowledged', 'assigned', 'in_progress', 'on_hold'],
        'acknowledged'      => ['assigned', 'in_progress', 'awaiting_feedback', 'on_hold'],
        'assigned'          => ['in_progress', 'awaiting_feedback', 'on_hold'],
        'in_progress'       => ['awaiting_feedback', 'on_hold', 'resolved'],
        'awaiting_feedback' => ['in_progress', 'on_hold'],
        'on_hold'           => ['in_progress', 'assigned'],
        'resolved'          => ['closed', 'reopened'],
        'closed'            => ['reopened'],
        'reopened'          => ['acknowledged', 'assigned', 'in_progress'],
    ];

    /** Statuses that count as finished work (not "open"). */
    public const FINAL_STATUSES = ['resolved', 'closed'];

    protected $fillable = [
        'reference', 'subject', 'description', 'status',
        'category_id', 'system_id', 'priority_id',
        'submitted_by', 'assigned_to',
        'estimated_hours', 'due_date',
        'acknowledged_at', 'started_at', 'resolved_at', 'closed_at', 'last_activity_at',
        'reopen_count',
        'technical_findings', 'resolution_notes', 'outstanding_requirements',
    ];

    protected $casts = [
        'due_date' => 'date',
        'acknowledged_at' => 'datetime',
        'started_at' => 'datetime',
        'resolved_at' => 'datetime',
        'closed_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'estimated_hours' => 'float',
        'reopen_count' => 'integer',
    ];

    /* ---- Relationships ---- */

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function system()
    {
        return $this->belongsTo(TicketSystem::class, 'system_id');
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    public function submitter()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(TicketComment::class)->orderBy('created_at');
    }

    public function attachments()
    {
        return $this->hasMany(TicketAttachment::class);
    }

    public function events()
    {
        return $this->hasMany(TicketEvent::class)->orderBy('created_at')->orderBy('id');
    }

    public function workLogs()
    {
        return $this->hasMany(TicketWorkLog::class)->orderByDesc('work_date')->orderByDesc('id');
    }

    /* ---- Status helpers ---- */

    public static function statusOptions(): array
    {
        return array_map(function ($s) {
            return $s['label'];
        }, self::STATUSES);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status]['label'] ?? ucfirst(str_replace('_', ' ', (string) $this->status));
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUSES[$this->status]['color'] ?? 'secondary';
    }

    public function allowedTransitions(): array
    {
        return self::TRANSITIONS[$this->status] ?? [];
    }

    public function canTransitionTo(string $status): bool
    {
        return in_array($status, $this->allowedTransitions(), true);
    }

    public function isOpen(): bool
    {
        return !in_array($this->status, self::FINAL_STATUSES, true);
    }

    public function isOverdue(): bool
    {
        return $this->due_date !== null
            && $this->isOpen()
            && $this->due_date->lt(now()->startOfDay());
    }

    /* ---- Hours ---- */

    public function getActualHoursAttribute(): float
    {
        return (float) $this->workLogs->sum('hours');
    }

    public function getBillableHoursAttribute(): float
    {
        return (float) $this->workLogs->where('billing_status', 'approved')->sum('billable_hours');
    }

    /* ---- Scopes ---- */

    public function scopeOpen($query)
    {
        return $query->whereNotIn('status', self::FINAL_STATUSES);
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotNull('due_date')
            ->whereDate('due_date', '<', now()->toDateString())
            ->whereNotIn('status', self::FINAL_STATUSES);
    }

    /**
     * Restrict a query to the tickets a user is allowed to see.
     *  - view-all / assign permission: everything
     *  - developers: tickets assigned to them plus the unassigned queue
     *  - everyone else: only tickets they submitted
     */
    public function scopeVisibleTo($query, User $user)
    {
        if ($user->can('view-all-support-tickets') || $user->can('assign-support-tickets')) {
            return $query;
        }

        $isDeveloper = $user->can('work-support-tickets');

        return $query->where(function ($q) use ($user, $isDeveloper) {
            $q->where('tickets.submitted_by', $user->id)
                ->orWhere('tickets.assigned_to', $user->id);

            if ($isDeveloper) {
                $q->orWhereNull('tickets.assigned_to');
            }
        });
    }
}
