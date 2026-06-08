<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonies extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'testimonies';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'image',
        'title',
        'description',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

}
