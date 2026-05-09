<?php

namespace App\Http\Livewire\System;

use App\Models\User;
use App\Models\System\Permission;
use App\Models\System\Role;
use Livewire\Component;

class RolesShow extends Component
{

    public $role;
    public $all_permissions = [];
    public $all_users = [];
    public $selectedPermissions = [];
    public $selectedUsers = [];

    protected $listeners = [
        'detachPermission' => 'detachPermission',
        'detachUser' => 'detachUser',
    ];

    public function mount(Role $role)
    {
        $role->load('permissions', 'users');
        $this->role = $role;
        $this->refreshRoleData();
    }

    public function render()
    {
        return view('livewire.system.role.show');
    }

    private function refreshRoleData()
    {
        $this->role = Role::with('permissions', 'users')->findOrFail($this->role->id);

        $this->all_permissions = Permission::whereNotIn('id', $this->role->permissions->pluck('id')->toArray())
            ->orderBy('name')
            ->get();

        $this->all_users = User::whereNotIn('id', $this->role->users->pluck('id')->toArray())
            ->orderBy('name')
            ->get();
    }

    public function roleAttachButton()
    {
        $this->refreshRoleData();
    }

    public function attachPermission()
    {
        if (empty($this->selectedPermissions)) {
            session()->flash('error', 'Select at least one permission to attach.');
            return;
        }

        $this->role->permissions()->syncWithoutDetaching($this->selectedPermissions);
        session()->flash('success', 'Permissions attached successfully.');
        $this->selectedPermissions = [];
        $this->refreshRoleData();
    }

    public function attachUsers()
    {
        if (empty($this->selectedUsers)) {
            session()->flash('error', 'Select at least one user to attach.');
            return;
        }

        $this->role->users()->syncWithoutDetaching($this->selectedUsers);
        session()->flash('success', 'Users attached successfully.');
        $this->selectedUsers = [];
        $this->refreshRoleData();

    }

    public function detachPermission($id)
    {
        $this->role->permissions()->detach($id);
        session()->flash('success', 'Permission detached successfully.');
        $this->refreshRoleData();
    }

    public function detachUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $this->role->users()->detach($user->id);
            session()->flash('success', 'User detached successfully.');
            $this->refreshRoleData();
            return;
        }

        session()->flash('error', 'User not found.');
    }




}
