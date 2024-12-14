<?php

Namespace App\Http\Livewire\Admin\AudioPage;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\Projects;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowItemAudio extends Component
{

    use WithFileUploads;
    use WithPagination;

 

    public $audio_item_id, $project_id, $title, $description, $status_id, $created_by;
    public $file_url, $audio_item , $new_file_url ;

    public $updateAudios = false;
    protected $listeners = [
        'deleteAudioItem' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'description' => 'required',
        'title' => 'required',
        'status_id' => 'required',
        'project_id' => 'required',
        'file_url' => 'required', // ,

    ];

    public function render()
    {
        $statuses = Status::select('id', 'name')->get();
        $projects = Projects::select('id', 'title')->get();
        $audio_items = AudioFile::select('project_id', 'id', 'description', 'title', 'status_id', 'created_by', 'file_url')->paginate(20);
        return view('livewire.admin.audios-page.index')
            ->with(compact('audio_items', 'statuses', 'projects'));
    }

    public function resetFields()
    {
        $this->description = '';
        $this->title = '';
        $this->project_id = '';
        $this->status_id = '';
        $this->created_by = '';
        $this->file_url = '';
    }

    public function store()
    {

        // Validate Form Request
        $this->validate();
        try {
            // Create Audios
            $audio_item = AudioFile::updateOrCreate(
                [
                    'description' => $this->description,
                    'title' => $this->title,
                    'project_id' => $this->project_id,
                ],
                [
                    'description' => $this->description,
                    'title' => $this->title,
                    'status_id' => $this->status_id,
                    'file_url' => $this->file_url->getClientOriginalName() ,
                    'project_id' => $this->project_id,
                    'created_by' => auth()->user()->id
                ]

            );

            
            $audio_item->addMedia($this->file_url)->toMediaCollection('audio_files');


            // Set Flash Message
            session()->flash('success', 'Audio Item Created Successfully!!');
            // Reset Form Fields After Creating Audios
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating audio item!!' . $e->getMessage());
            // Reset Form Fields After Creating Audios
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $audio_item = AudioFile::findOrFail($id);
        $this->description = $audio_item->description;
        $this->title = $audio_item->title;
        $this->status_id = $audio_item->status_id;
        $this->project_id = $audio_item->project_id;
        $this->audio_item_id = $audio_item->id;

        $this->updateAudios = true;
        $this->audio_item = $audio_item;
    }

    public function cancel()
    {
        $this->updateAudios = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
    
        try {
            // Find the audio item
            $audio_item = AudioFile::findOrFail($this->project_id);
    
            // Determine the file name
            $file_name = $this->new_file_url 
                ? $this->new_file_url->getClientOriginalName() 
                : ($this->file_url ? $this->file_url->getClientOriginalName() : $audio_item->file_url);
    
            // Update the audio item fields
            $audio_item->update([
                'description' => $this->description,
                'title' => $this->title,
                'status_id' => $this->status_id,
                'file_url' => $file_name,
                'project_id' => $this->project_id,
                'created_by' => auth()->user()->id,
            ]);
    
            // If a new file is uploaded, update the media collection
            if ($this->new_file_url) {
                $audio_item->clearMediaCollection('audio_files');
                $audio_item->addMedia($this->new_file_url)->toMediaCollection('audio_files');
            }
    
            session()->flash('success', 'Audio updated successfully!');
            $this->cancel();
    
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong while updating the audio item!');
            $this->cancel();
        }
    }
    

    public function destroy($id)
    {
        try {
            AudioFile::find($id)->delete();
            session()->flash('success', "Audios Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting item category!!");
        }
    }

}
