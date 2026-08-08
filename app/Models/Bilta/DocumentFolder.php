<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DocumentFolder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
        'visibility',
        'created_by',
        'sort_order',
    ];

    // ─── Relationships ───────────────────────────────────────────

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    // Recursive children for full tree
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'folder_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Access Control Relationships ────────────────────────────

    public function accessEntries()
    {
        return $this->hasMany(DocumentFolderAccess::class, 'folder_id');
    }

    public function departmentAccess()
    {
        return $this->accessEntries()->where('target_type', 'department');
    }

    public function userAccess()
    {
        return $this->accessEntries()->where('target_type', 'user');
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to only folders the given user can access.
     * Admin with manage-documents bypasses this.
     */
    public function scopeAccessibleBy($query, User $user)
    {
        if ($user->can('manage-documents')) {
            return $query; // Admins see everything
        }

        $userId = $user->id;
        $departmentId = $user->department_id;

        return $query->where(function ($q) use ($userId, $departmentId) {
            // Everyone folders
            $q->where('visibility', 'everyone')
              // Own folders (private or department)
              ->orWhere('created_by', $userId)
              // Folders shared with this user directly
              ->orWhereExists(function ($sub) use ($userId) {
                  $sub->select(DB::raw(1))
                      ->from('document_folder_access')
                      ->whereColumn('document_folder_access.folder_id', 'document_folders.id')
                      ->where('target_type', 'user')
                      ->where('target_id', $userId);
              });

            // Folders shared with user's department
            if ($departmentId) {
                $q->orWhereExists(function ($sub) use ($departmentId) {
                    $sub->select(DB::raw(1))
                        ->from('document_folder_access')
                        ->whereColumn('document_folder_access.folder_id', 'document_folders.id')
                        ->where('target_type', 'department')
                        ->where('target_id', $departmentId);
                });
            }
        });
    }

    // ─── Permission Helpers ──────────────────────────────────────

    /**
     * Check if a user can access this folder (view at minimum).
     */
    public function isAccessibleBy(User $user): bool
    {
        if ($user->can('manage-documents')) return true;
        if ($this->created_by == $user->id) return true;
        if ($this->visibility === 'everyone') return true;

        return $this->hasAccessEntry($user);
    }

    /**
     * Get the permission level for a user on this folder.
     * Returns: 'manage', 'edit', 'view', or null (no access).
     */
    public function getPermissionFor(User $user): ?string
    {
        if ($user->can('manage-documents')) return 'manage';
        if ($this->created_by == $user->id) return 'manage';

        if ($this->visibility === 'everyone') {
            // Check if there's a specific permission entry, otherwise default to view
            $specific = $this->getAccessPermission($user);
            return $specific ?? 'view';
        }

        return $this->getAccessPermission($user);
    }

    /**
     * Check if user can edit documents/subfolders in this folder.
     */
    public function canEdit(User $user): bool
    {
        $perm = $this->getPermissionFor($user);
        return in_array($perm, ['edit', 'manage']);
    }

    /**
     * Check if user can manage (delete, share, change visibility).
     */
    public function canManage(User $user): bool
    {
        $perm = $this->getPermissionFor($user);
        return $perm === 'manage';
    }

    /**
     * Check if the user has an explicit access entry (via user or department).
     */
    private function hasAccessEntry(User $user): bool
    {
        return $this->getAccessPermission($user) !== null;
    }

    /**
     * Get the highest permission from access entries for a user.
     */
    private function getAccessPermission(User $user): ?string
    {
        $permissions = [];

        // Direct user access
        $userEntry = $this->accessEntries()
            ->where('target_type', 'user')
            ->where('target_id', $user->id)
            ->first();

        if ($userEntry) {
            $permissions[] = $userEntry->permission;
        }

        // Department access
        if ($user->department_id) {
            $deptEntry = $this->accessEntries()
                ->where('target_type', 'department')
                ->where('target_id', $user->department_id)
                ->first();

            if ($deptEntry) {
                $permissions[] = $deptEntry->permission;
            }
        }

        if (empty($permissions)) return null;

        // Return highest: manage > edit > view
        $rank = ['manage' => 3, 'edit' => 2, 'view' => 1];
        return collect($permissions)->sortByDesc(fn($p) => $rank[$p] ?? 0)->first();
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public function getBreadcrumbAttribute()
    {
        $trail = collect();
        $folder = $this;

        while ($folder) {
            $trail->prepend($folder);
            $folder = $folder->parent;
        }

        return $trail;
    }

    public function getDocumentCountAttribute()
    {
        return $this->documents()->count();
    }

    /**
     * Visibility label for display.
     */
    public function getVisibilityLabelAttribute(): string
    {
        return match ($this->visibility) {
            'everyone' => 'Company-wide',
            'department' => 'Departments',
            'specific' => 'Specific Employees',
            'private' => 'Private',
            default => 'Unknown',
        };
    }

    /**
     * Visibility icon for display.
     */
    public function getVisibilityIconAttribute(): string
    {
        return match ($this->visibility) {
            'everyone' => 'fas fa-globe text-success',
            'department' => 'fas fa-building text-info',
            'specific' => 'fas fa-user-friends text-primary',
            'private' => 'fas fa-lock text-warning',
            default => 'fas fa-question text-muted',
        };
    }
}
