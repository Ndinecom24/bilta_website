<?php

namespace App\Http\Livewire\Admin\GalleryPage;

use App\Models\Bilta\Gallery;
use App\Models\Bilta\ItemCategory;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowItemGallery extends Component
{


    use WithPagination;
    use WithFileUploads;

    public $gallery_item_id, $item_category_id, $name, $description, $status_id, $type ;
    public $gallery_image  , $gallery_item  , $gallery_image_update ;

    public $updateGallery = false;
    protected $listeners = [
        'deleteGalleryItem' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'description' => 'required',
        'name' => 'required',
        'status_id' => 'required',
        'type' => 'required',
        'item_category_id' => 'required',
        'gallery_image' =>  'required|mimes:png,jpg,jpeg|max:3072', // 3MB Max,

    ];

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $item_categories = ItemCategory::where('type','Images')->get();
        $gallery_items = Gallery::select('item_category_id', 'id', 'description', 'name', 'status_id', 'type')->paginate(20);
          return view('livewire.admin.gallery-page.index')
            ->with(compact('gallery_items', 'statuses', 'item_categories'));
    }

    public function resetFields()
    {
        $this->gallery_image = '';
        $this->gallery_image_update = '';
        $this->description = '';
        $this->name = '';
        $this->item_category_id = '';
        $this->status_id = '';
        $this->type = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create Gallery
          $gallery_item =  Gallery::updateOrCreate([
                'description' => $this->description,
                'name' => $this->name,
                'type' => $this->type,
            ],
                [
                    'description' => $this->description,
                    'name' => $this->name,
                    'status_id' => $this->status_id,
                    'type' => $this->type,
                    'item_category_id' => $this->item_category_id,
                    'created_by' => auth()->user()->id
                ]

            );

            $gallery_item->addMedia($this->gallery_image)
                ->toMediaCollection('gallery_images');

            // Set Flash Message
            session()->flash('success', 'Item Category Created Successfully!!');
            // Reset Form Fields After Creating Gallery
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating item category!!' . $e->getMessage());
            // Reset Form Fields After Creating Gallery
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $gallery_item= Gallery::findOrFail($id);
        $this->description = $gallery_item->description;
        $this->name = $gallery_item->name;
        $this->status_id = $gallery_item->status_id;
        $this->type = $gallery_item->type;
        $this->item_category_id = $gallery_item->item_category_id;
        $this->gallery_item_id = $gallery_item->id;

        $this->updateGallery = true;
        $this->gallery_item = $gallery_item ;
    }

    public function cancel()
    {
        $this->updateGallery = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update item_category
            $team =  Gallery::find($this->item_category_id)->fill([
                'description' => $this->description,
                'name' => $this->name,
                'status_id' => $this->status_id,
                'item_category_id' => $this->item_category_id,
                'type' => $this->type,
                'created_by' => auth()->user()->id
            ])->save();


            if (isset($this->gallery_image)) {
                $team->clearMediaCollection('gallery_images');
                $team->addMedia($this->gallery_image)
                    ->toMediaCollection('gallery_images');
            }


            session()->flash('success', 'Gallery Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating item category!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            Gallery::find($id)->delete();
            session()->flash('success', "Gallery Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting item category!!");
        }
    }

}
