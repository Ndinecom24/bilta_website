<?php

namespace App\Models\Bilta;
use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;


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

    
}
