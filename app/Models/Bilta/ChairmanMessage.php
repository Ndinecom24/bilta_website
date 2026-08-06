<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ChairmanMessage extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'title', 'message', 'status_id', 'created_by'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->width(400)
            ->height(400)
            ->sharpen(10)
            ->quality(80)
            ->nonQueued();
    }
}