<?php

namespace App\Http\Livewire\System;

use App\Models\Bilta\Department;
use App\Models\System\Role;
use App\Models\System\Status;
use App\Mail\NewUserWelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination ;
    public  $user_id, $email, $name, $phone, $status_id, $password_change, $role_id ;

    // HR fields
    public $position, $department_id, $nrc, $man_number, $employee_id;
    public $date_of_birth, $gender, $date_joined, $contract_type;
    public $address, $emergency_contact_name, $emergency_contact_phone;
    public $supervisor_id;

    public $updateUser = false;
    protected $listeners = [
        'deleteUser'=>'destroy'
    ];

    // Validation Rules
    protected $rules = [
        'phone'=>'required',
        'name'=>'required',
        'email'=>'required|email|unique:users,email',
        'status_id' => 'required',
        'position' => 'nullable|string|max:100',
        'department_id' => 'nullable|exists:departments,id',
        'nrc' => 'nullable|string|max:30',
        'man_number' => 'nullable|string|max:30',
        'employee_id' => 'nullable|string|max:50',
        'date_of_birth' => 'nullable|date',
        'gender' => 'nullable|in:male,female,other',
        'date_joined' => 'nullable|date',
        'contract_type' => 'nullable|in:permanent,contract,part-time,intern,volunteer',
        'supervisor_id' => 'nullable|exists:users,id',
    ];

    public function render()
    {
        $users = User::with('departmentRelation', 'supervisor')->select('*')->paginate(20);
        $statuses = Status::get();
        $departments = Department::where('status_id', 1)->orderBy('name')->get();
        $supervisors = User::orderBy('name')->select('id', 'name', 'position')->get();
        return view('livewire.system.user.index')->with(compact('users', 'statuses', 'departments', 'supervisors'));
    }

    public function resetFields(){
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->status_id = '';
        $this->role_id = '';
        $this->position = '';
        $this->department_id = '';
        $this->nrc = '';
        $this->man_number = '';
        $this->employee_id = '';
        $this->date_of_birth = '';
        $this->gender = '';
        $this->date_joined = '';
        $this->contract_type = '';
        $this->address = '';
        $this->emergency_contact_name = '';
        $this->emergency_contact_phone = '';
        $this->supervisor_id = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            $uuid = Str::uuid()->toString();
            $temporaryPassword = Str::random(12);
            // Create User
            $user = User::create([
                'name'=>$this->name,
                'phone'=>$this->phone,
                'email'=>$this->email,
                'status_id'=>$this->status_id,
                'password_change'=> 1 ,
                'logins' => 0 ,
                'password' => Hash::make($temporaryPassword),
                'uuid'=>$uuid,
                'position' => $this->position ?: null,
                'department_id' => $this->department_id ?: null,
                'nrc' => $this->nrc ?: null,
                'man_number' => $this->man_number ?: null,
                'employee_id' => $this->employee_id ?: null,
                'date_of_birth' => $this->date_of_birth ?: null,
                'gender' => $this->gender ?: null,
                'date_joined' => $this->date_joined ?: null,
                'contract_type' => $this->contract_type ?: null,
                'address' => $this->address ?: null,
                'emergency_contact_name' => $this->emergency_contact_name ?: null,
                'emergency_contact_phone' => $this->emergency_contact_phone ?: null,
                'supervisor_id' => $this->supervisor_id ?: null,
            ]);

            // Assign 'employee' role by default (fallback to 'viewer' for backward compatibility)
            $defaultRole = Role::where('slug', 'employee')->first()
                ?? Role::where('slug', 'viewer')->first();
            if ($defaultRole) {
                $user->roles()->syncWithoutDetaching([$defaultRole->id]);
            }

            $mailSent = true;
            try {
                Mail::to($user->email)->send(new NewUserWelcomeMail($user, $temporaryPassword));
            } catch (\Exception $mailException) {
                $mailSent = false;
            }


            // Set Flash Message
            session()->flash(
                'success',
                $mailSent
                    ? 'User created successfully. Temporary password has been emailed.'
                    : 'User created successfully, but the welcome email could not be sent.'
            );

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
