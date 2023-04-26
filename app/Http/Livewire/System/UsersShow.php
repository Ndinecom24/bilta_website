<?php

namespace App\Http\Livewire\System;

use App\Models\System\Role;
use App\Models\System\Status;
use App\Models\User;
use Livewire\Component;

class UsersShow extends Component
{
    public $user , $phone , $name , $email, $status_id  ;
    public $all_roles = [];
    public $selectedRoles = [] ;
    public $statuses = [] ;

    protected $listeners = [
        'detachRole'=>'detachRole',
    ];

    public function mount(User $user){
        $user->load('roles');
        $this->user = $user ;
        $this->phone= $user->phone ;
        $this->email= $user->email ;
        $this->name= $user->name ;
        $this->status_id= $user->status_id ;
        $this->statuses = Status::select('id', 'name')->get();
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
