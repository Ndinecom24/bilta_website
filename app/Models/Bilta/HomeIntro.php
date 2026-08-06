<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HomeIntro extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'short_description',
        'long_description',
        'created_by'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->width(1200)
            ->height(800)
            ->sharpen(10)
            ->quality(80)
            ->nonQueued();

        $this->addMediaConversion('thumb')
            ->width(600)
            ->height(400)
            ->sharpen(10)
            ->quality(75)
            ->nonQueued();
    }
}
