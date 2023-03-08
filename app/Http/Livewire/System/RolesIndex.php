<?php

namespace App\Http\Livewire\System;

use App\Models\System\Role;
use Livewire\Component;
use Livewire\WithPagination;

class RolesIndex extends Component
{
    use WithPagination ;
    public  $role_id, $slug, $name ;

    public $updateRole = false;
    protected $listeners = [
        'deleteRole'=>'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'name'=>'required',
        'slug'=>'required'
    ];

    public function render()
    {
        $roles = Role::select('id','name','slug')->paginate(20);
        return view('livewire.system.role.index')->with(compact('roles'));
    }

    public function resetFields(){
        $this->name = '';
        $this->slug = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create Role
            Role::updateOrCreate([
                'name'=>$this->name,
                'slug'=>$this->slug
            ],[
                'name'=>$this->name,
                'slug'=>$this->slug
            ]);

            // Set Flash Message
            session()->flash('success','Role Created Successfully!!');
            // Reset Form Fields After Creating Role
            $this->resetFields();

        }catch(\Exception $e){
            // Set Flash Message
            session()->flash('error','Something goes wrong while creating role!!');
            // Reset Form Fields After Creating Role
            $this->resetFields();
        }
    }
    public function edit($id){
        $role = Role::findOrFail($id);
        $this->name = $role->name;
        $this->slug = $role->slug;
        $this->role_id = $role->id;
        $this->updateRole = true;
    }
    public function cancel()
    {
        $this->updateRole = false;
        $this->resetFields();
        $this->dispatchBrowserEvent('close-modal');
    }
    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update role
            Role::find($this->role_id)->fill([
                'name'=>$this->name,
                'slug'=>$this->slug
            ])->save();
            session()->flash('success','Role Updated Successfully!!');
            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating role!!');
            $this->cancel();
        }
    }
    public function destroy($id){
        try{
            Role::find($id)->delete();
            session()->flash('success',"Role Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting role!!");
        }
    }
}
