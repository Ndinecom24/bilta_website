<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DocumentFolderAccess extends Model
{
    protected $table = 'document_folder_access';

    protected $fillable = [
        'folder_id',
        'target_type',
        'target_id',
        'permission',
        'granted_by',
    ];

    public function folder()
    {
        return $this->belongsTo(DocumentFolder::class, 'folder_id');
    }

    public function grantedBy()
    {
        return $this->belongsTo(User::class, 'granted_by');
    }

    /**
     * Get the target entity (Department or User).
     */
    public function target()
    {
        if ($this->target_type === 'department') {
            return $this->belongsTo(Department::class, 'target_id');
        }

        return $this->belongsTo(User::class, 'target_id');
    }

    /**
     * Permission label for display.
     */
    public function getPermissionLabelAttribute(): string
    {
        return match ($this->permission) {
            'view' => 'View Only',
            'edit' => 'Can Edit',
            'manage' => 'Full Control',
            default => 'Unknown',
        };
    }

    /**
     * Permission badge class for display.
     */
    public function getPermissionBadgeAttribute(): string
    {
        return match ($this->permission) {
            'view' => 'badge-info',
            'edit' => 'badge-primary',
            'manage' => 'badge-success',
            default => 'badge-secondary',
        };
    }
}
