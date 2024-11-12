<?php

namespace App\Http\Livewire\Admin\Other;

use App\Models\ContactMessage;
use App\Models\System\Status;
use App\Models\Email; // Assuming you have an Email model
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;

class ShowEmails extends Component
{
    use WithPagination;

    public $email_id, $email, $subject, $message, $status_id, $name, $recipient;
    public $updateEmail = false;

    protected $listeners = [
        'deleteEmail' => 'destroy'
    ];

    // Validation Rules
    protected $rules = [
        // 'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string',
        // 'status_id' => 'required|exists:statuses,id',
    ];

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $emails = ContactMessage::select('id', 'email', 'subject', 'message', 'status_id', 'name', 'recipient')->paginate(20);
        return view('livewire.admin.contact-emails-page.index', compact('emails', 'statuses'));
    }

    public function resetFields()
    {
        $this->email = '';
        $this->subject = '';
        $this->message = '';
        $this->status_id = '';
        $this->name = '';
        $this->recipient = '';
    }

    public function sendEmail()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create or Update Email
            $contactMessage =   ContactMessage::updateOrCreate(
                [
                    'email' =>  auth()->user()->email   ,
                    'recipient' =>  $this->recipient ,
                ],
                [
                    'email' =>  auth()->user()->email ,
                    'recipient' =>  $this->recipient ,
                    'subject' => $this->subject,
                    'message' => $this->message,
                    'status_id' =>  1,
                    'created_by' => auth()->user()->id,
                    'name' => auth()->user()->name,
                ]
            );

    
        // Send the email (you'll need to set up a Mailable for this)
        Mail::to( $this->recipient)->send(new \App\Mail\ContactMessageMail($contactMessage));


            // Set Flash Message
            session()->flash('success', 'Email Created Successfully!');
            // Reset Form Fields After Creating Email
            $this->resetFields();

        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while creating email: ' . $e->getMessage());
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $email = ContactMessage::findOrFail($id);
        $this->email = $email->email;
        $this->recipient = $email->recipient;
        $this->subject = $email->subject;
        $this->message = $email->message;
        $this->status_id = $email->status_id;
        $this->name = $email->name;
        $this->email_id = $email->id;
        $this->updateEmail = true;
    }

    public function cancel()
    {
        $this->updateEmail = false;
        $this->resetFields();
    }

    public function updateEmail()
    {
        $this->validate();
        try {
            ContactMessage::find($this->email_id)->fill([
                'recipient' => $this->recipient,
                'email' => $this->email,
                'subject' => $this->subject,
                'message' => $this->message,
                'status_id' => $this->status_id,
                'updated_by' => auth()->user()->id,
                'name' => auth()->user()->name,
            ])->save();

            session()->flash('success', 'Email Updated Successfully!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while updating email!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            ContactMessage::find($id)->delete();
            session()->flash('success', "Email Deleted Successfully!");
        } catch (\Exception $e) {
            session()->flash('error', "Something went wrong while deleting email!");
        }
    }
}
