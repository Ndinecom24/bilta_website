<?php

namespace App\Models;

use App\Models\Bilta\Department;
use App\Models\Bilta\Branch;
use App\Models\Bilta\Position;
use App\Models\Bilta\Click;
use App\Models\System\UserFile;
use App\Models\System\Status;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'phone',
        'position',
        'position_id',
        'department',
        'department_id',
        'branch_id',
        'man_number',
        'employee_id',
        'date_of_birth',
        'gender',
        'date_joined',
        'contract_type',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'supervisor_id',
        'logins',
        'last_login',
        'status_id',
        'password_change',
        'password_reset_otp',
        'password_reset_otp_expires_at',
        'password_reminder_sent_at',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'date_joined' => 'date',
        'password_reset_otp_expires_at' => 'datetime',
        'password_reminder_sent_at' => 'datetime',
    ];

    // ──────────────────────────────────────
    // Relationships
    // ──────────────────────────────────────

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function departmentRelation()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function positionRelation()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Users holding a permission, either through a role or directly.
     */
    public function scopeWithPermission($query, string $slug)
    {
        return $query->where(function ($q) use ($slug) {
            $q->whereHas('roles.permissions', function ($p) use ($slug) {
                $p->where('permissions.slug', $slug);
            })->orWhereHas('permissions', function ($p) use ($slug) {
                $p->where('permissions.slug', $slug);
            });
        });
    }

    public function departmentResponsibilities()
    {
        return $this->belongsToMany(Department::class, 'user_department_responsibilities')
            ->withPivot('position', 'position_id')
            ->withTimestamps();
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'supervisor_id');
    }

    public function files()
    {
        return $this->hasMany(UserFile::class)->latest();
    }

    public function clicks()
    {
        return $this->hasMany(Click::class);
    }

    // ──────────────────────────────────────
    // Accessors
    // ──────────────────────────────────────

    /**
     * Return department name from the departments table,
     * falling back to the legacy text 'department' column.
     */
    public function getDepartmentNameAttribute()
    {
        return $this->departmentRelation->name ?? $this->department ?? '—';
    }

    /**
     * Return position title from the positions table,
     * falling back to the legacy text 'position' column.
     */
    public function getPositionNameAttribute()
    {
        return $this->positionRelation->name ?? $this->position ?? '—';
    }

    /**
     * Full name with position for display.
     */
    public function getDisplayLabelAttribute()
    {
        $pos = $this->positionRelation->name ?? $this->position;
        $label = $this->name;
        if ($pos) {
            $label .= ' (' . $pos . ')';
        }
        return $label;
    }

    /**
     * Get profile photo URL, or null if none uploaded.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path && Storage::disk('public')->exists($this->profile_photo_path)) {
            return asset('storage/' . $this->profile_photo_path);
        }
        return null;
    }

    /**
     * Get initials from the user's name (max 2 letters).
     */
    public function getInitialsAttribute()
    {
        return collect(explode(' ', $this->name))
            ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->take(2)
            ->implode('');
    }
}
