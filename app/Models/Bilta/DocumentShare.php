<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DocumentShare extends Model
{
    protected $fillable = [
        'document_id',
        'target_type',
        'target_id',
        'permission',
        'granted_by',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }

    public function grantedBy()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }

    public function getPermissionLabelAttribute(): string
    {
        return match ($this->permission) {
            'view' => 'View Only',
            'edit' => 'Can Edit',
            'manage' => 'Full Control',
            default => 'Unknown',
        };
    }
}
