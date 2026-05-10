<?php

namespace App\Http\Livewire\Admin;

use App\Models\Bilta\Department;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ShowDepartments extends Component
{
    use WithPagination;

    public $name, $code, $description, $head_id, $status_id = 1, $department_id;
    public $showForm = false;
    public $isEdit = false;

    protected $listeners = ['deleteDepartment' => 'destroy'];

    protected function rules()
    {
        return [
            'name'        => 'required|string|max:100',
            'code'        => 'nullable|string|max:20',
            'description' => 'nullable|string|max:500',
            'head_id'     => 'nullable|exists:users,id',
            'status_id'   => 'required|integer',
        ];
    }

    public function render()
    {
        $departments = Department::with('head', 'status')
            ->withCount('members')
            ->orderBy('name')
            ->paginate(15);

        $users = User::orderBy('name')->select('id', 'name', 'position')->get();

        return view('livewire.admin.departments', compact('departments', 'users'));
    }

    public function toggleForm()
    {
        $this->showForm = !$this->showForm;
        if (!$this->showForm) {
            $this->resetFields();
        }
    }

    public function store()
    {
        $this->validate();

        Department::create([
            'name'        => $this->name,
            'slug'        => Str::slug($this->name),
            'code'        => $this->code,
            'description' => $this->description,
            'head_id'     => $this->head_id ?: null,
            'status_id'   => $this->status_id,
        ]);

        session()->flash('success', 'Department created successfully.');
        $this->resetFields();
        $this->showForm = false;
    }

    public function edit($id)
    {
        $dept = Department::findOrFail($id);
        $this->department_id = $dept->id;
        $this->name          = $dept->name;
        $this->code          = $dept->code;
        $this->description   = $dept->description;
        $this->head_id       = $dept->head_id;
        $this->status_id     = $dept->status_id;
        $this->isEdit        = true;
        $this->showForm      = true;
    }

    public function update()
    {
        $this->validate();

        $dept = Department::findOrFail($this->department_id);
        $dept->update([
            'name'        => $this->name,
            'slug'        => Str::slug($this->name),
            'code'        => $this->code,
            'description' => $this->description,
            'head_id'     => $this->head_id ?: null,
            'status_id'   => $this->status_id,
        ]);

        session()->flash('success', 'Department updated successfully.');
        $this->resetFields();
        $this->showForm = false;
    }

    public function destroy($id)
    {
        $dept = Department::findOrFail($id);
        if ($dept->members()->count() > 0) {
            session()->flash('error', 'Cannot delete department with assigned members. Reassign members first.');
            return;
        }
        $dept->delete();
        session()->flash('success', 'Department deleted successfully.');
    }

    private function resetFields()
    {
        $this->name = '';
        $this->code = '';
        $this->description = '';
        $this->head_id = '';
        $this->status_id = 1;
        $this->department_id = null;
        $this->isEdit = false;
    }
}
