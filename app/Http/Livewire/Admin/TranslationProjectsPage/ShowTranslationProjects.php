<?php

namespace App\Http\Livewire\Admin\TranslationProjectsPage;

use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\Projects;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ShowTranslationProjects extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $our_projects_id, $project, $details, $title, $short_description, $post_date, $author, $status_id, $created_by, $category_id
    , $location, $location_map ;
    public $title_image, $project_image , $project_file ;


    public $updateProjectsItem = false;
    protected $listeners = [
        'deleteProjects' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'title' => 'required',
        'details' => 'required',
        'short_description' => 'required',
        'post_date' => 'required',
        'author' => 'required',
        'location' => 'required',
        'location_map' => 'required',
        'title_image' =>  'required|max:3072', // 3MB Max,
        'project_image' =>  'required|max:3072', // 3MB Max,
        'project_file' =>  'required|max:3072', // 3MB Max,
//        'title_image' => 'image|max:3072', // 1MB Max

    ];

    public function render()
    {
        $translation_projects = Projects::select('id', 'title', 'details', 'short_description', 'post_date', 'author',
          'created_by', 'status_id', 'location', 'location_map'
        )->paginate(20);
        $statuses = Status::get();
        $categories = ItemCategory::where('type', 'Projects')->get();


        $this->dispatchBrowserEvent('fillTrixFields', [
            'short_description' => $this->short_description,
            'details' => $this->details,
        ]);
        

        
            return view('livewire.admin.translation-projects-page.index')
            ->with(compact('translation_projects', 'statuses', 'categories'));
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
                    'status_id' => $this->status_id,
                    'location' => $this->location,
                    'location_map' => $this->location_map,
                    'created_by' => auth()->user()->id
                ]

            );

            //save title image
            if (isset($this->title_image)  ){
            $projects->addMedia($this->title_image)
                -> toMediaCollection('project_title_images');
            }

            // save other project images
            if (isset($this->project_image) ){
                foreach(  $this->project_image as $item  ){
                // if ( $item->fileExists()) {
                       $projects->addMedia( $item )
                    -> toMediaCollection('project_images') ;
                // }
                }
            }


            // save other project images
            if (isset($this->project_file) ){
                foreach(  $this->project_file as $item  ){
                // if ( $item->fileExists()) {
                       $projects->addMedia( $item )
                    -> toMediaCollection('project_files') ;
                // }
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
        $this->status_id = '';
        $this->location = '';
        $this->location_map = '';
        $this->title_image = null ;
        $this->project_image = null ;
        $this->project_file = null ;
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
        $this->short_description = $our_projects->short_description;
        $this->category_id = $our_projects->category_id;
        $this->status_id = $our_projects->status_id;
        $this->our_projects_id = $our_projects->id;
        $this->updateProjectsItem = true;
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
                    'short_description' => $this->short_description,
                    'category_id' => $this->category_id,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id
                ]
            )->save();

            $projects = Projects::find( $this->our_projects_id ) ;

            //save title image
            if (isset($this->title_image) ) {

                $projects->clearMediaCollection('project_title_images');
              $projects->addMedia( $this->title_image )
                    -> toMediaCollection('project_title_images');              
            }
        

            //save other images
            if (isset($this->project_image) ){
                foreach(  $this->project_image as $item  ){
                    
                    // if ( $item->fileExists()) {
                            // $projects->clearMediaCollection('project_images');
                          $projects->addMedia( $item )
                                -> toMediaCollection('project_images');
                        // }
                }
            }

            
            //save other images
            if (isset($this->project_file) ){
                foreach(  $this->project_file as $item  ){
                    
                    // if ( $item->fileExists()) {
                            // $projects->clearMediaCollection('project_files');
                          $projects->addMedia( $item )
                                -> toMediaCollection('project_files');
                        // }
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
}
