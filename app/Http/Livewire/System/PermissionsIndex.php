<?php

namespace App\Http\Livewire\System;

use App\Models\System\Permission;
use Livewire\Component;
use Livewire\WithPagination;

class PermissionsIndex extends Component
{
    use WithPagination ;
    public  $permission_id, $slug, $name ;

    public $updatePermission = false;
    protected $listeners = [
        'deletePermission'=>'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required'
    ];

    public function render()
    {
        $permissions = Permission::select('id','name','slug')->paginate(20);
           return view('livewire.system.permission.index')->with(compact('permissions'));
    }

    public function resetFields(){
        $this->name = '';
        $this->slug = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create Permission
            Permission::updateOrCreate([
                'name'=>$this->name,
                'slug'=>$this->slug
            ],
                [
                    'name'=>$this->name,
                    'slug'=>$this->slug
                ]);

            // Set Flash Message
            session()->flash('success','Permission Created Successfully!!');
            // Reset Form Fields After Creating Permission
            $this->resetFields();

        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating permission!!');
            // Reset Form Fields After Creating Permission
            $this->resetFields();
        }
    }
    public function edit($id){
        $permission = Permission::findOrFail($id);
        $this->name = $permission->name;
        $this->slug = $permission->slug;
        $this->permission_id = $permission->id;
        $this->updatePermission = true;
    }
    public function cancel()
    {
        $this->updatePermission = false;
        $this->resetFields();
    }
    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update permission
            Permission::find($this->permission_id)->fill([
                'name'=>$this->name,
                'slug'=>$this->slug
            ])->save();
            session()->flash('success','Permission Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating permission!!');
            $this->cancel();
        }
    }
    public function destroy($id){
        try{
            Permission::find($id)->delete();
            session()->flash('success',"Permission Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting permission!!");
        }
    }
}
