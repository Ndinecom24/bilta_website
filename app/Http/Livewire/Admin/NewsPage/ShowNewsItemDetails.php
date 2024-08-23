<?php

namespace App\Http\Livewire\Admin\NewsPage;

use App\Models\Bilta\FAQs;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ShowNewsItemDetails extends Component
{
    use WithPagination;

    public $news_category_id, $name, $description, $status_id;

    public $updateFAQs = false;
    protected $listeners = [
        'deleteFAQ' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'description' => 'required',
        'name' => 'required',
        'status_id' => 'required',
    ];

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $news_categorys = FAQs::select('id', 'description', 'name', 'status_id')->paginate(20);
        return view('livewire.admin.news_categorys-page.index')->with(compact('news_categorys', 'statuses'));
    }

    public function resetFields()
    {
        $this->description = '';
        $this->name = '';
        $this->status_id = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create FAQs
            FAQs::updateOrCreate(
                [
                    'description' => $this->description,
                    'name' => $this->name,
                ],
                [
                    'description' => $this->description,
                    'name' => $this->name,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success', 'FAQs Created Successfully!!');
            // Reset Form Fields After Creating FAQs
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating FAQs
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $news_category = FAQs::findOrFail($id);
        $this->description = $news_category->description;
        $this->name = $news_category->name;
        $this->status_id = $news_category->status_id;
        $this->news_category_id = $news_category->id;
        $this->updateFAQs = true;
    }

    public function cancel()
    {
        $this->updateFAQs = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update news_category
            News::find($this->news_category_id)->fill([
                'description' => $this->description,
                'name' => $this->name,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success', 'FAQs Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating news category!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            FAQs::find($id)->delete();
            session()->flash('success', "FAQs Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting news category!!");
        }
    }

}

