<?php

namespace App\Models\Bilta;

use App\Models\User;
use App\Models\System\Status;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'code',
        'description',
        'head_id',
        'status_id',
    ];

    public function head()
    {
        return $this->belongsTo(User::class, 'head_id');
    }

    public function members()
    {
        return $this->hasMany(User::class, 'department_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getMemberCountAttribute()
    {
        return $this->members()->count();
    }
}
