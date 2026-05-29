<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\Projects;
use App\Models\Bilta\ItemCategory;
use Livewire\Component;

class ShowProjectsMap extends Component
{
    public $selectedProject = null;
    public $filterCategory = '';

    public function selectProject($id)
    {
        $this->selectedProject = Projects::with(['status', 'myCategory', 'locations'])->find($id);
    }

    public function clearSelection()
    {
        $this->selectedProject = null;
    }

    public function render()
    {
        $query = Projects::select('id', 'title', 'short_description', 'location', 'latitude', 'longitude', 'status_id', 'category_id', 'post_date', 'author')
            ->where('status_id', config('constants.status.active'))
            ->with(['status', 'myCategory', 'locations']);

        if (!empty($this->filterCategory)) {
            $query->where('category_id', $this->filterCategory);
        }

        $projects = $query->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Build a flat list of markers from project locations
        $mapMarkers = collect();
        foreach ($projects as $project) {
            if ($project->locations->count() > 0) {
                foreach ($project->locations as $loc) {
                    $mapMarkers->push([
                        'project_id' => $project->id,
                        'title' => $project->title,
                        'short_description' => $project->short_description,
                        'location' => $loc->name ?: $project->location,
                        'latitude' => $loc->latitude,
                        'longitude' => $loc->longitude,
                        'category_name' => $project->myCategory->name ?? '',
                    ]);
                }
            } elseif ($project->latitude && $project->longitude) {
                $mapMarkers->push([
                    'project_id' => $project->id,
                    'title' => $project->title,
                    'short_description' => $project->short_description,
                    'location' => $project->location,
                    'latitude' => $project->latitude,
                    'longitude' => $project->longitude,
                    'category_name' => $project->myCategory->name ?? '',
                ]);
            }
        }

        $categories = ItemCategory::where('type', 'Projects')->get();

        $totalActive = Projects::where('status_id', config('constants.status.active'))->count();

        return view('livewire.site.show-projects-map', compact(
            'projects', 'mapMarkers', 'categories', 'totalActive'
        ));
    }
}
