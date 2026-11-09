<?php

namespace App\Models\Bilta;

use App\Models\System\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * A user who acts in a given role for the leave applications of one branch.
 */
class BranchApprover extends Model
{
    protected $fillable = ['branch_id', 'role_id', 'user_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
