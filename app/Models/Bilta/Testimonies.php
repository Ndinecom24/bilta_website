<?php

namespace App\Models\Bilta;

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
        'title',
        'description',
        'status_id',
    ];

}
