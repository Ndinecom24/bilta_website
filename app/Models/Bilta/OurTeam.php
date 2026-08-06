<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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
        'display_order',
        'from',
        'to',
        'facebook_url',
        'linkedin_url',
        'twitter_url',
        'created_by'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->width(400)
            ->height(420)
            ->sharpen(10)
            ->quality(80)
            ->nonQueued();
    }
}
