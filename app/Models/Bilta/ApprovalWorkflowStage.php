<?php

namespace App\Models\Bilta;

use App\Models\System\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalWorkflowStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'workflow_id', 'name', 'role_id', 'stage_order', 'is_start', 'is_end',
    ];

    protected $casts = [
        'is_start' => 'boolean',
        'is_end'   => 'boolean',
    ];

    /* ---- Relationships ---- */

    public function workflow()
    {
        return $this->belongsTo(ApprovalWorkflow::class, 'workflow_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function approvalHistories()
    {
        return $this->hasMany(ApprovalHistory::class, 'stage_id');
    }

    /* ---- Helpers ---- */

    /**
     * Get the next stage in the workflow (null if this is the end).
     */
    public function nextStage()
    {
        if ($this->is_end) {
            return null;
        }

        return static::where('workflow_id', $this->workflow_id)
            ->where('stage_order', '>', $this->stage_order)
            ->orderBy('stage_order')
            ->first();
    }

    /**
     * Get the previous stage in the workflow (null if this is the start).
     */
    public function previousStage()
    {
        if ($this->is_start) {
            return null;
        }

        return static::where('workflow_id', $this->workflow_id)
            ->where('stage_order', '<', $this->stage_order)
            ->orderBy('stage_order', 'desc')
            ->first();
    }
}
