<?php

namespace App\Http\Livewire\System;

use App\Models\Bilta\Branch;
use App\Models\Bilta\Department;
use App\Models\Bilta\Position;
use App\Models\System\Role;
use App\Models\System\Status;
use App\Mail\NewUserWelcomeMail;
use App\Models\User;
use App\Services\UserPasswordEnforcement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class UsersIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 20;
    public $showCreateForm = false;
    public $confirmInactiveReset = false;
    public  $user_id, $email, $name, $phone, $status_id, $password_change, $role_id ;

    // HR fields
    public $position, $position_id, $department_id, $branch_id, $nrc, $man_number, $employee_id;
    public $additionalResponsibilities = [];
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
        'position_id' => 'nullable|exists:positions,id',
        'department_id' => 'nullable|exists:departments,id',
        'branch_id' => 'nullable|exists:branches,id',
        'additionalResponsibilities' => 'array',
        'additionalResponsibilities.*.department_id' => 'required|exists:departments,id',
        'additionalResponsibilities.*.position' => 'nullable|string|max:100',
        'additionalResponsibilities.*.position_id' => 'nullable|exists:positions,id',
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
        $users = User::with('departmentRelation', 'positionRelation', 'departmentResponsibilities', 'supervisor', 'status', 'roles')
            ->when($this->search, function ($query) {
                $term = '%' . trim($this->search) . '%';
                $query->where(function ($searchQuery) use ($term) {
                    $searchQuery->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhere('employee_id', 'like', $term);
                });
            })
            ->orderBy('name')
            ->paginate((int) $this->perPage);
        $statuses = Status::get();
        $departments = Department::where('status_id', 1)->orderBy('name')->get();
        $positions = Position::where('status_id', 1)->orderBy('name')->get();
        $branches = Branch::where('status_id', 1)->orderBy('name')->get(['id', 'name', 'code']);
        $supervisors = User::whereHas('roles', function ($query) {
            $query->whereRaw('LOWER(roles.slug) = ?', ['supervisor']);
            })
            ->orderBy('name')
            ->select('id', 'name', 'position', 'position_id')
            ->get();
        $passwordEnforcement = app(UserPasswordEnforcement::class);
        $pendingPasswordChanges = $passwordEnforcement->countPendingPasswordChanges();
        $inactiveUsersDueForReset = $passwordEnforcement->countInactiveUsersDueForReset();

        return view('livewire.system.user.index')->with(compact(
            'users', 'statuses', 'departments', 'positions', 'branches', 'supervisors',
            'pendingPasswordChanges', 'inactiveUsersDueForReset'
        ));
    }

    public function updatedPositionId($value)
    {
        if ($value) {
            $pos = Position::find($value);
            $this->position = $pos ? $pos->name : '';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function toggleCreateForm()
    {
        $this->showCreateForm = !$this->showCreateForm;
    }

    public function sendPasswordReminders()
    {
        if (!$this->canManagePasswordEnforcement()) {
            abort(403);
        }

        $result = app(UserPasswordEnforcement::class)->sendPendingPasswordReminders(true);
        session()->flash('success', "Password reminders sent: {$result['sent']}; failed: {$result['failed']}.");
    }

    public function confirmInactivePasswordResets()
    {
        if (!$this->canManagePasswordEnforcement()) {
            abort(403);
        }

        $this->confirmInactiveReset = true;
    }

    public function forceInactivePasswordResets()
    {
        if (!$this->canManagePasswordEnforcement()) {
            abort(403);
        }

        if (!$this->confirmInactiveReset) {
            return;
        }

        $result = app(UserPasswordEnforcement::class)->forceResetInactiveUsers(true);
        $this->confirmInactiveReset = false;
        session()->flash('success', "Inactive-user password resets issued: {$result['sent']}; failed: {$result['failed']}. Eligible administrators are excluded from automatic resets.");
    }

    public function cancelInactivePasswordResets()
    {
        $this->confirmInactiveReset = false;
    }

    private function canManagePasswordEnforcement()
    {
        $userId = auth()->id();

        return $userId && Role::where('slug', 'admin')
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->exists();
    }

    public function resetFields(){
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->status_id = '';
        $this->role_id = '';
        $this->position = '';
        $this->position_id = null;
        $this->department_id = '';
        $this->branch_id = '';
        $this->additionalResponsibilities = [];
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
    public function addResponsibility()
    {
        $this->additionalResponsibilities[] = ['department_id' => '', 'position' => '', 'position_id' => ''];
    }

    public function removeResponsibility($index)
    {
        unset($this->additionalResponsibilities[$index]);
        $this->additionalResponsibilities = array_values($this->additionalResponsibilities);
    }

    public function store(){
        $this->showCreateForm = true;
        // Validate Form Request
        $this->validate();
        if ($this->supervisor_id && !User::whereKey($this->supervisor_id)->whereHas('roles', function ($query) {
            $query->whereRaw('LOWER(roles.slug) = ?', ['supervisor']);
        })->exists()) {
            $this->addError('supervisor_id', 'The selected user must have the Supervisor role.');
            return;
        }
        $responsibilityDepartmentIds = array_filter(array_column($this->additionalResponsibilities, 'department_id'));
        if (count($responsibilityDepartmentIds) !== count(array_unique($responsibilityDepartmentIds))) {
            $this->addError('additionalResponsibilities', 'Select each additional department only once.');
            return;
        }
        if ($this->department_id && in_array((string) $this->department_id, array_map('strval', $responsibilityDepartmentIds), true)) {
            $this->addError('additionalResponsibilities', 'The primary department cannot also be listed as an added responsibility.');
            return;
        }
        try{
            $uuid = Str::uuid()->toString();
            $temporaryPassword = Str::random(12);

            $posId = $this->position_id ?: null;
            $posName = $this->position ?: null;
            if ($posId && empty($posName)) {
                $posName = Position::find($posId)?->name;
            } elseif ($posName && empty($posId)) {
                $posId = Position::where('name', $posName)->value('id');
            }

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
                'position' => $posName,
                'position_id' => $posId,
                'department_id' => $this->department_id ?: null,
                'branch_id' => $this->branch_id ?: null,
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

            $responsibilities = [];
            foreach ($this->additionalResponsibilities as $responsibility) {
                if (!empty($responsibility['department_id'])) {
                    $rPosId = !empty($responsibility['position_id']) ? $responsibility['position_id'] : null;
                    $rPosName = !empty($responsibility['position']) ? $responsibility['position'] : null;
                    if ($rPosId && empty($rPosName)) {
                        $rPosName = Position::find($rPosId)?->name;
                    } elseif ($rPosName && empty($rPosId)) {
                        $rPosId = Position::where('name', $rPosName)->value('id');
                    }
                    $responsibilities[$responsibility['department_id']] = [
                        'position' => $rPosName,
                        'position_id' => $rPosId,
                    ];
                }
            }
            $user->departmentResponsibilities()->sync($responsibilities);

            $mailSent = true;
            try {
                Mail::to($user->email)->send(new NewUserWelcomeMail($user, $temporaryPassword));
                $user->password_reminder_sent_at = now();
                $user->save();
            } catch (\Throwable $mailException) {
                $mailSent = false;
                Log::error('New user welcome email failed.', [
                    'user_id' => $user->id,
                    'exception' => $mailException,
                ]);
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
            $this->showCreateForm = false;

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
