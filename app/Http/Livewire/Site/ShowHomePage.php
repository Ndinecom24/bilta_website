<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AboutUs;
use App\Models\Bilta\ContactUs;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\OurValues;
use App\Models\Bilta\Testimonial;
use Livewire\Component;

class ShowHomePage extends Component
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

        return view('livewire.site.show-home-page')->with(compact('testimonials', 'our_teams', 'our_values'));
    }
}
