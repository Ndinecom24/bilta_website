<?php

namespace App\Models\Bilta;

use App\Models\System\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Announcement extends Model implements HasMedia
{
    use HasFactory;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'type',
        'content',
        'publish_date',
        'expiry_date',
        'priority',
        'visibility',
        'visible_to',
        'status_id',
        'is_archived',
        'created_by',
    ];

    protected $casts = [
        'publish_date' => 'date',
        'expiry_date' => 'date',
        'is_archived' => 'boolean',
        'visible_to' => 'array',
    ];

    protected $with = ['status'];

    // ─── Relationships ───────────────────────────────────────────

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function reads()
    {
        return $this->hasMany(AnnouncementRead::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status_id', config('constants.status.active'))
            ->where('publish_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('expiry_date')
                  ->orWhere('expiry_date', '>=', now());
            });
    }

    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public function isReadBy($userId)
    {
        return $this->reads()->where('user_id', $userId)->exists();
    }

    public function markAsRead($userId)
    {
        return $this->reads()->firstOrCreate([
            'user_id' => $userId,
        ], [
            'read_at' => now(),
        ]);
    }

    public function getPriorityBadgeAttribute()
    {
        return match ($this->priority) {
            'high' => 'danger',
            'normal' => 'primary',
            'low' => 'secondary',
            default => 'secondary',
        };
    }

    public function getTypeBadgeAttribute()
    {
        return match ($this->type) {
            'memo' => 'info',
            'announcement' => 'success',
            default => 'secondary',
        };
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('announcement_attachments');
    }
}
