<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'phone',
        'email',
        'address',
        'google_maps',
        'created_by',
        'facebook_url',
        'linkedin_url',
        'twitter_url',
        'youtube',
        'whatsapp_link',
    ];
}
