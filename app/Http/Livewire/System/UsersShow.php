<?php

namespace App\Http\Livewire\System;

use App\Models\System\Role;
use App\Models\User;
use Livewire\Component;

class UsersShow extends Component
{
    public $user ;
    public $all_roles = [];
    public $selectedRoles = [] ;

    protected $listeners = [
        'detachRole'=>'detachRole',
    ];

    public function mount(User $user){
        $user->load('roles');
        $this->user = $user ;
    }

    public function render()
    {
        return view('livewire.system.user.show');
    }

    public function roleAttachButton (){
        $this->all_roles = Role::whereNotIn('id', $this->user->roles->pluck('id')->toArray() )->get();
    }

    public function attachRole(){
        $this->user->roles()->syncWithoutDetaching( $this->selectedRoles );
        session()->flash('success', 'Users Attached Successfully');
        $this->user = User::find($this->user->id );
        $this->roleAttachButton();

    }

    public function detachRole($id){
        $this->user->roles()->detach( $id );
        session()->flash('success', 'Users Detached Successfully');
        $this->user = User::find($this->user->id );
        $this->roleAttachButton();
    }




}
