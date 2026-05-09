<?php

namespace App\Http\Livewire\System;

use App\Models\System\Role;
use App\Models\System\Status;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UsersShow extends Component
{
    public $user, $user_id, $email, $name, $phone, $status_id, $password, $password_confirmation, $password_change, $role_id;

    public $updateUser = false;
    public $showPasswordReset = false;

    public $all_roles = [];
    public $selectedRoles = [];
    public $statuses = [];

    protected $listeners = [
        'detachRole' => 'detachRole',
        'deleteUser' => 'destroy'
    ];


    // Validation Rules
    protected function rules()
    {
        return [
            'phone' => 'required',
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id)],
            'status_id' => 'required',
        ];
    }

    protected $passwordRules = [
        'password' => 'required|string|min:8|confirmed',
    ];


    public function mount($uuid)
    {
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }

        $user->load('roles');
        $this->user = $user;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->name = $user->name;
        $this->user_id = $user->id;
        $this->status_id = $user->status_id;
        $this->statuses = Status::select('id', 'name')->get();
        $this->refreshUserData();
    }

    public function render()
    {
        $roles = Role::orderBy('name')->get();
        $statuses = Status::get();
        return view('livewire.system.user.show')->with(compact('roles', 'statuses'));
    }

    private function refreshUserData()
    {
        $this->user = User::with('roles', 'status')->findOrFail($this->user->id);
        $this->all_roles = Role::whereNotIn('id', $this->user->roles->pluck('id')->toArray())
            ->orderBy('name')
            ->get();
    }

    public function roleAttachButton()
    {
        $this->refreshUserData();
    }

    public function attachRole()
    {
        if (empty($this->selectedRoles)) {
            session()->flash('error', 'Select at least one role to attach.');
            return;
        }

        $this->user->roles()->syncWithoutDetaching($this->selectedRoles);
        session()->flash('success', 'Roles attached successfully.');
        $this->selectedRoles = [];
        $this->refreshUserData();

    }

    public function detachRole($id)
    {
        $this->user->roles()->detach($id);
        session()->flash('success', 'Role detached successfully.');
        $this->refreshUserData();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update user
            User::find($this->user_id)->fill([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'status_id' => $this->status_id,
            ])->save();
            $this->user = User::find($this->user_id);
            session()->flash('success', 'User updated successfully.');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating user!!');
            $this->cancel();
        }
    }

    public function updatePassword()
    {
        $this->validate($this->passwordRules);
        try {
            // Update user
            User::find($this->user_id)->fill([
                'password' => Hash::make($this->password),
                'password_change' => 0
            ])->save();
            $this->user = User::find($this->user_id);
            session()->flash('success', 'User password reset successfully.');

            $this->password = '';
            $this->password_confirmation = '';
            $this->showPasswordReset = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating user password!!');
            $this->cancel();
        }
    }


    public function destroy($id)
    {
        try {
            User::find($id)->delete();
            session()->flash('success', "User Deleted Successfully!!");

            return Redirect::route('system.users');
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting user!!");
        }
    }

    public function cancel()
    {
        $this->updateUser = false;
        $this->showPasswordReset = false;
        $this->password = '';
        $this->password_confirmation = '';
        $this->refreshUserData();
    }

    public function toggleEdit()
    {
        $this->updateUser = true;
        $this->showPasswordReset = false;
    }

    public function togglePasswordReset()
    {
        $this->showPasswordReset = true;
        $this->updateUser = false;
    }



}
