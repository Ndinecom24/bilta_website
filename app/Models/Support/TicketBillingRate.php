<?php

namespace App\Models\Support;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class TicketBillingRate extends Model
{
    protected $fillable = ['name', 'hourly_rate', 'currency', 'developer_id', 'effective_from', 'effective_to', 'is_active'];

    protected $casts = [
        'hourly_rate' => 'float',
        'effective_from' => 'date',
        'effective_to' => 'date',
        'is_active' => 'boolean',
    ];

    public function developer()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }

    /**
     * Find the rate that applies to a developer on a given date.
     * A developer-specific rate wins over the default (developer_id = null) rate.
     */
    public static function resolve(?int $developerId, $date = null): ?self
    {
        $date = ($date ? Carbon::parse($date) : now())->toDateString();

        $base = static::where('is_active', true)
            ->whereDate('effective_from', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('effective_to')->orWhereDate('effective_to', '>=', $date);
            })
            ->orderByDesc('effective_from');

        if ($developerId) {
            $specific = (clone $base)->where('developer_id', $developerId)->first();
            if ($specific) {
                return $specific;
            }
        }

        return (clone $base)->whereNull('developer_id')->first();
    }
}
