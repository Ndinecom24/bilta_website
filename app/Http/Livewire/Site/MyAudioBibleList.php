<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\ItemCategory; // only needed if AudioFiles use categories
use Livewire\Component;
use Livewire\WithPagination;

class MyAudioBibleList extends Component
{
    use WithPagination;

    public $searchTerm, $category_id, $title;
    public $categories = [];

    public function mount($category_id = null)
    {
        $this->category_id = $category_id;
    }

    public function render()
    {
        $query = AudioFile::where('status_id', config('constants.status.active'));

        // Search logic
        if (!is_null($this->searchTerm)) {
            $query->where('title', 'like', '%' . $this->searchTerm . '%');
            $this->title = 'Results for "' . $this->searchTerm . '"';
        }

        // Filter by category if applicable
        if (!empty($this->category_id) && $this->category_id != '0') {
            $query->whereHas('project', function ($q) {
                $q->where('category_id', $this->category_id);
            });

            try {
                $this->title = 'Category: ' . (ItemCategory::find($this->category_id)->name ?? "Unknown");
            } catch (\Exception $e) {
                $this->title = 'Unknown Category';
            }
        }

        $audioFiles = $query->latest()->paginate(20);

        // Optional: Get categories based on projects associated with audio files
        $this->categories = ItemCategory::whereIn('id', function ($q) {
            $q->select('category_id')
              ->from('projects')
              ->whereIn('id', function ($sub) {
                  $sub->select('project_id')
                      ->from('audio_files')
                      ->where('status_id', config('constants.status.active'));
              });
        })->get();

        return view('livewire.site.show-audio-bible-list')->with(compact('audioFiles'));
    }
}
