<?php

namespace App\Http\Livewire\Admin;

use App\Models\Bilta\ApprovalWorkflowStage;
use App\Models\Bilta\Branch;
use App\Models\Bilta\BranchApprover;
use App\Models\System\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBranches extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Form
    public $branch_id;
    public $name;
    public $code;
    public $city;
    public $address;
    public $phone;
    public $email;
    public $manager_id;
    public $description;
    public $status_id = 1;

    // UI state
    public $search = '';
    public $filterStatus = '';
    public $showForm = false;
    public $isEdit = false;
    public $viewingId = null;
    public $assignUserId = '';

    // Leave approvers (role -> people) for the branch being viewed
    public $approverRoleId = '';
    public $approverUserIds = [];

    protected $listeners = ['deleteBranch' => 'destroy'];

    protected function rules()
    {
        return [
            'name'        => 'required|string|max:100',
            'code'        => 'nullable|string|max:20',
            'city'        => 'nullable|string|max:100',
            'address'     => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:30',
            'email'       => 'nullable|email|max:255',
            'manager_id'  => 'nullable|exists:users,id',
            'description' => 'nullable|string|max:2000',
            'status_id'   => 'required|integer',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    /* ---- Permissions ---- */

    private function allows(string $specific): bool
    {
        $user = auth()->user();

        return $user && ($user->can($specific) || $user->can('manage-branches'));
    }

    /* ---- Render ---- */

    public function render()
    {
        $query = Branch::with(['manager', 'status'])
            ->withCount([
                'employees',
                'employees as active_employees_count' => function ($q) {
                    $q->where('status_id', 1);
                },
            ]);

        if ($this->search !== '') {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('code', 'like', "%{$s}%")
                    ->orWhere('city', 'like', "%{$s}%");
            });
        }
        if ($this->filterStatus !== '') {
            $query->where('status_id', $this->filterStatus);
        }

        $branches = $query->orderByDesc('employees_count')->orderBy('name')->paginate(15);

        $approverRoles = collect();
        $approverCandidates = collect();
        $approverAssignments = collect();
        if ($this->viewingId) {
            // Roles that review leave: every role used in a leave workflow, plus Supervisor.
            $approverRoles = Role::whereIn('id', ApprovalWorkflowStage::whereHas('workflow', function ($w) {
                    $w->where('form_type', 'leave');
                })->select('role_id'))
                ->orWhere('slug', 'supervisor')
                ->orderBy('name')
                ->get(['id', 'name', 'slug']);

            if ($this->approverRoleId) {
                $approverCandidates = User::whereHas('roles', function ($r) {
                    $r->where('roles.id', $this->approverRoleId);
                })->orderBy('name')->get(['users.id', 'users.name', 'users.position']);
            }

            $approverAssignments = BranchApprover::with(['role', 'user'])
                ->where('branch_id', $this->viewingId)
                ->get()
                ->sortBy(function ($row) {
                    return optional($row->role)->name . '|' . optional($row->user)->name;
                })
                ->groupBy('role_id');
        }

        return view('livewire.admin.branches', [
            'branches'     => $branches,
            'approverRoles'       => $approverRoles,
            'approverCandidates'  => $approverCandidates,
            'approverAssignments' => $approverAssignments,
            'stats'        => $this->overallStats(),
            'users'        => User::orderBy('name')->get(['id', 'name']),
            'detail'       => $this->viewingId ? $this->branchDetail((int) $this->viewingId) : null,
            'unassigned'   => $this->viewingId
                ? User::whereNull('branch_id')->orderBy('name')->get(['id', 'name'])
                : collect(),
        ]);
    }

    /**
     * Organisation-wide numbers to help HR compare branches.
     */
    private function overallStats(): array
    {
        $totalEmployees = User::count();
        $assigned = User::whereNotNull('branch_id')->count();

        $ranked = Branch::withCount('employees')
            ->orderByDesc('employees_count')
            ->orderBy('name')
            ->get();

        $largest = $ranked->first();
        $smallest = $ranked->where('status_id', 1)->sortBy('employees_count')->first();

        return [
            'branches'        => $ranked->count(),
            'active_branches' => $ranked->where('status_id', 1)->count(),
            'assigned'        => $assigned,
            'unassigned'      => $totalEmployees - $assigned,
            'total_employees' => $totalEmployees,
            'average'         => $ranked->count() ? round($assigned / $ranked->count(), 1) : 0,
            'largest'         => $largest,
            'smallest'        => $smallest,
            'ranking'         => $ranked->take(8),
            'max_count'       => (int) $ranked->max('employees_count'),
        ];
    }

    /**
     * Details and breakdowns for a single branch.
     */
    private function branchDetail(int $id): ?array
    {
        $branch = Branch::with('manager')->find($id);
        if (!$branch) {
            return null;
        }

        $employees = $branch->employees()
            ->with(['departmentRelation', 'positionRelation', 'status'])
            ->orderBy('name')
            ->get();

        $count = function ($items) {
            return $items->map(function ($group) {
                return $group->count();
            })->sortDesc();
        };

        $tenure = $employees->filter(function ($u) {
            return $u->date_joined;
        })->map(function ($u) {
            return $u->date_joined->diffInDays(now()) / 365.25;
        });

        return [
            'branch'        => $branch,
            'employees'     => $employees,
            'active'        => $employees->where('status_id', 1)->count(),
            'by_department' => $count($employees->groupBy(function ($u) {
                return optional($u->departmentRelation)->name ?: 'No department';
            })),
            'by_position'   => $count($employees->groupBy(function ($u) {
                return optional($u->positionRelation)->name ?: ($u->position ?: 'No position');
            })),
            'by_contract'   => $count($employees->groupBy(function ($u) {
                return $u->contract_type ? ucfirst($u->contract_type) : 'Not set';
            })),
            'by_gender'     => $count($employees->groupBy(function ($u) {
                return $u->gender ? ucfirst($u->gender) : 'Not set';
            })),
            'avg_tenure'    => $tenure->isNotEmpty() ? round($tenure->avg(), 1) : null,
        ];
    }

    /* ---- CRUD ---- */

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetFields();
        }
    }

    public function store()
    {
        if (!$this->allows('create-branches')) {
            session()->flash('error', 'You do not have permission to create branches.');
            return;
        }

        $this->validate();

        Branch::create($this->payload($this->uniqueSlug($this->name, 0)));

        session()->flash('success', 'Branch created successfully.');
        $this->resetFields();
        $this->showForm = false;
    }

    public function edit($id)
    {
        if (!$this->allows('edit-branches')) {
            session()->flash('error', 'You do not have permission to edit branches.');
            return;
        }

        $b = Branch::findOrFail($id);
        $this->branch_id   = $b->id;
        $this->name        = $b->name;
        $this->code        = $b->code;
        $this->city        = $b->city;
        $this->address     = $b->address;
        $this->phone       = $b->phone;
        $this->email       = $b->email;
        $this->manager_id  = $b->manager_id;
        $this->description = $b->description;
        $this->status_id   = $b->status_id;
        $this->isEdit      = true;
        $this->showForm    = true;
    }

    public function update()
    {
        if (!$this->allows('edit-branches')) {
            session()->flash('error', 'You do not have permission to edit branches.');
            return;
        }

        $this->validate();

        $branch = Branch::findOrFail($this->branch_id);
        $branch->update($this->payload($this->uniqueSlug($this->name, $branch->id)));

        session()->flash('success', 'Branch updated successfully.');
        $this->resetFields();
        $this->showForm = false;
    }

    public function destroy($id)
    {
        if (!$this->allows('delete-branches')) {
            session()->flash('error', 'You do not have permission to delete branches.');
            return;
        }

        $branch = Branch::findOrFail($id);
        if ($branch->employees()->exists()) {
            session()->flash('error', 'Cannot delete a branch with assigned employees. Reassign them first.');
            return;
        }

        $branch->delete();
        if ((int) $this->viewingId === (int) $id) {
            $this->viewingId = null;
        }
        session()->flash('success', 'Branch deleted successfully.');
    }

    /* ---- Detail view & employee assignment ---- */

    public function viewBranch($id)
    {
        $this->viewingId = Branch::findOrFail($id)->id;
        $this->assignUserId = '';
        $this->resetApproverForm();
    }

    public function closeView()
    {
        $this->viewingId = null;
        $this->assignUserId = '';
        $this->resetApproverForm();
    }

    public function assignEmployee()
    {
        if (!$this->allows('edit-branches') || !$this->viewingId) {
            session()->flash('error', 'You do not have permission to assign employees to branches.');
            return;
        }

        $this->validate(['assignUserId' => 'required|exists:users,id'], [
            'assignUserId.required' => 'Select an employee to assign.',
        ]);

        User::whereKey($this->assignUserId)->update(['branch_id' => $this->viewingId]);
        $this->assignUserId = '';
        session()->flash('success', 'Employee assigned to branch.');
    }

    public function removeEmployee($userId)
    {
        if (!$this->allows('edit-branches') || !$this->viewingId) {
            session()->flash('error', 'You do not have permission to change branch assignments.');
            return;
        }

        User::whereKey($userId)->where('branch_id', $this->viewingId)->update(['branch_id' => null]);
        session()->flash('success', 'Employee removed from branch.');
    }

    /* ---- Leave approvers (role + people for this branch) ---- */

    /**
     * Picking a role pre-ticks the people already assigned for it.
     */
    public function updatedApproverRoleId($value)
    {
        $this->loadApproverSelection();
    }

    private function loadApproverSelection(): void
    {
        $this->approverUserIds = ($this->viewingId && $this->approverRoleId)
            ? BranchApprover::where('branch_id', $this->viewingId)
                ->where('role_id', $this->approverRoleId)
                ->pluck('user_id')
                ->map(function ($id) {
                    return (string) $id;
                })->all()
            : [];
    }

    private function resetApproverForm(): void
    {
        $this->approverRoleId = '';
        $this->approverUserIds = [];
    }

    public function saveApprovers()
    {
        if (!$this->allows('edit-branches') || !$this->viewingId) {
            session()->flash('error', 'You do not have permission to assign branch approvers.');
            return;
        }

        $this->validate([
            'approverRoleId' => 'required|exists:roles,id',
            'approverUserIds' => 'array',
            'approverUserIds.*' => 'exists:users,id',
        ], [
            'approverRoleId.required' => 'Select a role first.',
        ]);

        $branchId = (int) $this->viewingId;
        $roleId = (int) $this->approverRoleId;

        // Only people who actually hold the role can be assigned for it.
        $userIds = User::whereIn('id', (array) $this->approverUserIds)
            ->whereHas('roles', function ($r) use ($roleId) {
                $r->where('roles.id', $roleId);
            })->pluck('id');

        DB::transaction(function () use ($branchId, $roleId, $userIds) {
            BranchApprover::where('branch_id', $branchId)->where('role_id', $roleId)
                ->whereNotIn('user_id', $userIds)->delete();

            foreach ($userIds as $userId) {
                BranchApprover::firstOrCreate(['branch_id' => $branchId, 'role_id' => $roleId, 'user_id' => $userId]);
            }
        });

        $this->loadApproverSelection();
        session()->flash('success', 'Branch approvers saved.');
    }

    public function removeApprover($assignmentId)
    {
        if (!$this->allows('edit-branches') || !$this->viewingId) {
            session()->flash('error', 'You do not have permission to assign branch approvers.');
            return;
        }

        BranchApprover::whereKey($assignmentId)->where('branch_id', $this->viewingId)->delete();
        $this->loadApproverSelection();
        session()->flash('success', 'Approver removed from branch.');
    }

    /* ---- Helpers ---- */

    private function payload(string $slug): array
    {
        return [
            'name'        => $this->name,
            'slug'        => $slug,
            'code'        => $this->code ? strtoupper(trim($this->code)) : null,
            'city'        => $this->city ?: null,
            'address'     => $this->address ?: null,
            'phone'       => $this->phone ?: null,
            'email'       => $this->email ?: null,
            'manager_id'  => $this->manager_id ?: null,
            'description' => $this->description ?: null,
            'status_id'   => $this->status_id,
        ];
    }

    private function uniqueSlug(string $name, int $ignoreId): string
    {
        $base = Str::slug($name) ?: 'branch';
        $slug = $base;
        $counter = 1;
        while (Branch::where('slug', $slug)->where('id', '!=', $ignoreId)->exists()) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    private function resetFields()
    {
        $this->branch_id = null;
        $this->name = '';
        $this->code = '';
        $this->city = '';
        $this->address = '';
        $this->phone = '';
        $this->email = '';
        $this->manager_id = '';
        $this->description = '';
        $this->status_id = 1;
        $this->isEdit = false;
        $this->resetErrorBag();
    }
}
