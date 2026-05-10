<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveApplication extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'leave_type_id', 'other_leave_type_text',
        'start_date', 'end_date', 'resume_date',
        'days_requested', 'reason', 'document_path', 'status',
        'acting_name', 'acting_cell', 'acting_position',
        'reviewed_by', 'reviewed_at', 'review_comment',
        'workflow_id', 'current_stage_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'resume_date' => 'date',
        'reviewed_at' => 'datetime',
        'days_requested' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function workflow()
    {
        return $this->belongsTo(ApprovalWorkflow::class, 'workflow_id');
    }

    public function currentStage()
    {
        return $this->belongsTo(ApprovalWorkflowStage::class, 'current_stage_id');
    }

    public function approvalHistory()
    {
        return $this->hasMany(ApprovalHistory::class)->orderBy('created_at');
    }

    /**
     * Calculate working days between start and end date (excluding weekends).
     */
    public static function calculateWorkingDays($startDate, $endDate): float
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $days = 0;

        while ($start->lte($end)) {
            if (!$start->isWeekend()) {
                $days++;
            }
            $start->addDay();
        }

        return $days;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeForYear($query, $year)
    {
        return $query->whereYear('start_date', $year);
    }
}
