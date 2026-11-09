<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'city',
        'address',
        'phone',
        'email',
        'manager_id',
        'description',
        'status_id',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(User::class, 'branch_id');
    }

    public function approvers()
    {
        return $this->hasMany(BranchApprover::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }
}
