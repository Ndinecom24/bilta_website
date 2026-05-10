<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'default_days',
        'requires_document', 'is_paid', 'carry_over',
        'max_carry_over_days', 'status_id',
    ];

    protected $casts = [
        'requires_document' => 'boolean',
        'is_paid' => 'boolean',
        'carry_over' => 'boolean',
    ];

    public function leaveApplications()
    {
        return $this->hasMany(LeaveApplication::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }
}
