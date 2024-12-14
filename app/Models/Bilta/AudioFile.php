<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

class AudioFile  extends Model implements HasMedia
{
    use \Spatie\MediaLibrary\InteractsWithMedia;
    use HasFactory;

    protected $table=  'audio_files'; 

    protected $fillable = [
    'title',
    'description',
    'file_url',
    'status_id',
    'project_id',
    'created_by',
    ] ;

    public function status (){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function project (){
        return $this->belongsTo( Projects::class, 'project_id', 'id');
    }

}
