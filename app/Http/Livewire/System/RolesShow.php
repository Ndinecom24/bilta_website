<?php

namespace App\Http\Livewire\System;

use App\Models\System\Permission;
use App\Models\System\Role;
use http\Client\Curl\User;
use Livewire\Component;

class RolesShow extends Component
{

    public $role ;
    public $all_permissions = [];
    public $selectedPermissions = [] ;

    protected $listeners = [
        'detachPermission'=>'detachPermission',
        'detachUser'=>'detachUser',
    ];

    public function mount(Role $role){
        $role->load('permissions', 'users');
        $this->role = $role ;
    }

    public function render()
    {
        return view('livewire.system.role.show');
    }

    public function roleAttachButton (){
        $this->all_permissions = Permission::whereNotIn('id', $this->role->permissions->pluck('id')->toArray() )->get();
    }

    public function attachPermission(){
        $this->role->permissions()->syncWithoutDetaching( $this->selectedPermissions );
        session()->flash('success', 'Roles Attached Successfully');
        $this->role = Role::find($this->role->id );
        $this->roleAttachButton();

    }

    public function detachPermission($id){
        $this->role->permissions()->detach( $id );
        session()->flash('success', 'Roles Detached Successfully');
        $this->role = Role::find($this->role->id );
        $this->roleAttachButton();
    }

    public function detachUser($id){
        $user = User::find($id);
        $user->roles()->detach( $this->role );
        session()->flash('success', 'User Detached Successfully');
        $this->role = Role::find($this->role->id );
    }




}
