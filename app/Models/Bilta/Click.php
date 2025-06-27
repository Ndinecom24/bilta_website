<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User ;

class Click extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'page_name',
        'method',
        'referrer',
        'ip_address',
        'user_agent',
        'device_type',
        'platform',
        'browser',
        'user_id',
        'session_id',
        'country',
        'city',
        'region',
        'timezone',
        'latitude',
        'longitude',
    ];

    /**
     * Optional relationship to User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
