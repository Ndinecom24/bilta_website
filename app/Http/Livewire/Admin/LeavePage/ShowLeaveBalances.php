<?php

namespace App\Http\Livewire\Admin\LeavePage;

use App\Models\Bilta\LeaveBalance;
use App\Models\Bilta\LeaveType;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ShowLeaveBalances extends Component
{
    use WithPagination;

    public $filterYear;
    public $filterUser = '';

    // Allocation form
    public $alloc_user_id, $alloc_leave_type_id, $alloc_total_days, $alloc_carried_over;
    public $showAllocForm = false;

    protected $listeners = ['deleteBalance' => 'destroyBalance'];

    public function mount()
    {
        $this->filterYear = date('Y');
        $this->alloc_total_days = 0;
        $this->alloc_carried_over = 0;
    }

    public function render()
    {
        $query = LeaveBalance::with(['user', 'leaveType'])
            ->where('year', $this->filterYear)
            ->orderBy('user_id');

        if ($this->filterUser) {
            $query->where('user_id', $this->filterUser);
        }

        $balances = $query->paginate(20);
        $users = User::orderBy('name')->get(['id', 'name']);
        $leaveTypes = LeaveType::where('status_id', 1)->get(['id', 'name', 'default_days']);

        return view('livewire.admin.leave-page.leave-balances', compact('balances', 'users', 'leaveTypes'));
    }

    public function toggleAllocForm()
    {
        $this->showAllocForm = !$this->showAllocForm;
        if (!$this->showAllocForm) {
            $this->resetAllocFields();
        }
    }

    public function resetAllocFields()
    {
        $this->alloc_user_id = '';
        $this->alloc_leave_type_id = '';
        $this->alloc_total_days = 0;
        $this->alloc_carried_over = 0;
    }

    public function updatedAllocLeaveTypeId($value)
    {
        if ($value) {
            $type = LeaveType::find($value);
            if ($type) {
                $this->alloc_total_days = $type->default_days;
            }
        }
    }

    public function allocateBalance()
    {
        $this->validate([
            'alloc_user_id' => 'required|exists:users,id',
            'alloc_leave_type_id' => 'required|exists:leave_types,id',
            'alloc_total_days' => 'required|numeric|min:0',
            'alloc_carried_over' => 'nullable|numeric|min:0',
        ]);

        try {
            LeaveBalance::updateOrCreate(
                [
                    'user_id' => $this->alloc_user_id,
                    'leave_type_id' => $this->alloc_leave_type_id,
                    'year' => $this->filterYear,
                ],
                [
                    'total_days' => $this->alloc_total_days,
                    'carried_over' => $this->alloc_carried_over ?? 0,
                ]
            );

            session()->flash('success', 'Leave balance allocated successfully!');
            $this->resetAllocFields();
            $this->showAllocForm = false;
        } catch (\Exception $e) {
            session()->flash('error', 'Error allocating leave balance.');
        }
    }

    /**
     * Bulk allocate default balances for all active users for the current year.
     */
    public function bulkAllocate()
    {
        $users = User::where('status_id', 1)->get();
        $leaveTypes = LeaveType::where('status_id', 1)->get();
        $count = 0;

        foreach ($users as $user) {
            foreach ($leaveTypes as $type) {
                LeaveBalance::firstOrCreate(
                    [
                        'user_id' => $user->id,
                        'leave_type_id' => $type->id,
                        'year' => $this->filterYear,
                    ],
                    [
                        'total_days' => $type->default_days,
                        'used_days' => 0,
                        'carried_over' => 0,
                    ]
                );
                $count++;
            }
        }

        session()->flash('success', "Bulk allocated {$count} balance records for {$this->filterYear}.");
    }

    public function destroyBalance($id)
    {
        try {
            LeaveBalance::find($id)->delete();
            session()->flash('success', 'Balance record deleted.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting balance.');
        }
    }

    public function updatingFilterYear() { $this->resetPage(); }
    public function updatingFilterUser() { $this->resetPage(); }
}
