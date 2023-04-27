<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AboutUs extends Model
{
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'mission',
        'vision',
        'objective',
        'description',
        'who_we_are',
        'what_is',
        'created_by'
    ];
}
