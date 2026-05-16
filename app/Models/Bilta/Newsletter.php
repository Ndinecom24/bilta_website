<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Newsletter extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $table = 'newsletters';

    protected $fillable = [
        'title',
        'short_description',
        'content',
        'publish_date',
        'status_id',
        'created_by',
        'display_order',
        'emails_sent',
        'emails_sent_at',
    ];

    protected $casts = [
        'emails_sent' => 'boolean',
        'emails_sent_at' => 'datetime',
    ];

    protected $with = ['status'];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
