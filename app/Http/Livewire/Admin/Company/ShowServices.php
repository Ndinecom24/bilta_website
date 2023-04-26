<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\OurServices;
use Livewire\Component;
use Livewire\WithPagination;

class ShowServices extends Component
{
    use WithPagination ;
    public  $services_id, $description, $title ;

    public $updateOurServices = false;
    protected $listeners = [
        'deleteOurServices'=>'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'title'=>'required',
        'description'=>'required',
    ];

    public function render()
    {
        $our_serviceses = OurServices::select('id','title','description' )->paginate(20);
        return view('livewire.admin.company.services.index')->with(compact('our_serviceses'));
    }

    public function resetFields(){
        $this->title = '';
        $this->description = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create OurServices
            OurServices::updateOrCreate([
                'title'=>$this->title,
                'description'=>$this->description,
            ],
                [
                    'title'=>$this->title,
                    'description'=>$this->description,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success','Services Created Successfully!!');
            // Reset Form Fields After Creating OurServices
            $this->resetFields();

        }catch(\Exception $e){

            // Set Flash Message
            session()->flash('error','Something goes wrong while creating about us!!'. $e->getMessage());
            // Reset Form Fields After Creating OurServices
            $this->resetFields();
        }
    }
    public function edit($id){
        $services = OurServices::findOrFail($id);
        $this->title = $services->title;
        $this->description = $services->description;
        $this->services_id = $services->id;
        $this->updateOurServices = true;
    }
    public function cancel()
    {
        $this->updateOurServices = false;
        $this->resetFields();
    }
    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update services
            OurServices::find($this->services_id)->fill([
                'title'=>$this->title,
                'description'=>$this->description,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success','Services Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating services!!');
            $this->cancel();
        }
    }
    public function destroy($id){
        try{
            OurServices::find($id)->delete();
            session()->flash('success',"Services Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting services!!");
        }
    }

}
