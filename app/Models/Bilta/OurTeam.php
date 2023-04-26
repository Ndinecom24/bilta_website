<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class OurTeam extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'details',
        'position',
        'from',
        'to',
        'facebook_url',
        'linkedin_url',
        'twitter_url',
        'created_by'
    ];
}
