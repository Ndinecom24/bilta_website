<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Document extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'extension',
        'description',
        'folder_id',
        'uploaded_by',
    ];

    // ─── Relationships ───────────────────────────────────────────

    public function folder()
    {
        return $this->belongsTo(DocumentFolder::class, 'folder_id');
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function shares()
    {
        return $this->hasMany(DocumentShare::class, 'document_id');
    }

    // ─── Access Control ──────────────────────────────────────────

    /**
     * Check if user can access this document.
     * Access is inherited from folder + individual shares.
     */
    public function isAccessibleBy(User $user): bool
    {
        if ($user->can('manage-documents')) return true;
        if ($this->uploaded_by == $user->id) return true;

        // Check folder access
        if ($this->folder && $this->folder->isAccessibleBy($user)) return true;

        // Check individual document shares
        return $this->hasShareEntry($user);
    }

    /**
     * Get permission level for user on this document.
     * Takes the highest from folder permission and individual shares.
     */
    public function getPermissionFor(User $user): ?string
    {
        if ($user->can('manage-documents')) return 'manage';
        if ($this->uploaded_by == $user->id) return 'manage';

        $permissions = [];

        // Folder-level permission
        if ($this->folder) {
            $folderPerm = $this->folder->getPermissionFor($user);
            if ($folderPerm) $permissions[] = $folderPerm;
        }

        // Direct document share permission
        $sharePerm = $this->getSharePermission($user);
        if ($sharePerm) $permissions[] = $sharePerm;

        if (empty($permissions)) return null;

        $rank = ['manage' => 3, 'edit' => 2, 'view' => 1];
        return collect($permissions)->sortByDesc(fn($p) => $rank[$p] ?? 0)->first();
    }

    public function canEdit(User $user): bool
    {
        $perm = $this->getPermissionFor($user);
        return in_array($perm, ['edit', 'manage']);
    }

    public function canManage(User $user): bool
    {
        return $this->getPermissionFor($user) === 'manage';
    }

    private function hasShareEntry(User $user): bool
    {
        return $this->getSharePermission($user) !== null;
    }

    private function getSharePermission(User $user): ?string
    {
        $permissions = [];

        $userShare = $this->shares()
            ->where('target_type', 'user')
            ->where('target_id', $user->id)
            ->first();

        if ($userShare) $permissions[] = $userShare->permission;

        if ($user->department_id) {
            $deptShare = $this->shares()
                ->where('target_type', 'department')
                ->where('target_id', $user->department_id)
                ->first();

            if ($deptShare) $permissions[] = $deptShare->permission;
        }

        if (empty($permissions)) return null;

        $rank = ['manage' => 3, 'edit' => 2, 'view' => 1];
        return collect($permissions)->sortByDesc(fn($p) => $rank[$p] ?? 0)->first();
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;

        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }

        return $bytes . ' B';
    }

    public function getIconClassAttribute()
    {
        return match ($this->extension) {
            'pdf' => 'fas fa-file-pdf text-danger',
            'doc', 'docx' => 'fas fa-file-word text-primary',
            'xls', 'xlsx' => 'fas fa-file-excel text-success',
            'ppt', 'pptx' => 'fas fa-file-powerpoint text-warning',
            'zip', 'rar', '7z' => 'fas fa-file-archive text-secondary',
            'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp' => 'fas fa-file-image text-info',
            'mp4', 'avi', 'mov' => 'fas fa-file-video text-purple',
            'mp3', 'wav' => 'fas fa-file-audio text-pink',
            default => 'fas fa-file text-muted',
        };
    }

    public function isPreviewable()
    {
        return in_array($this->extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']);
    }
}
