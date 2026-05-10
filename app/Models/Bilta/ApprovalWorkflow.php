<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalWorkflow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'form_type', 'description', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* ---- Relationships ---- */

    public function stages()
    {
        return $this->hasMany(ApprovalWorkflowStage::class, 'workflow_id')->orderBy('stage_order');
    }

    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class, 'workflow_id');
    }

    /* ---- Helpers ---- */

    public function startStage()
    {
        return $this->stages()->where('is_start', true)->first();
    }

    public function endStage()
    {
        return $this->stages()->where('is_end', true)->first();
    }

    /**
     * Get the active leave-type workflow.
     */
    public static function activeForLeave()
    {
        return static::where('form_type', 'leave')->where('is_active', true)->first();
    }
}
