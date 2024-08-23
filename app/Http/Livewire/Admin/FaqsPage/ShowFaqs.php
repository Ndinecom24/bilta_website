<?php

namespace App\Http\Livewire\Admin\FaqsPage;

use App\Models\Bilta\FAQs;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ShowFaqs extends Component
{
    use WithPagination;

    public $faq_id, $answer, $question, $status_id;

    public $updateFAQs = false;
    protected $listeners = [
        'deleteFAQ' => 'destroy'
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
        $faqs = FAQs::select('id', 'question', 'answer', 'status_id')->paginate(20);
        return view('livewire.admin.faqs-page.index')->with(compact('faqs', 'statuses'));
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
            // Create FAQs
            FAQs::updateOrCreate(
                [
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
        $faq = FAQs::findOrFail($id);
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->status_id = $faq->status_id;
        $this->faq_id = $faq->id;
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
            // Update faq
            FAQs::find($this->faq_id)->fill([
                'question' => $this->question,
                'answer' => $this->answer,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success', 'FAQs Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating faq!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            FAQs::find($id)->delete();
            session()->flash('success', "FAQs Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting faq!!");
        }
    }

}

