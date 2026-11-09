<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    protected $fillable = ['name', 'slug', 'level', 'resolution_target_hours', 'color', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
        'resolution_target_hours' => 'integer',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'priority_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('level');
    }
}
