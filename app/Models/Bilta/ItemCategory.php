<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    use HasFactory;

    protected $table = 'item_categories';

    protected $fillable = [
        'name',
        'description',
        'type',
        'status_id',
        'created_by'
    ];

    public function status(){
        return $this->belongsTo(Status::class) ;
    }
}
