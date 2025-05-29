<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\Projects;
use Livewire\Component;
use Livewire\WithPagination;

class MyTranslationProjectsList extends Component
{
    use WithPagination;

    public $searchTerm, $category_id;
    public $title = 'All';

    public function mount($category_id = 0)
    {
        $this->category_id = $category_id;
    }

    public function render()
    {
        $query = Projects::query()
            ->where('status_id', config('constants.status.active'));

        if (!empty($this->searchTerm)) {
            $query->where('title', 'like', '%' . $this->searchTerm . '%');
            $this->title = 'Results based on "' . $this->searchTerm . '"';
        } elseif ($this->category_id != 0) {
            $query->where('category_id', $this->category_id);

            $category = ItemCategory::find($this->category_id);
            $this->title = $category ? 'Results in "' . $category->name . '"' : 'Results in Unknown Category';
        }

        $projects = $query->paginate(20);

        $categories = Projects::selectRaw('category_id, count(*) as total')
            ->where('status_id', config('constants.status.active'))
            ->groupBy('category_id')
            ->get();

        return view('livewire.site.show-translation-projects-list', [
            'projects' => $projects,
            'categories' => $categories,
            'title' => $this->title,
        ]);
    }
}
