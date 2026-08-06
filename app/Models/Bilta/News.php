<?php

namespace App\Models\Bilta;
use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class News extends Model implements HasMedia
{
    use \Spatie\MediaLibrary\InteractsWithMedia;
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $table = 'news_item' ;

    protected $fillable = [
        'title',
        'details',
        'post_date' ,
        'author',
        'short_description' ,
        'category_id' ,
        'display_order' ,
        'status_id' ,
        'created_by'
    ] ;

    protected $with = [
        'status',
        'category'
    ];

    public function status (){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function category (){
        return $this->belongsTo( ItemCategory::class, 'category_id', 'id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('optimized')
            ->width(600)
            ->height(340)
            ->sharpen(10)
            ->quality(80)
            ->nonQueued();
    }
}
