<?php

namespace App\Models\Bilta;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFolder extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'description',
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

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
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
}
