<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class Gallery extends Model implements HasMedia
{
    use \Spatie\MediaLibrary\InteractsWithMedia;
    use HasFactory;
    use \Illuminate\Database\Eloquent\SoftDeletes;


    protected $table = 'gallery_item';

    protected $fillable = [
        'name',
        'description',
        'type',
        'status_id',
        'item_category_id',
        'created_by'
    ];

    public function status(){
        return $this->belongsTo(Status::class) ;
    }
    public function category(){
        return $this->belongsTo(ItemCategory::class , 'item_category_id', 'id') ;
    }
}
