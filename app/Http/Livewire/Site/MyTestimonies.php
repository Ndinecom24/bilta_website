<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\Testimonies;
use Livewire\Component;

class MyTestimonies extends Component
{
    public function render()
    {
        $testimonies = Testimonies::select(  'name', 'title', 'description', 'status_id',)->where('status_id', config('constants.status.active'))->paginate(20);
        return view('livewire.site.show-testimonies')->with(compact('testimonies'));
    }
}
