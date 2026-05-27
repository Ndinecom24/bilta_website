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
    public $file_url, $audio_item, $new_file_url;
    public $external_url;

    public $updateAudios = false;
    protected $listeners = [
        'deleteAudioItem' => 'destroy'
    ];

    protected $rules = [
        'description' => 'required',
        'title' => 'required',
        'status_id' => 'required',
        'project_id' => 'required',
        'file_url' => 'nullable',
        'external_url' => 'nullable|url|max:2048',
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
        $this->new_file_url = '';
        $this->external_url = '';
    }

    public function store()
    {
        // At least one source required: file upload or external URL
        if (empty($this->file_url) && empty($this->external_url)) {
            $this->addError('file_url', 'Please upload an audio file or provide an external URL.');
            return;
        }

        $this->validate();
        try {
            $fileName = $this->file_url ? $this->file_url->getClientOriginalName() : ($this->external_url ?? '');

            $audio_item = AudioFile::create([
                'description' => $this->description,
                'title' => $this->title,
                'status_id' => $this->status_id,
                'file_url' => $fileName,
                'external_url' => $this->external_url ?: null,
                'project_id' => $this->project_id,
                'created_by' => auth()->user()->id,
            ]);

            if ($this->file_url && is_object($this->file_url)) {
                $audio_item->addMedia($this->file_url)->toMediaCollection('audio_files');
            }

            session()->flash('success', 'Audio Item Created Successfully!');
            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Error creating audio item: ' . $e->getMessage());
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
        $this->external_url = $audio_item->external_url;
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
        $validationRules = $this->rules;
        $validationRules['file_url'] = 'nullable';
        $validationRules['new_file_url'] = 'nullable';
        $this->validate($validationRules);

        try {
            $audio_item = AudioFile::findOrFail($this->audio_item_id);

            $file_name = $this->new_file_url
                ? $this->new_file_url->getClientOriginalName()
                : $audio_item->file_url;

            $audio_item->update([
                'description' => $this->description,
                'title' => $this->title,
                'status_id' => $this->status_id,
                'file_url' => $file_name,
                'external_url' => $this->external_url ?: null,
                'project_id' => $this->project_id,
                'created_by' => auth()->user()->id,
            ]);

            if ($this->new_file_url) {
                $audio_item->clearMediaCollection('audio_files');
                $audio_item->addMedia($this->new_file_url)->toMediaCollection('audio_files');
            }

            session()->flash('success', 'Audio updated successfully!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating audio item: ' . $e->getMessage());
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
