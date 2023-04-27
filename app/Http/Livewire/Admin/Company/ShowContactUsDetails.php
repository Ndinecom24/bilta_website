<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\ContactUs;
use Livewire\Component;
use Livewire\WithPagination;

class ShowContactUsDetails  extends Component
{
    use WithPagination ;

    public  $contact_us_id, $phone, $email, $address , $message, $google_maps , $facebook_url,
        $linkedin_url,
        $twitter_url,
        $youtube,
        $whatsapp_link;

    public $updateContactUs = false;
    protected $listeners = [
        'deleteContactUs'=>'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'email'=>'required',
        'phone'=>'required',
        'address'=>'required',
        'google_maps'=>'required',
    ];

    public function render()
    {
        $contact_details = ContactUs::select('id','email','phone', 'address','message', 'google_maps', 'facebook_url', 'linkedin_url', 'twitter_url', 'youtube', 'whatsapp_link', )
            ->first();
        return view('livewire.admin.company.contact-us.index')->with(compact('contact_details'));
    }

    public function resetFields(){
        $this->email = '';
        $this->phone = '';
        $this->message = '';
        $this->address = '';
        $this->google_maps = '';
        $this->youtube = '';
        $this->linkedin_url = '';
        $this->facebook_url = '';
        $this->twitter_url = '';
        $this->whatsapp_link = '';
    }
    public function store(){
        // Validate Form Request
        $this->validate();
        try{
            // Create ContactUs
            ContactUs::updateOrCreate([
                'email'=>$this->email,
                'phone'=>$this->phone,
                'address'=>$this->address,
                'google_maps'=>$this->google_maps,
            ],
                [
                    'email'=>$this->email,
                    'phone'=>$this->phone,
                    'address'=>$this->address,
                    'google_maps'=>$this->google_maps,
                    'message' =>$this->message,
                    'whatsapp_link'=>$this->whatsapp_link,
                    'youtube'=>$this->youtube,
                    'facebook_url'=>$this->facebook_url,
                    'linkedin_url'=>$this->linkedin_url,
                    'twitter_url'=>$this->twitter_url,
                    'created_by' => auth()->user()->id
                ]

            );

            // Set Flash Message
            session()->flash('success','Contact Details Created Successfully!!');
            // Reset Form Fields After Creating ContactUs
            $this->resetFields();

        }catch(\Exception $e){

            // Set Flash Message
            session()->flash('error','Something goes wrong while creating about us!!'. $e->getMessage());
            // Reset Form Fields After Creating ContactUs
            $this->resetFields();
        }
    }
    public function edit($id){
        $contact_us = ContactUs::findOrFail($id);
        $this->email = $contact_us->email;
        $this->phone = $contact_us->phone;
        $this->address = $contact_us->address;
        $this->message = $contact_us->message;
        $this->google_maps = $contact_us->google_maps;
        $this->linkedin_url = $contact_us->linkedin_url;
        $this->facebook_url = $contact_us->facebook_url;
        $this->youtube = $contact_us->youtube;
        $this->twitter_url = $contact_us->twitter_url;
        $this->whatsapp_link = $contact_us->whatsapp_link;
        $this->contact_us_id = $contact_us->id;
        $this->updateContactUs = true;
    }
    public function cancel()
    {
        $this->updateContactUs = false;
        $this->resetFields();
    }
    public function update(){
        // Validate request
        $this->validate();
        try{
            // Update contact_us
            ContactUs::find($this->contact_us_id)->fill([
                'email'=>$this->email,
                'phone'=>$this->phone,
                'address'=>$this->address,
                'message' =>$this->message,
                'google_maps'=>$this->google_maps,
                'whatsapp_link'=>$this->whatsapp_link,
                'youtube'=>$this->youtube,
                'facebook_url'=>$this->facebook_url,
                'linkedin_url'=>$this->linkedin_url,
                'twitter_url'=>$this->twitter_url,
                'created_by' => auth()->user()->id
            ])->save();
            session()->flash('success','Contact Details Updated Successfully!!');

            $this->cancel();
        }catch(\Exception $e){
            session()->flash('error','Something goes wrong while updating contact details!!');
            $this->cancel();
        }
    }
    public function destroy($id){
        try{
            ContactUs::find($id)->delete();
            session()->flash('success',"Contact Details Deleted Successfully!!");
        }catch(\Exception $e){
            session()->flash('error',"Something goes wrong while deleting contact details!!");
        }
    }

}
