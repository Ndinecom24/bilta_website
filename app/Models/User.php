<?php

namespace App\Models;

use App\Models\Bilta\Department;
use App\Models\System\Status;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        'department',
        'department_id',
        'nrc',
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

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function subordinates()
    {
        return $this->hasMany(User::class, 'supervisor_id');
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
     * Full name with position for display.
     */
    public function getDisplayLabelAttribute()
    {
        $label = $this->name;
        if ($this->position) {
            $label .= ' (' . $this->position . ')';
        }
        return $label;
    }

    /**
     * Get profile photo URL, or null if none uploaded.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path && \Storage::disk('public')->exists($this->profile_photo_path)) {
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
