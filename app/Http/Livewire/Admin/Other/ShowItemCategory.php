<?php

namespace App\Http\Livewire\Admin\Other;

use App\Models\Bilta\ItemCategory;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ShowItemCategory extends Component
{
    use WithPagination;

    public $item_category_id, $name, $description, $status_id, $type;

    public $updateItemCategory = false;
    protected $listeners = [
        'deleteItemCategory' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'description' => 'required',
        'name' => 'required',
        'status_id' => 'required',
        'type' => 'required',
    ];

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $item_categories = ItemCategory::select('id', 'description', 'name', 'status_id', 'type')->paginate(20);
        return view('livewire.admin.item-category-page.index')->with(compact('item_categories', 'statuses'));
    }

    public function resetFields()
    {
        $this->description = '';
        $this->name = '';
        $this->status_id = '';
        $this->type = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create ItemCategory
            ItemCategory::updateOrCreate(
                [
                    'description' => $this->description,
                    'name' => $this->name,
                    'type' => $this->type,
                ],
                [
                    'description' => $this->description,
                    'name' => $this->name,
                    'status_id' => $this->status_id,
                    'type' => $this->type,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success', 'Item Category Created Successfully!!');
            // Reset Form Fields After Creating ItemCategory
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating item category!!' . $e->getMessage());
            // Reset Form Fields After Creating ItemCategory
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $item_category = ItemCategory::findOrFail($id);
        $this->description = $item_category->description;
        $this->name = $item_category->name;
        $this->status_id = $item_category->status_id;
        $this->type = $item_category->type;
        $this->item_category_id = $item_category->id;
        $this->updateItemCategory = true;
    }

    public function cancel()
    {
        $this->updateItemCategory = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update item_category
            ItemCategory::find($this->item_category_id)->fill([
                'description' => $this->description,
                'name' => $this->name,
                'status_id' => $this->status_id,
                'type' => $this->type,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success', 'ItemCategory Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating item category!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            ItemCategory::find($id)->delete();
            session()->flash('success', "ItemCategory Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting item category!!");
        }
    }

}

