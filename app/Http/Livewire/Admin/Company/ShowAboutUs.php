<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\AboutUs;
use Livewire\Component;
use Livewire\WithPagination;

class ShowAboutUs extends Component
{
    use WithPagination ;
    public  $about_us_id, $vision, $mission , $objective , $description, $what_is, $who_we_are;

    public $updateAboutUs = false;
    protected $listeners = [
        'deleteAboutUs'=>'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'mission'=>'required',
        'vision'=>'required',
        'objective' => 'required',
        'description' => 'required',
        'what_is' => 'required',
        'who_we_are' => 'required',
    ];

    public function render()
    {
        $about_uses = AboutUs::select('id','mission','vision', 'objective', 'description', 'what_is', 'who_we_are')->paginate(20);
        return view('livewire.admin.company.about-us.index')->with(compact('about_uses'));
    }

    public function resetFields(){
        $this->mission = '';
        $this->vision = '';
        $this->objective = '';
        $this->description = '';
        $this->what_is = '';
        $this->who_we_are = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create AboutUs
            AboutUs::updateOrCreate([
                'mission'=>$this->mission,
                'vision'=>$this->vision,
                'objective'=>$this->objective,
            ],
                [
                    'mission'=>$this->mission,
                    'vision'=>$this->vision,
                    'objective'=>$this->objective,
                    'description'=>$this->description,
                    'what_is'=>$this->what_is,
                    'who_we_are'=>$this->who_we_are,
                ]

            );

            // Set Flash Message
            session()->flash('success','About Us Created Successfully!!');
            // Reset Form Fields After Creating AboutUs
            $this->resetFields();

        }catch(\Exception $e){

            // Set Flash Message
            session()->flash('error','Something goes wrong while creating about us!!'. $e->getMessage());
            // Reset Form Fields After Creating AboutUs
            $this->resetFields();
        }
    }
    public function edit($id){
        $about_us = AboutUs::findOrFail($id);
        $this->mission = $about_us->mission;
        $this->vision = $about_us->vision;
        $this->objective = $about_us->objective;
        $this->description = $about_us->description;
        $this->what_is = $about_us->what_is;
        $this->who_we_are = $about_us->who_we_are;
        $this->about_us_id = $about_us->id;
        $this->updateAboutUs = true;
    }
    public function cancel()
    {
        $this->updateAboutUs = false;
        $this->resetFields();
    }
    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update about_us
            AboutUs::find($this->about_us_id)->fill([
                'mission'=>$this->mission,
                'vision'=>$this->vision,
                'objective'=>$this->objective,
                'description'=>$this->description,
                'what_is'=>$this->what_is,
                'who_we_are'=>$this->who_we_are,
            ])->save();
            session()->flash('success','About Us Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating about_us!!');
            $this->cancel();
        }
    }
    public function destroy($id){
        try{
            AboutUs::find($id)->delete();
            session()->flash('success',"About Us Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting about_us!!");
        }
    }

}
