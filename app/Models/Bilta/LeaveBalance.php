<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'leave_type_id', 'year',
        'total_days', 'used_days', 'carried_over',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    /**
     * Get remaining balance.
     */
    public function getRemainingAttribute(): float
    {
        return ($this->total_days + $this->carried_over) - $this->used_days;
    }
}
