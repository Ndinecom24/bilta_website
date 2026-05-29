<?php

namespace App\Http\Livewire\Admin\TranslationProjectsPage;

use App\Models\Bilta\Projects;
use App\Models\Bilta\ProjectLocation;
use App\Models\Bilta\ItemCategory;
use Livewire\Component;

class ShowProjectsMap extends Component
{
    public $selectedProject = null;

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
        // Get all projects that have at least one location
        $projects = Projects::select('id', 'title', 'short_description', 'location', 'latitude', 'longitude', 'status_id', 'category_id', 'post_date', 'author')
            ->with(['status', 'myCategory', 'locations'])
            ->orderBy('display_order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Build a flat list of markers: each location becomes a marker linked to its project
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
                        'status_name' => $project->status->name ?? 'Unknown',
                        'is_active' => $project->status && strtolower($project->status->name) === 'active',
                        'category_name' => $project->myCategory->name ?? 'Uncategorized',
                        'author' => $project->author,
                        'post_date' => $project->post_date,
                    ]);
                }
            } elseif ($project->latitude && $project->longitude) {
                // Fallback: use project-level lat/lng if no locations table entries
                $mapMarkers->push([
                    'project_id' => $project->id,
                    'title' => $project->title,
                    'short_description' => $project->short_description,
                    'location' => $project->location,
                    'latitude' => $project->latitude,
                    'longitude' => $project->longitude,
                    'status_name' => $project->status->name ?? 'Unknown',
                    'is_active' => $project->status && strtolower($project->status->name) === 'active',
                    'category_name' => $project->myCategory->name ?? 'Uncategorized',
                    'author' => $project->author,
                    'post_date' => $project->post_date,
                ]);
            }
        }

        $totalProjects = Projects::count();
        $mappedProjects = $projects->filter(function ($p) {
            return $p->locations->count() > 0 || ($p->latitude && $p->longitude);
        })->count();
        $unmappedProjects = $totalProjects - $mappedProjects;
        $totalLocations = $mapMarkers->count();

        $categories = ItemCategory::where('type', 'Projects')->get();

        $categoryStats = Projects::whereHas('locations')
            ->orWhere(function ($q) {
                $q->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->selectRaw('category_id, count(*) as total')
            ->groupBy('category_id')
            ->with('myCategory')
            ->get();

        return view('livewire.admin.translation-projects-page.projects-map', compact(
            'projects', 'mapMarkers', 'totalProjects', 'mappedProjects', 'unmappedProjects', 'totalLocations', 'categories', 'categoryStats'
        ));
    }
}
