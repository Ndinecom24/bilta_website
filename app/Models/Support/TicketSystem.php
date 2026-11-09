<?php

namespace App\Models\Support;

use Illuminate\Database\Eloquent\Model;

class TicketSystem extends Model
{
    protected $fillable = ['name', 'slug', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'system_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
