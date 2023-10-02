<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeeklyPrayerPoints extends Model
{
    use HasFactory;
    use SoftDeletes ;

    protected $fillable = [
        'status_id',
        'post_date',
        'details',
        'title',
        'scriptures',
        'year',
        'month',
        'week',
        'day',
        'created_by'
    ];

    protected $with = [
        'status'
    ];
    public function status (){
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
}
