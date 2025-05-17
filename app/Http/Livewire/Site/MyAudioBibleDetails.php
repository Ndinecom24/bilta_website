<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\Comments;
use App\Models\Projects;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class MyAudioBibleDetails extends Component
{
    use WithPagination;

    public $project;
    public $project_id;
    public $title;
    public $categories = [];
    public $newComment = '';

    protected $rules = [
        'newComment' => 'required|string|min:2|max:1000',
    ];

    public function mount(AudioFile $project)
    {
        $this->project = $project;
        $this->project_id = $project->id;
        $this->title = $project->title;
    }

    public function submitComment()
    {
        $this->validate();

        if (!Auth::check()) {
            session()->flash('error', 'You must be logged in to comment.');
            return;
        }

        Comments::create([
            'commentable_id' => $this->project->id,
            'commentable_type' => AudioFile::class,
            'body' => $this->newComment,
        ]);

        $this->newComment = '';
        session()->flash('success', 'Comment posted successfully.');
    }

    public function render()
    {
        $comments = Comments::where('commentable_id', $this->project->id)
            ->where('commentable_type', AudioFile::class)
            ->latest()
            ->paginate(10);

        $this->categories = Projects::selectRaw('category_id, count(*) as total')
            ->where('status_id', config('constants.status.active'))
            ->groupBy('category_id')
            ->get();

        return view('livewire.site.show-audio-bible-details', [
            'comments' => $comments,
        ]);
    }
}
