<?php

namespace App\Http\Livewire\System;

use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class StatusIndex extends Component
{
    use WithPagination ;
    public  $status_id, $slug, $name ;

    public $updateStatus = false;
    protected $listeners = [
        'deleteStatus'=>'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required'
    ];

    public function render()
    {
        $statuses = Status::select('id','name','slug')->paginate(20);
        return view('livewire.system.status.index')->with(compact('statuses'));
    }

    public function resetFields(){
        $this->name = '';
        $this->slug = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create Status
            Status::updateOrCreate([
                'name'=>$this->name,
                'slug'=>$this->slug
            ],
                [
                    'name'=>$this->name,
                    'slug'=>$this->slug
                ]

            );

            // Set Flash Message
            session()->flash('success','Status Created Successfully!!');
            // Reset Form Fields After Creating Status
            $this->resetFields();

        }catch(\Exception $e){

            // Set Flash Message
            session()->flash('error','Something goes wrong while creating status!!');
            // Reset Form Fields After Creating Status
            $this->resetFields();
        }
    }
    public function edit($id){
        $status = Status::findOrFail($id);
        $this->name = $status->name;
        $this->slug = $status->slug;
        $this->status_id = $status->id;
        $this->updateStatus = true;
    }
    public function cancel()
    {
        $this->updateStatus = false;
        $this->resetFields();
    }
    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update status
            Status::find($this->status_id)->fill([
                'name'=>$this->name,
                'slug'=>$this->slug
            ])->save();
            session()->flash('success','Status Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating status!!');
            $this->cancel();
        }
    }
    public function destroy($id){
        try{
            Status::find($id)->delete();
            session()->flash('success',"Status Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting status!!");
        }
    }
}
