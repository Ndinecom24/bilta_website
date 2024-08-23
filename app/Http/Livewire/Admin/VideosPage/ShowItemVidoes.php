<?php

namespace App\Http\Livewire\Admin\VideosPage;

use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\Videos;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowItemVidoes extends Component
{


    use WithPagination;

    public $video_item_id, $item_category_id, $name, $description, $status_id, $type;
    public $video_link, $video_item, $gallery_image_update;

    public $updateVideos = false;
    protected $listeners = [
        'deleteVideoItem' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'description' => 'required',
        'name' => 'required',
        'status_id' => 'required',
        'type' => 'required',
        'item_category_id' => 'required',
        'video_link' => 'required', // ,

    ];

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $item_categories = ItemCategory::where('type', 'Images')->get();
        $video_items = Videos::select('item_category_id', 'id', 'description', 'name', 'status_id', 'type', 'video_link')->paginate(20);
        return view('livewire.admin.videos-page.index')
            ->with(compact('video_items', 'statuses', 'item_categories'));
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
        $this->video_link = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create Videos
            $video_item = Videos::updateOrCreate(
                [
                    'description' => $this->description,
                    'name' => $this->name,
                    'type' => $this->type,
                    'video_link' => $this->video_link,
                ],
                [
                    'description' => $this->description,
                    'name' => $this->name,
                    'status_id' => $this->status_id,
                    'type' => $this->type,
                    'video_link' => $this->video_link,
                    'item_category_id' => $this->item_category_id,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success', 'Video Item Created Successfully!!');
            // Reset Form Fields After Creating Videos
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating video item!!' . $e->getMessage());
            // Reset Form Fields After Creating Videos
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $video_item = Videos::findOrFail($id);
        $this->description = $video_item->description;
        $this->name = $video_item->name;
        $this->video_link = $video_item->video_link;
        $this->status_id = $video_item->status_id;
        $this->type = $video_item->type;
        $this->item_category_id = $video_item->item_category_id;
        $this->video_item_id = $video_item->id;

        $this->updateVideos = true;
        $this->video_item = $video_item;
    }

    public function cancel()
    {
        $this->updateVideos = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update item_category
            $team = Videos::find($this->item_category_id)->fill([
                'description' => $this->description,
                'name' => $this->name,
                'status_id' => $this->status_id,
                'video_link' => $this->video_link,
                'item_category_id' => $this->item_category_id,
                'type' => $this->type,
                'created_by' => auth()->user()->id
            ])->save();


            session()->flash('success', 'Videos Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating video item!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            Videos::find($id)->delete();
            session()->flash('success', "Videos Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting item category!!");
        }
    }

}
