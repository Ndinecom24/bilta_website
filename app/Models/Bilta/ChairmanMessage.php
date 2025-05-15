<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ChairmanMessage extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['name', 'title', 'message', 'status_id', 'created_by'];

}