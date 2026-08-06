<?php

namespace App\Http\Livewire\System;

use App\Models\Bilta\Department;
use App\Models\System\Role;
use App\Models\System\Status;
use App\Models\User;
use App\Mail\PasswordResetOtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UsersShow extends Component
{
    public $user, $user_id, $email, $name, $phone, $status_id, $password, $password_confirmation, $password_change, $role_id;

    // HR fields
    public $position, $department_id, $nrc, $man_number, $employee_id;
    public $date_of_birth, $gender, $date_joined, $contract_type;
    public $address, $emergency_contact_name, $emergency_contact_phone;
    public $supervisor_id;

    public $updateUser = false;
    public $showPasswordReset = false;
    public $isOwnProfile = false;
    public $canManage = false;

    // OTP password reset
    public $lastOtp = null;
    public $otpEmailSent = false;
    public $otpEmailFailed = false;
    public $otpResetUser = null;

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

        // Non-admin users can only view their own profile
        $isOwnProfile = auth()->id() === $user->id;
        $isAdmin = auth()->user()->hasRole('admin') || auth()->user()->can('manage-users');

        if (!$isOwnProfile && !$isAdmin) {
            abort(403, 'You do not have permission to view this profile.');
        }

        $this->isOwnProfile = $isOwnProfile;
        $this->canManage = $isAdmin;

        $user->load('roles');
        $this->user = $user;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->name = $user->name;
        $this->user_id = $user->id;
        $this->status_id = $user->status_id;

        // HR fields
        $this->position = $user->position;
        $this->department_id = $user->department_id;
        $this->nrc = $user->nrc;
        $this->man_number = $user->man_number;
        $this->employee_id = $user->employee_id;
        $this->date_of_birth = $user->date_of_birth ? $user->date_of_birth->format('Y-m-d') : '';
        $this->gender = $user->gender;
        $this->date_joined = $user->date_joined ? $user->date_joined->format('Y-m-d') : '';
        $this->contract_type = $user->contract_type;
        $this->address = $user->address;
        $this->emergency_contact_name = $user->emergency_contact_name;
        $this->emergency_contact_phone = $user->emergency_contact_phone;
        $this->supervisor_id = $user->supervisor_id;

        $this->statuses = Status::select('id', 'name')->get();
        $this->refreshUserData();
    }

    public function render()
    {
        $roles = Role::orderBy('name')->get();
        $statuses = Status::get();
        $departments = Department::where('status_id', 1)->orderBy('name')->get();
        $supervisors = User::where('id', '!=', $this->user_id)->orderBy('name')->select('id', 'name', 'position')->get();
        return view('livewire.system.user.show')->with(compact('roles', 'statuses', 'departments', 'supervisors'));
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
        if (!$this->canManage) {
            session()->flash('error', 'You do not have permission to manage roles.');
            return;
        }

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
        if (!$this->canManage) {
            session()->flash('error', 'You do not have permission to manage roles.');
            return;
        }

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
                'password_change' => 0,
                'password_reset_otp' => null,
                'password_reset_otp_expires_at' => null,
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

    /**
     * Generate OTP, set as temp password, flag user for forced change, send email.
     */
    public function resetPasswordWithOtp()
    {
        if (!$this->canManage) {
            session()->flash('error', 'You do not have permission to reset passwords.');
            return;
        }

        // Cannot reset own password via OTP
        if ($this->isOwnProfile) {
            session()->flash('error', 'You cannot OTP-reset your own password. Use the manual password reset instead.');
            return;
        }

        try {
            // Generate a 6-digit OTP
            $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

            $user = User::findOrFail($this->user_id);
            $user->password = Hash::make($otp);
            $user->password_change = 1;
            $user->password_reset_otp = $otp;
            $user->password_reset_otp_expires_at = now()->addHours(72);
            $user->save();

            // Store OTP for admin display
            $this->lastOtp = $otp;
            $this->otpResetUser = $user->name;

            // Send email
            $this->otpEmailSent = false;
            $this->otpEmailFailed = false;
            try {
                Mail::to($user->email)->send(new PasswordResetOtpMail($user, $otp, auth()->user()->name));
                $this->otpEmailSent = true;
            } catch (\Exception $mailEx) {
                $this->otpEmailFailed = true;
            }

            $this->refreshUserData();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while resetting password: ' . $e->getMessage());
        }
    }

    /**
     * Dismiss the OTP display card.
     */
    public function dismissOtp()
    {
        $this->lastOtp = null;
        $this->otpEmailSent = false;
        $this->otpEmailFailed = false;
        $this->otpResetUser = null;
    }


    public function destroy($id)
    {
        if (!$this->canManage) {
            session()->flash('error', 'You do not have permission to delete users.');
            return;
        }

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
        $this->lastOtp = null;
        $this->otpEmailSent = false;
        $this->otpEmailFailed = false;
        $this->otpResetUser = null;
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
