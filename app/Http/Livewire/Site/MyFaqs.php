<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\FAQs;
use Livewire\Component;
use Livewire\WithPagination;

class MyFaqs extends Component
{
    use WithPagination;

    public function render()
    {
        $faqs = FAQs::select('id', 'question', 'answer')->where('status_id', config('constants.status.active'))->paginate(20);
        return view('livewire.site.show-f-a-qs')->with(compact('faqs'));
    }
}
