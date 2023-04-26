<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OurValues extends Model
{
    use HasFactory;
    use SoftDeletes ;
    protected $fillable = [
        'title',
        'description',
        'created_by'
    ];
}
