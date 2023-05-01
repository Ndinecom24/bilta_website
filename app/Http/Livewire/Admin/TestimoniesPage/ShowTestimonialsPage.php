<?php

namespace App\Http\Livewire\Admin\TestimoniesPage;

use App\Models\Bilta\Testimonial;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTestimonialsPage extends Component
{
    use WithPagination;

    public $testimonies_id, $title, $testimonial, $name, $status_id;

    public $updateShortTestimony = false;
    protected $listeners = [
        'deleteShortTestimony' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'testimonial' => 'required',
        'title' => 'required',
        'name' => 'required',
        'status_id' => 'required',
    ];

    public function render()
    {
        $testimonies = Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')->paginate(20);
        $statuses = Status::get();
        return view('livewire.admin.short-testimonies-page.index')->with(compact('testimonies', 'statuses'));
    }

    public function resetFields()
    {
        $this->testimonial = '';
        $this->title = '';
        $this->name = '';
        $this->status_id = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create Testimonial
            Testimonial::updateOrCreate([
                'testimonial' => $this->testimonial,
                'title' => $this->title,
                'name' => $this->name,
            ],
                [
                    'testimonial' => $this->testimonial,
                    'title' => $this->title,
                    'name' => $this->name,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success', 'Testimonial Created Successfully!!');
            // Reset Form Fields After Creating Testimonial
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating Testimonial
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $testimonies = Testimonial::findOrFail($id);
        $this->name = $testimonies->name;
        $this->status_id = $testimonies->status_id;
        $this->testimonial = $testimonies->testimonial;
        $this->title = $testimonies->title;
        $this->testimonies_id = $testimonies->id;
        $this->updateShortTestimony = true;
    }

    public function cancel()
    {
        $this->updateShortTestimony = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update testimonies
            Testimonial::find($this->testimonies_id)->fill([
                'testimonial' => $this->testimonial,
                'title' => $this->title,
                'name' => $this->name,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success', 'Testimonial Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating testimonies!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            Testimonial::find($id)->delete();
            session()->flash('success', "Testimonial Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting testimonies!!");
        }
    }

}

