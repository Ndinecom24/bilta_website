<?php

namespace App\Http\Livewire\Admin\NewsPage;

use App\Models\Bilta\News;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ShowNewsItem extends Component
{


    use WithPagination;

    public $faq_id, $answer, $question, $status_id ;

    public $updateNews = false;
    protected $listeners = [
        'deleteNews' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'question' => 'required',
        'answer' => 'required',
        'status_id' => 'required',
    ];

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $faqs = News::select('id', 'question', 'answer', 'status_id')->paginate(20);
        return view('livewire.admin.news-page.index')->with(compact('faqs', 'statuses'));
    }

    public function resetFields()
    {
        $this->question = '';
        $this->answer = '';
        $this->status_id = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create News
            News::updateOrCreate([
                'question' => $this->question,
                'answer' => $this->answer,
            ],
                [
                    'question' => $this->question,
                    'answer' => $this->answer,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success', 'News Created Successfully!!');
            // Reset Form Fields After Creating News
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating News
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $faq = News::findOrFail($id);
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->status_id = $faq->status_id;
        $this->faq_id = $faq->id;
        $this->updateNews = true;
    }

    public function cancel()
    {
        $this->updateNews = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            // Update faq
            News::find($this->faq_id)->fill([
                'question' => $this->question,
                'answer' => $this->answer,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success', 'News Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating faq!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            News::find($id)->delete();
            session()->flash('success', "News Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting faq!!");
        }
    }

}
