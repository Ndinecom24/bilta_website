<?php

namespace App\Http\Livewire\Admin\Other;

use App\Models\Bilta\ChairmanMessage;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;

class ShowChairmansMessage extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $chairmans_message_id, $title, $message, $status_id, $name , $chairmansMsg ;

    public $intro_image , $intro_image_update  ;
    public $updateChairmansMessage = false;


    public $showEditSection = false;

    protected $listeners = [
        'deleteChairmansMessage' => 'destroy'
    ];

    // Validation Rules
    protected $rules = [
        // 'chairmansmessage' => 'required|chairmansmessage',
        'title' => 'required|string|max:255',
        'message' => 'required|string',
        'name' => 'required|string', 
        'intro_image' => 'image|max:3072', // 1MB Max
        'intro_image_update' => 'nullable|max:3072', // 1MB Max
        ];

    

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $chairmansmessages = ChairmanMessage::select('*')->paginate(20);
        return view('livewire.admin.chairmans-message.index', compact('chairmansmessages', 'statuses'));
    }

    public function resetFields()
    {
        $this->chairmansmessage = '';
        $this->title = '';
        $this->message = '';
        $this->status_id = '';
        $this->name = '';
        $this->recipient = '';
        $this->spam = '';
    }

    public function saveChairmansMessage()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create or Update Chairmans Message
            $cMessage = ChairmanMessage::updateOrCreate(
                [
                    'name' => $this->name,
                    'message' => $this->message,
                    'title' => $this->title,
                ],
                [
                    'name' => $this->name,
                    'title' => $this->title,
                    'message' => $this->message,
                    'status_id' => 1,
                    'created_by' => auth()->user()->id,
                ]
            );

            $cMessage->addMedia($this->intro_image)
            ->toMediaCollection('chairman_photo');



            // Set Flash Message
            session()->flash('success', 'Chairmans Message Created Successfully!');
            // Reset Form Fields After Creating ChairmansMessage
            $this->resetFields();

        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while creating chairmans message: '. $e->getMessage() );
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $chairmansmessage = ChairmanMessage::findOrFail($id);
        $this->chairmansMsg  =  $chairmansmessage  ;

        $this->title = $chairmansmessage->title;
        $this->message = $chairmansmessage->message;
        $this->status_id = $chairmansmessage->status_id;
        $this->name = $chairmansmessage->name;
        $this->chairmans_message_id = $chairmansmessage->id;
        $this->updateChairmansMessage = true;
        $this->intro_image = null ;
    }

    public function cancel()
    {
        $this->updateChairmansMessage = false;
        $this->resetFields();
    }

    public function updateChairmansMessage()
    {
        // $this->validate();
        try {
           $cMessage = ChairmanMessage::find($this->chairmans_message_id)->fill([
              
                'name' => $this->name,
                'title' => $this->title,
                'message' => $this->message,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id ,
            ])->save();

            if (isset($this->intro_image_update)) {
                try {
                    $this->chairmansMsg ->clearMediaCollection('chairman_photo');
                    $this->chairmansMsg ->addMedia($this->intro_image_update)
                        ->toMediaCollection('chairman_photo');
                    $this->cancel();
                } catch (\Exception $e) {
                    session()->flash('error', 'Something goes wrong while updating  Image !!');
                }

            }

            session()->flash('success', 'Chairmans Message Updated Successfully!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while updating chairmans message!' . $e->getMessage());
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            ChairmanMessage::find($id)->delete();
            session()->flash('success', "Chairmans Message Deleted Successfully!");
        } catch (\Exception $e) {
            session()->flash('error', "Something went wrong while deleting chairmans message!");
        }
    }


    public function enableEditSection()
    {
        $this->showEditSection = true;
    }

    public function disableEditSection()
    {
        $this->showEditSection = false;
    }


    // Optional: reset page when searching or filtering
    public function updatingSearch()
    {
        $this->resetPage();
    }

}
