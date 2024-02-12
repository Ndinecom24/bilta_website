<?php

namespace App\Http\Livewire\Site;

    
use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\Projects;
use Livewire\Component;
use Livewire\WithPagination;

class MyTranslationProjectsList extends Component
{

    use WithPagination;
    public $searchTerm, $category_id , $title ;
    public $categories = [] ;


    public function mount($category_id ){
        $this->category_id = $category_id ;
    }

    public function render()
    {
        if( (! is_null($this->searchTerm ) )  ){
            $projects = Projects::select('*')->where('status_id', config('constants.status.active'))->paginate(20);
            $this->title = 'Results based on '.$this->searchTerm ;
        }if( ($this->category_id != '0') ){
            $projects = Projects::select('*')->where('category_id', $this->category_id)->where('status_id', config('constants.status.active'))->paginate(20);
         try{
            $this->title = 'Results based on '. ItemCategory::find( $this->category_id )->name ?? "non"   ;
         }catch(\Exeception $exeception){
            $this->title = 'Non' ;
         }
        }else{
            $projects = Projects::select('*')->where('status_id', config('constants.status.active'))->paginate(20);
            $this->title = 'All';
        }

        $this->categories = Projects::selectRaw('category_id, count(*) as total')->where('status_id', config('constants.status.active'))->groupBy('category_id')->get() ;

        return view('livewire.site.show-translation-projects-list')->with(compact('projects'));
    }



 
}
