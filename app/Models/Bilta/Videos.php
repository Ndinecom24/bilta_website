<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    use HasFactory;


    protected $table = 'video_item';

    protected $fillable = [
        'name',
        'description',
        'type',
        'status_id',
        'video_link',
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
