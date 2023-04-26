<?php

namespace App\Http\Livewire\Admin\FaqsPage;

use App\Models\Bilta\FAQs;
use Livewire\Component;
use Livewire\WithPagination;

class ShowFaqs extends Component
{
    use WithPagination;

    public $faq_id, $answer, $question;

    public $updateFAQs = false;
    protected $listeners = [
        'deleteFAQ' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'question' => 'required',
        'answer' => 'required',
    ];

    public function render()
    {
        $faqs = FAQs::select('id', 'question', 'answer')->paginate(20);
        return view('livewire.admin.faqs-page.index')->with(compact('faqs'));
    }

    public function resetFields()
    {
        $this->question = '';
        $this->answer = '';
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create FAQs
            FAQs::updateOrCreate([
                'question' => $this->question,
                'answer' => $this->answer,
            ],
                [
                    'question' => $this->question,
                    'answer' => $this->answer,
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

