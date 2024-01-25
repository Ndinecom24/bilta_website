<?php

namespace App\Http\Livewire\Admin\TestimoniesPage;

use App\Models\Bilta\Testimonies;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTestimonies extends Component
{
    use WithPagination;

    public $testimonies_id,  $name, $title, $description, $status_id;
    public $statuses = [] ;

    public $updateTestimonies = false;
    protected $listeners = [
        'deleteTestimonies' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name' => 'required' ,
        'title' => 'required' ,
        'description' => 'required' ,
        'status_id' => 'required' ,
    ];

    public function render()
    {
        $testimonies = Testimonies::select('id','name', 'title', 'description' , 'status_id')->paginate(20);
        $this->statuses = Status::get();
        return view('livewire.admin.testimonies-page.index')->with(compact('testimonies'));
    }

    public function resetFields()
    {
        $this->name = '';
        $this->title = '';
        $this->description = '';
        $this->status_id = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create Testimonies
            Testimonies::updateOrCreate([
                'name' => $this->name,
                'title' => $this->title,
                'description' => $this->description,
                'status_id' => $this->status_id,
            ],
                [
                    'name' => $this->name,
                'title' => $this->title,
                'description' => $this->description,
                'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success', 'Testimonies Created Successfully!!');
            // Reset Form Fields After Creating Testimonies
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating Testimonies
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $testimonies = Testimonies::findOrFail($id);
        $this->name = $testimonies->name;
        $this->title = $testimonies->title;
        $this->description = $testimonies->description;
        $this->status_id = $testimonies->status_id;
        $this->testimonies_id = $testimonies->id;
        $this->updateTestimonies = true;
    }

    public function cancel()
    {
        $this->updateTestimonies = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update testimonies
            Testimonies::find($this->testimonies_id)->fill([
                'name' => $this->name,
                'title' => $this->title,
                'description' => $this->description,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success', 'Testimonies Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating testimonies!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            Testimonies::find($id)->delete();
            session()->flash('success', "Testimonies Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting testimonies!!");
        }
    }

}

