<?php

namespace App\Http\Livewire;

use App\Models\Bilta\HomeIntro;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\OurValues;
use App\Models\Bilta\Testimonial;
use Livewire\Component;

class ShowHome extends Component
{
    public function render()
    {
        $testimonials = Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')->take(4)->get();
        $our_teams = OurTeam::select('id', 'name',
            'phone',
            'email',
            'details',
            'position')->get();
        $our_values = OurValues::get();
        $home_intro = HomeIntro::first();

        return view('livewire.show-home')->with(compact('testimonials', 'our_teams', 'our_values', 'home_intro'));

    }
}
