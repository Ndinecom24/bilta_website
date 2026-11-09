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

    public function positions()
    {
        return $this->hasMany(Position::class, 'leave_workflow_id');
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

    /**
     * Resolve the leave workflow a given employee must follow.
     *
     * 1. The workflow linked to the employee's position (if active and it has stages).
     * 2. Otherwise the default: an active leave workflow not linked to any position.
     * Returns null when neither exists.
     */
    public static function forUser($user)
    {
        $position = $user ? $user->positionRelation : null;

        if ($position && $position->leave_workflow_id) {
            $workflow = static::where('id', $position->leave_workflow_id)
                ->where('form_type', 'leave')
                ->where('is_active', true)
                ->first();

            if ($workflow && $workflow->stages()->exists()) {
                return $workflow;
            }
        }

        return static::where('form_type', 'leave')
            ->where('is_active', true)
            ->whereDoesntHave('positions')
            ->whereHas('stages')
            ->orderBy('id')
            ->first();
    }
}
