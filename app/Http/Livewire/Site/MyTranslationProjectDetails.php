<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\Projects;
use Livewire\Component;
use Livewire\WithPagination;


class MyTranslationProjectDetails extends Component
{
    use WithPagination;

    public $project, $project_id ;
    public $categories = [] ;

    public function mount(Projects $project){
        $this->project = $project ;
    }

    public function render()
    {

        // $this->project_categories = ItemCategory::select('*')->where('type',  'Project')->get()  ;
        $this->categories = Projects::selectRaw('category_id, count(*) as total')->where('status_id', config('constants.status.active'))->groupBy('category_id')->get() ;
      
        return view('livewire.site.show-translation-project-details');
    }
}
