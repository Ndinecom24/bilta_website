<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class Projects  extends Model implements HasMedia
{
    use \Spatie\MediaLibrary\InteractsWithMedia;
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;

    use HasFactory;

    protected $table = 'projects';
    protected $fillable = [
        'title',
        'details',
        'post_date' ,
        'author',
        'short_description' ,
        'location' ,
        'location_map' ,
        'category_id' ,
        'status_id' ,
        'created_by'
    ] ;

    protected $with = [
        'status',
        'myCategory'
    ];

    public function status (){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function myCategory (){
        return $this->belongsTo( ItemCategory::class, 'category_id', 'id');
    }

}
