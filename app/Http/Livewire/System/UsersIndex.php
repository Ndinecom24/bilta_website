<?php

namespace App\Http\Livewire\System;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination ;
    public  $user_id, $email, $name, $phone ;

    public $roles = [] ;

    public $updateUser = false;
    protected $listeners = [
        'deleteUser'=>'destroy'
    ];

    // Validation Rules
    protected $rules = [
        'phone'=>'required',
        'name'=>'required',
        'email'=>'required'
    ];

    public function render()
    {
        $users = User::select('*')->paginate(20);
        return view('livewire.system.user.index')->with(compact('users'));
    }

    public function resetFields(){
        $this->name = '';
        $this->email = '';
        $this->phone = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create User
            User::create([
                'name'=>$this->name,
                'phone'=>$this->phone,
                'email'=>$this->email
            ]);

            // Set Flash Message
            session()->flash('success','User Created Successfully!!');
            // Reset Form Fields After Creating User
            $this->resetFields();

        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating user!!');
            // Reset Form Fields After Creating User
            $this->resetFields();
        }
    }
    public function edit($id){
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->user_id = $user->id;
        $this->updateUser = true;
    }
    public function cancel()
    {
        $this->updateUser = false;
        $this->resetFields();
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
            ])->save();
            session()->flash('success','User Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating user!!');
            $this->cancel();
        }
    }
    public function destroy($id){
        try{
            User::find($id)->delete();
            session()->flash('success',"User Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting user!!");
        }
    }
}
