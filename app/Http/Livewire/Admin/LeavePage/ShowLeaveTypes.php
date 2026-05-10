<?php

namespace App\Http\Livewire\Admin\LeavePage;

use App\Models\Bilta\LeaveType;
use Livewire\Component;
use Livewire\WithPagination;

class ShowLeaveTypes extends Component
{
    use WithPagination;

    public $leave_type_id, $name, $slug, $description, $default_days, $requires_document, $is_paid, $carry_over, $max_carry_over_days, $status_id;
    public $updateLeaveType = false;

    protected $listeners = ['deleteLeaveType' => 'destroy'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'default_days' => 'required|integer|min:0',
        'status_id' => 'required',
    ];

    public function mount()
    {
        $this->default_days = 0;
        $this->requires_document = false;
        $this->is_paid = true;
        $this->carry_over = false;
        $this->max_carry_over_days = 0;
    }

    public function render()
    {
        $leaveTypes = LeaveType::paginate(20);
        return view('livewire.admin.leave-page.leave-types', compact('leaveTypes'));
    }

    public function resetFields()
    {
        $this->name = '';
        $this->slug = '';
        $this->description = '';
        $this->default_days = 0;
        $this->requires_document = false;
        $this->is_paid = true;
        $this->carry_over = false;
        $this->max_carry_over_days = 0;
        $this->status_id = '';
    }

    public function updatedName($value)
    {
        $this->slug = \Illuminate\Support\Str::slug($value);
    }

    public function store()
    {
        $this->validate();
        try {
            LeaveType::updateOrCreate(
                ['slug' => $this->slug],
                [
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'description' => $this->description,
                    'default_days' => $this->default_days,
                    'requires_document' => $this->requires_document,
                    'is_paid' => $this->is_paid,
                    'carry_over' => $this->carry_over,
                    'max_carry_over_days' => $this->max_carry_over_days,
                    'status_id' => $this->status_id,
                ]
            );
            session()->flash('success', 'Leave Type saved successfully!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving leave type.');
        }
    }

    public function edit($id)
    {
        $type = LeaveType::findOrFail($id);
        $this->leave_type_id = $type->id;
        $this->name = $type->name;
        $this->slug = $type->slug;
        $this->description = $type->description;
        $this->default_days = $type->default_days;
        $this->requires_document = $type->requires_document;
        $this->is_paid = $type->is_paid;
        $this->carry_over = $type->carry_over;
        $this->max_carry_over_days = $type->max_carry_over_days;
        $this->status_id = $type->status_id;
        $this->updateLeaveType = true;
    }

    public function cancel()
    {
        $this->updateLeaveType = false;
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();
        try {
            LeaveType::find($this->leave_type_id)->fill([
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'default_days' => $this->default_days,
                'requires_document' => $this->requires_document,
                'is_paid' => $this->is_paid,
                'carry_over' => $this->carry_over,
                'max_carry_over_days' => $this->max_carry_over_days,
                'status_id' => $this->status_id,
            ])->save();
            session()->flash('success', 'Leave Type updated successfully!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating leave type.');
        }
    }

    public function destroy($id)
    {
        try {
            LeaveType::find($id)->delete();
            session()->flash('success', 'Leave Type deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting leave type.');
        }
    }
}
