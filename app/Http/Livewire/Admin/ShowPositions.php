<?php

namespace App\Http\Livewire\Admin;

use App\Models\Bilta\Department;
use App\Models\Bilta\Position;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPositions extends Component
{
    use WithPagination;

    public $name;
    public $code;
    public $description;
    public $department_id;
    public $status_id = 1;
    public $position_id;

    public $search = '';
    public $filterDepartment = '';
    public $showForm = false;
    public $isEdit = false;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['deletePosition' => 'destroy'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterDepartment()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'name'          => 'required|string|max:100',
            'code'          => 'nullable|string|max:20',
            'department_id' => 'nullable|exists:departments,id',
            'description'   => 'nullable|string|max:5000',
            'status_id'     => 'required|integer',
        ];
    }

    public function render()
    {
        $query = Position::with(['department', 'status'])
            ->withCount('users');

        if (!empty($this->search)) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('code', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%");
            });
        }

        if (!empty($this->filterDepartment)) {
            $query->where('department_id', $this->filterDepartment);
        }

        $positions = $query->orderBy('name')->paginate(15);
        $departments = Department::orderBy('name')->get();

        return view('livewire.admin.positions', compact('positions', 'departments'));
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
        if (!auth()->user()->can('create-positions') && !auth()->user()->can('manage-positions')) {
            session()->flash('error', 'You do not have permission to create positions.');
            return;
        }

        $this->validate();

        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Position::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        Position::create([
            'name'          => $this->name,
            'slug'          => $slug,
            'code'          => $this->code ? strtoupper(trim($this->code)) : null,
            'department_id' => $this->department_id ?: null,
            'description'   => $this->description,
            'status_id'     => $this->status_id,
        ]);

        session()->flash('success', 'Position created successfully.');
        $this->resetFields();
        $this->showForm = false;
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit-positions') && !auth()->user()->can('manage-positions')) {
            session()->flash('error', 'You do not have permission to edit positions.');
            return;
        }

        $pos = Position::findOrFail($id);
        $this->position_id   = $pos->id;
        $this->name          = $pos->name;
        $this->code          = $pos->code;
        $this->department_id = $pos->department_id;
        $this->description   = $pos->description;
        $this->status_id     = $pos->status_id;
        $this->isEdit        = true;
        $this->showForm      = true;
    }

    public function update()
    {
        if (!auth()->user()->can('edit-positions') && !auth()->user()->can('manage-positions')) {
            session()->flash('error', 'You do not have permission to edit positions.');
            return;
        }

        $this->validate();

        $pos = Position::findOrFail($this->position_id);

        $slug = Str::slug($this->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Position::where('slug', $slug)->where('id', '!=', $pos->id)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $pos->update([
            'name'          => $this->name,
            'slug'          => $slug,
            'code'          => $this->code ? strtoupper(trim($this->code)) : null,
            'department_id' => $this->department_id ?: null,
            'description'   => $this->description,
            'status_id'     => $this->status_id,
        ]);

        session()->flash('success', 'Position updated successfully.');
        $this->resetFields();
        $this->showForm = false;
    }

    public function destroy($id)
    {
        if (!auth()->user()->can('delete-positions') && !auth()->user()->can('manage-positions')) {
            session()->flash('error', 'You do not have permission to delete positions.');
            return;
        }

        $pos = Position::findOrFail($id);
        if ($pos->users()->exists()) {
            session()->flash('error', 'Cannot delete position with assigned employees. Reassign employees first.');
            return;
        }

        $pos->delete();
        session()->flash('success', 'Position deleted successfully.');
    }

    private function resetFields()
    {
        $this->name = '';
        $this->code = '';
        $this->department_id = '';
        $this->description = '';
        $this->status_id = 1;
        $this->position_id = null;
        $this->isEdit = false;
    }
}
