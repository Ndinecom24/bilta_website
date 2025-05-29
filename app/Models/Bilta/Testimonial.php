<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{

    use HasFactory;
    use SoftDeletes;

    protected $table = 'testimonials';
    protected $fillable = [
        'name',
        'title',
        'testimonial',
        'status_id',
        'created_by'
    ];

    public function status(){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

}
