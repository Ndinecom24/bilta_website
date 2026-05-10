<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalHistory extends Model
{
    use HasFactory;

    protected $table = 'approval_history';

    protected $fillable = [
        'leave_application_id', 'stage_id', 'acted_by', 'action', 'comment',
    ];

    /* ---- Relationships ---- */

    public function leaveApplication()
    {
        return $this->belongsTo(LeaveApplication::class);
    }

    public function stage()
    {
        return $this->belongsTo(ApprovalWorkflowStage::class, 'stage_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'acted_by');
    }
}
