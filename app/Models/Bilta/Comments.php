<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    use HasFactory;
   
    protected $fillable = ['commentable_id', 'commentable_type','body'];

    public function audio()
    {
        return $this->belongsTo(AudioFile::class);
    }
    
}
