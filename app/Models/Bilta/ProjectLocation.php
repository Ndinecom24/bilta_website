<?php

namespace App\Models\Bilta;

use Illuminate\Database\Eloquent\Model;

class ProjectLocation extends Model
{
    protected $table = 'project_locations';

    protected $fillable = [
        'project_id',
        'name',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id', 'id');
    }
}
