<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\ItemCategory; // only needed if AudioFiles use categories
use App\Models\Bilta\Projects;
use Livewire\Component;
use Livewire\WithPagination;

class MyAudioBibleList extends Component
{
    use WithPagination;

    public $searchTerm; 
    public $project_id;
    public $title;
    public $categories = [];

    public function mount($project_id = null)
    {
        $this->project_id = $project_id;
    }

    public function render()
    {
        $query = AudioFile::with('project')->where('status_id', config('constants.status.active'));

        // Search logic
        if (!is_null($this->searchTerm)) {
            $query->where('title', 'like', '%' . $this->searchTerm . '%');
            $this->title = 'Results for "' . $this->searchTerm . '"';
        }

        // Filter by project if applicable
        if (!empty($this->project_id) && $this->project_id != '0') {
            $query->whereHas('project', function ($q) {
                $q->where('project_id', $this->project_id);
            });

            try {
                $this->title = 'Project: ' . (Projects::find($this->project_id)->name ?? "Unknown");
            } catch (\Exception $e) {
                $this->title = 'Unknown Project';
            }
        }

        $audioFiles = $query->latest()->paginate(20);

        // Optional: Get categories based on projects associated with audio files
        $this->categories = AudioFile::select('project_id' )
        ->with('project')
        ->selectRaw('project_id, COUNT(*) as audio_count')
        ->groupBy('project_id')
        ->get();

        return view('livewire.site.show-audio-bible-list')->with(compact('audioFiles'));
    }
}
