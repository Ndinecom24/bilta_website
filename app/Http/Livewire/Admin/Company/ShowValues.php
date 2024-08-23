<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\OurValues;
use Livewire\Component;
use Livewire\WithPagination;

class ShowValues extends Component
{
    use WithPagination;
    public $values_id, $description, $title;

    public $updateOurValues = false;
    protected $listeners = [
        'deleteOurValues' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'title' => 'required',
        'description' => 'required',
    ];

    public function render()
    {
        $our_valueses = OurValues::select('id', 'title', 'description')->paginate(20);
        return view('livewire.admin.company.values.index')->with(compact('our_valueses'));
    }

    public function resetFields()
    {
        $this->title = '';
        $this->description = '';
    }
    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create OurValues
            OurValues::updateOrCreate(
                [
                    'title' => $this->title,
                    'description' => $this->description,
                ],
                [
                    'title' => $this->title,
                    'description' => $this->description,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success', 'Values Created Successfully!!');
            // Reset Form Fields After Creating OurValues
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating OurValues
            $this->resetFields();
        }
    }
    public function edit($id)
    {
        $values = OurValues::findOrFail($id);
        $this->title = $values->title;
        $this->description = $values->description;
        $this->values_id = $values->id;
        $this->updateOurValues = true;
    }
    public function cancel()
    {
        $this->updateOurValues = false;
        $this->resetFields();
    }
    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update values
            OurValues::find($this->values_id)->fill([
                'title' => $this->title,
                'description' => $this->description,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success', 'Values Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating values!!');
            $this->cancel();
        }
    }
    public function destroy($id)
    {
        try {
            OurValues::find($id)->delete();
            session()->flash('success', "Values Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting values!!");
        }
    }

}
