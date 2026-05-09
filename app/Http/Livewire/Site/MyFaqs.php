<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\FAQs;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Schema;

class MyFaqs extends Component
{
    use WithPagination;

    public function render()
    {
        $query = FAQs::select('id', 'question', 'answer');

        if (Schema::hasColumn('f_a_qs', 'status_id')) {
            $query->where('status_id', config('constants.status.active'));
        }

        $faqs = $query->paginate(20);
        return view('livewire.site.show-f-a-qs')->with(compact('faqs'));
    }
}
