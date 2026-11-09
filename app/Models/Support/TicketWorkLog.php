<?php

namespace App\Models\Support;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TicketWorkLog extends Model
{
    public const BILLING_UNREVIEWED = 'unreviewed';
    public const BILLING_APPROVED = 'approved';
    public const BILLING_NON_BILLABLE = 'non_billable';

    protected $fillable = [
        'ticket_id', 'developer_id', 'work_date', 'hours', 'work_type', 'description',
        'is_billable', 'billable_hours', 'rate_applied', 'currency',
        'billing_status', 'billing_approved_by', 'billing_approved_at',
    ];

    protected $casts = [
        'work_date' => 'date',
        'hours' => 'float',
        'billable_hours' => 'float',
        'rate_applied' => 'float',
        'is_billable' => 'boolean',
        'billing_approved_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    public function billingApprover()
    {
        return $this->belongsTo(User::class, 'billing_approved_by');
    }

    public function getWorkTypeLabelAttribute(): string
    {
        return config('support.work_types.' . $this->work_type, ucfirst((string) $this->work_type));
    }

    /** Amount for approved billable work (hours x rate at the time of approval). */
    public function getBillableAmountAttribute(): float
    {
        if ($this->billing_status !== self::BILLING_APPROVED) {
            return 0.0;
        }

        return round(((float) $this->billable_hours) * ((float) $this->rate_applied), 2);
    }
}
