<?php

namespace App\Http\Livewire\Admin\TranslationProjectsPage;

use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\ProjectLocation;
use App\Models\Bilta\Projects;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Intervention\Image\Facades\Image;

class ShowTranslationProjects extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $our_projects_id, $project, $details, $title, $short_description, $post_date, $author, $status_id, $created_by, $category_id, $display_order
    , $location, $location_map, $latitude, $longitude ;
    public $title_image, $project_image , $project_file ;

    // Multiple locations support
    public $projectLocations = [];


    public $updateProjectsItem = false;
    protected $listeners = [
        'deleteProjects' => 'destroy',
        'addLocationFromMap' => 'addLocationFromMap'
    ];
    // Validation Rules
    protected $rules = [
        'title' => 'required',
        'details' => 'required',
        'short_description' => 'required',
        'post_date' => 'required',
        'author' => 'required',
        'display_order' => 'nullable|integer|min:0',
        'location' => 'required',
        'location_map' => 'required',
        'title_image' => 'nullable|image|max:5120', // 5MB Max
        'project_image' => 'nullable|array',
        'project_image.*' => 'image|max:5120', // 5MB Max per image
        'project_file' => 'nullable|array',
        'project_file.*' => 'file|max:10240', // 10MB Max per file
    ];

    public function render()
    {
                $translation_projects = Projects::select('id', 'title', 'details', 'short_description', 'post_date', 'author',
                    'created_by', 'status_id', 'location', 'location_map', 'display_order'
                )
                        ->orderBy('display_order')
                        ->orderBy('created_at', 'desc')
                        ->paginate(20);
        $statuses = Status::get();
        $categories = ItemCategory::where('type', 'Projects')->get();


        $this->dispatchBrowserEvent('fillTrixFields', [
            'short_description' => $this->short_description,
            'details' => $this->details,
        ]);
         
            return view('livewire.admin.translation-projects-page.index')
            ->with(compact('translation_projects', 'statuses', 'categories'));
    }

    public function addLocation()
    {
        $this->projectLocations[] = ['name' => '', 'latitude' => '', 'longitude' => ''];
    }

    public function addLocationFromMap($name, $latitude, $longitude)
    {
        $this->projectLocations[] = [
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }

    public function removeLocation($index)
    {
        unset($this->projectLocations[$index]);
        $this->projectLocations = array_values($this->projectLocations);
    }

    private function syncLocations($project)
    {
        // Remove old locations
        $project->locations()->delete();

        // Save new locations
        foreach ($this->projectLocations as $loc) {
            if (!empty($loc['latitude']) && !empty($loc['longitude'])) {
                $project->locations()->create([
                    'name' => $loc['name'] ?? $project->location ?? 'Location',
                    'latitude' => $loc['latitude'],
                    'longitude' => $loc['longitude'],
                ]);
            }
        }

        // Also sync the primary lat/lng from first location for backward compatibility
        if (!empty($this->projectLocations)) {
            $first = $this->projectLocations[0];
            $project->update([
                'latitude' => $first['latitude'] ?? null,
                'longitude' => $first['longitude'] ?? null,
            ]);
        }
    }

    public function store()
    {
        // Validate Form Request
        $this->validate();
        try {
            // Create ProjectsItem
            $projects = Projects::updateOrCreate(
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'author' => $this->author,
                    'short_description' => $this->short_description,
                    'location' => $this->location,
                ],
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'author' => $this->author,
                    'short_description' => $this->short_description,
                    'category_id' => $this->category_id,
                    'display_order' => $this->display_order ?? 0,
                    'status_id' => $this->status_id,
                    'location' => $this->location,
                    'location_map' => $this->location_map,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'created_by' => auth()->user()->id
                ]
            );

            // Sync multiple locations
            $this->syncLocations($projects);

            //save title image (auto-compressed)
            if (isset($this->title_image)) {
                $this->compressImage($this->title_image);
                $projects->addMedia($this->title_image)
                    ->toMediaCollection('project_title_images');
            }

            // save other project images (auto-compressed)
            if (isset($this->project_image)) {
                foreach ($this->project_image as $item) {
                    $this->compressImage($item);
                    $projects->addMedia($item)
                        ->toMediaCollection('project_images');
                }
            }

            // save project files (no compression for non-image files)
            if (isset($this->project_file)) {
                foreach ($this->project_file as $item) {
                    $projects->addMedia($item)
                        ->toMediaCollection('project_files');
                }
            }

            // Set Flash Message
            session()->flash('success', 'Projects Item Created Successfully!!');
            // Reset Form Fields After Creating ProjectsItem
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating projects item!!' . $e->getMessage());
            // Reset Form Fields After Creating ProjectsItem
            $this->resetFields();
        }
    }

    public function resetFields()
    {
        $this->title = '';
        $this->details = '';
        $this->short_description = '';
        $this->post_date = '';
        $this->author = '';
        $this->category_id = '';
        $this->display_order = 0;
        $this->status_id = '';
        $this->location = '';
        $this->location_map = '';
        $this->latitude = null;
        $this->longitude = null;
        $this->title_image = null ;
        $this->project_image = null ;
        $this->project_file = null ;
        $this->projectLocations = [];
    }

    public function edit($id)
    {
        $our_projects = Projects::findOrFail($id);

     
        $this->project = $our_projects;

        $this->title = $our_projects->title;
        $this->details = $our_projects->details;
        $this->post_date = $our_projects->post_date;
        $this->author = $our_projects->author;
        $this->location = $our_projects->location;
        $this->location_map = $our_projects->location_map;
        $this->latitude = $our_projects->latitude;
        $this->longitude = $our_projects->longitude;
        $this->short_description = $our_projects->short_description;
        $this->category_id = $our_projects->category_id;
        $this->display_order = $our_projects->display_order ?? 0;
        $this->status_id = $our_projects->status_id;
        $this->our_projects_id = $our_projects->id;
        $this->updateProjectsItem = true;

        // Load existing locations
        $this->projectLocations = $our_projects->locations->map(function ($loc) {
            return ['name' => $loc->name, 'latitude' => $loc->latitude, 'longitude' => $loc->longitude];
        })->toArray();

        // If no locations exist but project has lat/lng, seed from project fields
        if (empty($this->projectLocations) && $our_projects->latitude && $our_projects->longitude) {
            $this->projectLocations = [[
                'name' => $our_projects->location ?? 'Primary Location',
                'latitude' => $our_projects->latitude,
                'longitude' => $our_projects->longitude,
            ]];
        }

        $this->dispatchBrowserEvent('load-trix-content', ['content' => $our_projects->details ?? '']);
    }

    public function update()
    {

        // Validate request
//        $this->validate();
        try {
            // Update our_projects
            Projects::find($this->our_projects_id)->fill(
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'author' => $this->author,
                    'location' => $this->location,
                    'location_map' => $this->location_map,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                    'short_description' => $this->short_description,
                    'category_id' => $this->category_id,
                    'display_order' => $this->display_order ?? 0,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]
            )->save();

            // Sync multiple locations
            $projectModel = Projects::find($this->our_projects_id);
            $this->syncLocations($projectModel);

            $projects = Projects::find( $this->our_projects_id ) ;

            //save title image (auto-compressed)
            if (isset($this->title_image)) {
                $projects->clearMediaCollection('project_title_images');
                $this->compressImage($this->title_image);
                $projects->addMedia($this->title_image)
                    ->toMediaCollection('project_title_images');
            }

            //save other images (auto-compressed)
            if (isset($this->project_image)) {
                foreach ($this->project_image as $item) {
                    $this->compressImage($item);
                    $projects->addMedia($item)
                        ->toMediaCollection('project_images');
                }
            }

            //save project files (no compression for non-image files)
            if (isset($this->project_file)) {
                foreach ($this->project_file as $item) {
                    $projects->addMedia($item)
                        ->toMediaCollection('project_files');
                }
            }

            $this->cancel();
            session()->flash('success', 'Projects Item Updated Successfully!!');

        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating projects item!! '.$e->getMessage() );
            $this->cancel();
        }
    }

    public function cancel()
    {
        $this->updateProjectsItem = false;
        $this->resetFields();
    }


    public function destroy($id)
    {
     try {
            Projects::find($id)->delete();
            session()->flash('success', "Projects Item Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting projects item!!");
        }
    }


    public function removeImage($item){

        Media::find( $item)->delete();
        $this->project  = Projects::find($this->our_projects_id );
        session()->flash('success', "Projects Image Deleted Successfully!!");
    }

    public function removeFile($item){

        Media::find( $item)->delete();
        $this->project  = Projects::find($this->our_projects_id );
        session()->flash('success', "Projects File Deleted Successfully!!");
    }

    /**
     * Compress an uploaded image to reduce file size (75% quality).
     * Maintains dimensions, only reduces encoding quality.
     */
    private function compressImage($uploadedFile)
    {
        try {
            $path = $uploadedFile->getRealPath();
            $image = Image::make($path);

            // Determine format from mime type
            $mime = $uploadedFile->getMimeType();
            $format = 'jpg';
            if ($mime === 'image/png') {
                $format = 'png';
            } elseif ($mime === 'image/webp') {
                $format = 'webp';
            }

            // Compress and overwrite the temp file
            $image->encode($format, 75)->save($path);
        } catch (\Exception $e) {
            // If compression fails, continue with original file
        }

        return $uploadedFile;
    }
}
