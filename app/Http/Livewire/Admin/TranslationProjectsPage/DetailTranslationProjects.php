<?php

namespace App\Http\Livewire\Admin\TranslationProjectsPage;

use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\Projects;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DetailTranslationProjects extends Component
{
    use WithFileUploads;

    public $our_projects_id, $project, $details, $title, $short_description, $post_date, $author, $status_id, $created_by, $category_id, $display_order,
        $location;
    public $title_image, $project_image, $project_file;

    public $updateProjectsItem = false;
    protected $listeners = [
        'deleteProjects' => 'destroy',
    ];

    protected $updateRules = [
        'title' => 'required',
        'details' => 'required',
        'short_description' => 'required',
        'post_date' => 'required',
        'author' => 'required',
        'status_id' => 'required',
        'category_id' => 'required',
        'display_order' => 'nullable|integer|min:0',
        'location' => 'required',
        'title_image' => 'nullable|max:3072',
        'project_image.*' => 'nullable|max:3072',
        'project_file.*' => 'nullable|max:3072',
    ];

    public function mount($item)
    {
        $this->our_projects_id = $item;
    }

    public function render()
    {
        $this->project = Projects::with('locations')->findOrFail($this->our_projects_id);
        $statuses = Status::get();
        $categories = ItemCategory::where('type', 'Projects')->get();

        return view('livewire.admin.translation-projects-page.show-project')
            ->with(compact('statuses', 'categories'));
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
        $this->title_image = null;
        $this->project_image = null;
        $this->project_file = null;
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
        $this->short_description = $our_projects->short_description;
        $this->category_id = $our_projects->category_id;
        $this->display_order = $our_projects->display_order ?? 0;
        $this->status_id = $our_projects->status_id;
        $this->our_projects_id = $our_projects->id;
        $this->updateProjectsItem = true;
    }

    public function update()
    {
        $this->validate($this->updateRules);

        try {
            Projects::find($this->our_projects_id)->fill(
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'author' => $this->author,
                    'location' => $this->location,
                    'short_description' => $this->short_description,
                    'category_id' => $this->category_id,
                    'display_order' => $this->display_order ?? 0,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id,
                ]
            )->save();

            $projects = Projects::find($this->our_projects_id);

            if (isset($this->title_image)) {
                $projects->clearMediaCollection('project_title_images');
                $projects->addMedia($this->title_image)
                    ->toMediaCollection('project_title_images');
            }

            if (isset($this->project_image)) {
                foreach ($this->project_image as $item) {
                    $projects->addMedia($item)
                        ->toMediaCollection('project_images');
                }
            }

            if (isset($this->project_file)) {
                foreach ($this->project_file as $item) {
                    $projects->addMedia($item)
                        ->toMediaCollection('project_files');
                }
            }

            session()->flash('success', 'Projects Item Updated Successfully!!');
            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating projects item!! ' . $e->getMessage());
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
            session()->flash('success', 'Projects Item Deleted Successfully!!');
            return redirect()->route('admin.page.item.projects');
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while deleting projects item!!');
        }
    }

    public function removeImage($item)
    {
        Media::find($item)->delete();
        session()->flash('success', 'Projects Image Deleted Successfully!!');
    }

    public function removeFile($item)
    {
        Media::find($item)->delete();
        session()->flash('success', 'Projects File Deleted Successfully!!');
    }
}
