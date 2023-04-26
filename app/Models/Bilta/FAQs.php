<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQs extends Model
{
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'question',
        'answer',
        'created_by'
    ];
}
