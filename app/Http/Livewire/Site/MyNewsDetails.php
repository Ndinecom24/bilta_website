<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\ItemCategory;
use App\Models\Bilta\News;
use Livewire\Component;
use Livewire\WithPagination;

class MyNewsDetails extends Component
{
    use WithPagination;

    public $news, $news_id ;
    public $categories = [] ;

    public function mount(News $news){
        $this->news = $news ;
    }

    public function render()
    {
        // $this->news_categories = ItemCategory::select('*')->where('type',  'News')->get()  ;
        $this->categories = News::selectRaw('category_id, count(*) as total')->where('status_id', config('constants.status.active'))->groupBy('category_id')->get() ;
        return view('livewire.site.show-news-detail');

    }
}
