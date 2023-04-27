<?php

namespace App\Http\Livewire\System;

use App\Models\System\Role;
use App\Models\System\Status;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class UsersShow extends Component
{
    public $user , $user_id, $email, $name, $phone, $status_id, $password , $password_change, $role_id ;

    public $all_roles = [];
    public $selectedRoles = [] ;
    public $statuses = [] ;

    protected $listeners = [
        'detachRole'=>'detachRole',
        'deleteUser' => 'destroy'
    ];


    // Validation Rules
    protected $rules = [
        'phone'=>'required',
        'name'=>'required',
        'email'=>'required',
        'status_id' => 'required',
    ];


    public function mount( $uuid){
        $user = User::where('uuid', $uuid)->first();
        $user->load('roles');
        $this->user = $user ;
        $this->phone= $user->phone ;
        $this->email= $user->email ;
        $this->name= $user->name ;
        $this->user_id= $user->id ;
        $this->status_id= $user->status_id ;
        $this->statuses = Status::select('id', 'name')->get();
    }

    public function render()
    {
        $roles = Role::get();
        $statuses = Status::get();
        return view('livewire.system.user.show')->with(compact('roles', 'statuses'));
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

    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update user
            User::find($this->user_id)->fill([
                'name'=>$this->name,
                'email'=>$this->email,
                'phone'=>$this->phone,
                'status_id'=>$this->status_id,
            ])->save();
            $this->user = User::find($this->user_id);
            session()->flash('success','User Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating user!!');
            $this->cancel();
        }
    }
    public function updatePassword(){
        // Validate request
        try{
            // Update user
            User::find($this->user_id)->fill([
                'password'=>Hash::make($this->password),
                'password_change' => 0
            ])->save();
            $this->user = User::find($this->user_id);
            session()->flash('success','User Password Updated Successfully!!');

            $this->password = '';
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating user!!');
            $this->cancel();
        }
    }


    public function destroy($id){
        try{
            User::find($id)->delete();
            session()->flash('success',"User Deleted Successfully!!");

            Redirect::route('system.users');
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting user!!");
        }
    }

    public function cancel()
    {
        $this->updateUser = false;
    }



}
