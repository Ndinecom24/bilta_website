<?php

namespace App\Http\Livewire\System;

use App\Models\Bilta\Department;
use App\Models\System\Role;
use App\Models\System\Status;
use App\Models\System\UserFile;
use App\Models\User;
use App\Mail\PasswordResetOtpMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UsersShow extends Component
{
    use WithFileUploads;
    use WithPagination;

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
    public $canManageUserFiles = false;

    // OTP password reset
    public $lastOtp = null;
    public $otpEmailSent = false;
    public $otpEmailFailed = false;
    public $otpResetUser = null;

    // Profile photo
    public $profile_photo;

    // Tab navigation
    public $activeTab = 'profile';

    // Employee files
    public $user_file;
    public $user_file_type;
    public $user_file_title;
    public $user_file_description;
    public $filesPerPage = 10;
    public $file_filter_type = '';
    public $file_filter_date_from = '';
    public $file_filter_date_to = '';

    public $userFileTypeOptions = [
        'offer_letter' => 'Offer Letter',
        'appointment_letter' => 'Appointment Letter',
        'employment_contract' => 'Employment Contract',
        'contract_renewal' => 'Contract Renewal',
        'job_description' => 'Job Description',
        'resume_cv' => 'Resume / CV',
        'qualifications' => 'Qualifications / Certificates',
        'professional_license' => 'Professional License',
        'nrc_passport' => 'NRC / Passport Copy',
        'tax_napsa' => 'Tax / NAPSA Documents',
        'bank_details_form' => 'Bank Details Form',
        'medical_records' => 'Medical / Fitness Records',
        'performance_review' => 'Performance Review',
        'promotion_letter' => 'Promotion Letter',
        'disciplinary_notice' => 'Disciplinary Notice',
        'warning_letter' => 'Warning Letter',
        'training_certificate' => 'Training Certificate',
        'leave_document' => 'Leave Supporting Document',
        'transfer_letter' => 'Transfer Letter',
        'id_card_copy' => 'Staff ID Card Copy',
        'clearance_form' => 'Clearance Form',
        'exit_interview' => 'Exit Interview',
        'resignation_letter' => 'Resignation Letter',
        'termination_letter' => 'Termination Letter',
        'other' => 'Other',
    ];

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

        /** @var User $authUser */
        $authUser = auth()->user();

        // Non-admin users can only view their own profile
        $isOwnProfile = auth()->id() === $user->id;
        $isAdmin = $authUser->hasRole('admin') || $authUser->can('manage-users');
        $isHr = $authUser->hasRole('hr');
        $canViewOthers = $isAdmin || $isHr;

        if (!$isOwnProfile && !$canViewOthers) {
            abort(403, 'You do not have permission to view this profile.');
        }

        $this->isOwnProfile = $isOwnProfile;
        $this->canManage = $isAdmin;
        $this->canManageUserFiles = $canViewOthers;

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
        $this->user_file_type = 'offer_letter';
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
        $this->user = User::with('roles', 'status', 'files.uploader')->findOrFail($this->user->id);
        $this->all_roles = Role::whereNotIn('id', $this->user->roles->pluck('id')->toArray())
            ->orderBy('name')
            ->get();
    }

    public function getUserFilesQueryProperty()
    {
        $query = UserFile::with('uploader')
            ->where('user_id', $this->user->id);

        if (!empty($this->file_filter_type)) {
            $query->where('file_type', $this->file_filter_type);
        }

        if (!empty($this->file_filter_date_from)) {
            $dateFrom = Carbon::parse($this->file_filter_date_from)->startOfDay();
            $query->where('created_at', '>=', $dateFrom);
        }

        if (!empty($this->file_filter_date_to)) {
            $dateTo = Carbon::parse($this->file_filter_date_to)->endOfDay();
            $query->where('created_at', '<=', $dateTo);
        }

        return $query->latest();
    }

    public function getPaginatedUserFilesProperty()
    {
        return $this->userFilesQuery->paginate($this->filesPerPage);
    }

    public function resetUserFileFilters()
    {
        $this->file_filter_type = '';
        $this->file_filter_date_from = '';
        $this->file_filter_date_to = '';
        $this->resetPage();
    }

    public function updatedFileFilterType()
    {
        $this->resetPage();
    }

    public function updatedFileFilterDateFrom()
    {
        $this->resetPage();
    }

    public function updatedFileFilterDateTo()
    {
        $this->resetPage();
    }

    public function updatedFilesPerPage()
    {
        $this->resetPage();
    }

    public function exportUserFilesCsv()
    {
        $files = $this->userFilesQuery->get();

        if ($files->isEmpty()) {
            session()->flash('error', 'No files available for the selected filter.');
            return;
        }

        $filename = 'employee-files-' . $this->user->id . '-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($files) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Title', 'File Name', 'Type', 'Size', 'Uploaded By', 'Uploaded At', 'Description']);

            foreach ($files as $file) {
                fputcsv($handle, [
                    $file->title ?: $file->file_name,
                    $file->file_name,
                    $this->userFileTypeLabel($file->file_type),
                    $this->formatFileSize($file->file_size),
                    $file->uploader->name ?? 'System',
                    $file->created_at ? $file->created_at->format('Y-m-d H:i:s') : '',
                    $file->description ?? '',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function uploadUserFile()
    {
        if (!$this->canManageUserFiles) {
            session()->flash('error', 'You do not have permission to upload employee files.');
            return;
        }

        $this->validate([
            'user_file' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,webp,txt,csv',
            'user_file_type' => ['required', Rule::in(array_keys($this->userFileTypeOptions))],
            'user_file_title' => 'nullable|string|max:150',
            'user_file_description' => 'nullable|string|max:1000',
        ]);

        try {
            $storedPath = $this->user_file->store('user-files/' . $this->user_id, 'public');

            UserFile::create([
                'user_id' => $this->user_id,
                'uploaded_by' => auth()->id(),
                'file_type' => $this->user_file_type,
                'title' => $this->user_file_title ?: null,
                'description' => $this->user_file_description ?: null,
                'file_name' => $this->user_file->getClientOriginalName(),
                'file_path' => $storedPath,
                'mime_type' => $this->user_file->getMimeType(),
                'file_size' => $this->user_file->getSize() ?: 0,
            ]);

            $this->reset(['user_file', 'user_file_title', 'user_file_description']);
            $this->user_file_type = 'offer_letter';
            $this->refreshUserData();
            $this->resetPage();

            session()->flash('success', 'Employee file uploaded successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to upload file: ' . $e->getMessage());
        }
    }

    public function deleteUserFile($fileId)
    {
        if (!$this->canManageUserFiles) {
            session()->flash('error', 'You do not have permission to delete employee files.');
            return;
        }

        $file = UserFile::where('user_id', $this->user_id)->find($fileId);
        if (!$file) {
            session()->flash('error', 'File not found.');
            return;
        }

        try {
            if ($file->file_path && Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }
            $file->delete();
            $this->refreshUserData();
            $this->resetPage();
            session()->flash('success', 'Employee file deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete file.');
        }
    }

    public function formatFileSize($bytes)
    {
        $size = (int) $bytes;
        if ($size <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = min((int) floor(log($size, 1024)), count($units) - 1);
        $value = $size / (1024 ** $power);

        return number_format($value, $power === 0 ? 0 : 1) . ' ' . $units[$power];
    }

    public function userFileTypeLabel($type)
    {
        return $this->userFileTypeOptions[$type] ?? 'Other';
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

    /**
     * Upload profile photo.
     */
    public function uploadProfilePhoto()
    {
        $this->validate([
            'profile_photo' => 'required|image|max:2048', // 2MB max
        ]);

        try {
            $user = User::findOrFail($this->user_id);

            // Delete old photo if exists
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Store new photo
            $path = $this->profile_photo->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
            $user->save();

            $this->profile_photo = null;
            $this->refreshUserData();
            session()->flash('success', 'Profile photo updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to upload profile photo: ' . $e->getMessage());
        }
    }

    /**
     * Remove profile photo.
     */
    public function removeProfilePhoto()
    {
        try {
            $user = User::findOrFail($this->user_id);

            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->profile_photo_path = null;
            $user->save();

            $this->refreshUserData();
            session()->flash('success', 'Profile photo removed.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to remove profile photo.');
        }
    }

    /**
     * Switch active tab.
     */
    public function setTab($tab)
    {
        $this->activeTab = $tab;
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
        $this->activeTab = 'profile';
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
        $this->activeTab = 'edit';
    }

    public function togglePasswordReset()
    {
        $this->activeTab = 'security';
    }



}
