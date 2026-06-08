<?php

namespace App\Http\Livewire\Admin\TestimoniesPage;

use App\Models\Bilta\Testimonies;
use App\Models\System\Status;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowTestimonies extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $testimonies_id, $name, $email, $phone, $image, $existing_image, $title, $description, $status_id;
    public $statuses = [];

    public $updateTestimonies = false;
    protected $listeners = [
        'deleteTestimonies' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name' => 'required',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:30',
        'image' => 'nullable|image|max:5120',
        'title' => 'required',
        'description' => 'required',
        'status_id' => 'required',
    ];

    public function render()
    {
        $testimonies = Testimonies::with('status:id,name')->select('id', 'name', 'email', 'phone', 'image', 'title', 'description', 'status_id')->paginate(20);
        $this->statuses = Status::get();
        return view('livewire.admin.testimonies-page.index')->with(compact('testimonies'));
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->image = null;
        $this->existing_image = null;
        $this->title = '';
        $this->description = '';
        $this->status_id = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            $storedImage = null;
            if ($this->image) {
                $storedImage = $this->image->store('testimonies', 'public');
            }

            // Create Testimonies
            Testimonies::updateOrCreate(
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'image' => $storedImage,
                    'title' => $this->title,
                    'description' => $this->description,
                    'status_id' => $this->status_id,
                ],
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'image' => $storedImage,
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
        $this->email = $testimonies->email;
        $this->phone = $testimonies->phone;
        $this->existing_image = $testimonies->image;
        $this->image = null;
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
            $testimony = Testimonies::find($this->testimonies_id);
            $storedImage = $testimony->image;
            if ($this->image) {
                $storedImage = $this->image->store('testimonies', 'public');
                if (!empty($testimony->image) && Storage::disk('public')->exists($testimony->image)) {
                    Storage::disk('public')->delete($testimony->image);
                }
            }

            // Update testimonies
            $testimony->fill([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'image' => $storedImage,
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
            $testimony = Testimonies::find($id);
            if (!empty($testimony->image) && Storage::disk('public')->exists($testimony->image)) {
                Storage::disk('public')->delete($testimony->image);
            }
            $testimony->delete();
            session()->flash('success', "Testimonies Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting testimonies!!");
        }
    }

}

