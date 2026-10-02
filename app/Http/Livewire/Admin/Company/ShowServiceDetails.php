<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\OurServices;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShowServiceDetails extends Component
{
    use WithFileUploads;

    public $service;
    public $services_id, $title, $description;
    public $service_images = [];
    public $service_brochures = [];
    public $isEditing = false;

    protected $rules = [
        'title' => 'required',
        'description' => 'required',
        'service_images.*' => 'nullable|image|max:3072',
        'service_brochures.*' => 'nullable|file|max:10240',
    ];

    protected $listeners = [
        'deleteService' => 'destroy',
    ];

    public function mount($service)
    {
        $this->service = OurServices::findOrFail($service);
        $this->services_id = $this->service->id;
    }

    public function render()
    {
        return view('livewire.admin.company.services.show', [
            'service' => $this->service,
        ]);
    }

    public function edit()
    {
        $this->title = $this->service->title;
        $this->description = $this->service->description;
        $this->service_images = [];
        $this->service_brochures = [];
        $this->isEditing = true;
    }

    public function cancel()
    {
        $this->isEditing = false;
        $this->service_images = [];
        $this->service_brochures = [];
        $this->resetValidation();
    }

    public function update()
    {
        $this->validate();

        try {
            $this->service->update([
                'title' => $this->title,
                'description' => $this->description,
                'created_by' => auth()->user()->id,
            ]);

            // Handle image uploads
            if (!empty($this->service_images)) {
                foreach ($this->service_images as $image) {
                    $this->service->addMedia($image)
                        ->toMediaCollection('service_images');
                }
            }

            // Handle brochure/file uploads
            if (!empty($this->service_brochures)) {
                foreach ($this->service_brochures as $file) {
                    $this->service->addMedia($file)
                        ->toMediaCollection('service_brochures');
                }
            }

            $this->service = $this->service->fresh();
            $this->isEditing = false;
            $this->service_images = [];
            $this->service_brochures = [];

            session()->flash('success', 'Service updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while updating the service: ' . $e->getMessage());
        }
    }

    public function removeImage($mediaId)
    {
        Media::find($mediaId)->delete();
        $this->service = $this->service->fresh();
        session()->flash('success', 'Image removed successfully!');
    }

    public function removeBrochure($mediaId)
    {
        Media::find($mediaId)->delete();
        $this->service = $this->service->fresh();
        session()->flash('success', 'Brochure/file removed successfully!');
    }

    public function destroy()
    {
        try {
            $this->service->delete();
            session()->flash('success', 'Service deleted successfully!');

            return redirect()->route('admin.company.services');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while deleting the service.');
        }
    }
}
