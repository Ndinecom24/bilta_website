<?php

namespace App\Http\Livewire\System;

use App\Models\System\Role;
use App\Models\System\Status;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination ;
    public  $user_id, $email, $name, $phone, $status_id, $password , $password_change, $role_id ;

    public $updateUser = false;
    protected $listeners = [
        'deleteUser'=>'destroy'
    ];

    // Validation Rules
    protected $rules = [
        'phone'=>'required',
        'name'=>'required',
        'email'=>'required',
        'status_id' => 'required',
        'role_id' => 'required',
    ];

    public function render()
    {
        $users = User::select('*')->paginate(20);
        $roles = Role::get();
        $statuses = Status::get();
        return view('livewire.system.user.index')->with(compact('users', 'roles', 'statuses'));
    }

    public function resetFields(){
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->status_id = '';
        $this->password = '';
        $this->role_id = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            $uuid = Str::uuid()->toString();
            // Create User
            $user = User::create([
                'name'=>$this->name,
                'phone'=>$this->phone,
                'email'=>$this->email,
                'status_id'=>$this->status_id,
                'password_change'=> 0 ,
                'logins' => 0 ,
                'password' => Hash::make($this->password),
                'uuid'=>$uuid,
            ]);

            $user->roles()->syncWithoutDetaching($this->role_id);


            // Set Flash Message
            session()->flash('success','User Created Successfully!!');

            // Reset Form Fields After Creating User
            $this->resetFields();

        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating user!!'.$e->getMessage());

            // Reset Form Fields After Creating User
            $this->resetFields();
        }
    }

    public function edit($id){
        $user = User::findOrFail($id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->status_id = $user->status_id;
        $this->user_id = $user->id;
        $this->updateUser = true;
    }
    public function cancel()
    {
        $this->updateUser = false;
        $this->resetFields();
    }

}
