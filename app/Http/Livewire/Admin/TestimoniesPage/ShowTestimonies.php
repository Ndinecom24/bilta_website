<?php

namespace App\Http\Livewire\Admin\TestimoniesPage;

use App\Models\Bilta\Testimonies;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTestimonies extends Component
{
    use WithPagination;

    public $testimonies_id, $answer, $question;

    public $updateTestimonies = false;
    protected $listeners = [
        'deleteTestimonies' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'question' => 'required',
        'answer' => 'required',
    ];

    public function render()
    {
        $testimonies = Testimonies::select('id', 'question', 'answer')->paginate(20);
        return view('livewire.admin.testimonies-page.index')->with(compact('testimonies'));
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
            // Create Testimonies
            Testimonies::updateOrCreate([
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
        $this->question = $testimonies->question;
        $this->answer = $testimonies->answer;
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
                'question' => $this->question,
                'answer' => $this->answer,
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

