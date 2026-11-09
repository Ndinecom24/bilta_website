<?php

namespace App\Models\Bilta;

use App\Models\User;
use App\Models\System\Status;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'department_id',
        'leave_workflow_id',
        'status_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function leaveWorkflow()
    {
        return $this->belongsTo(ApprovalWorkflow::class, 'leave_workflow_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'position_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    public function getUsersCountAttribute()
    {
        return $this->users()->count();
    }
}
