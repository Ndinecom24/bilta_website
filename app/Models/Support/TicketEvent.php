<?php

namespace App\Models\Support;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Append-only audit record. Rows are never updated.
 */
class TicketEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['ticket_id', 'user_id', 'event', 'from_value', 'to_value', 'note', 'meta', 'created_at'];

    protected $casts = [
        'meta' => 'array',
        'created_at' => 'datetime',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
