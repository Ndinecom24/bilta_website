<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\HomeIntro;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\OurValues;
use App\Models\Bilta\Testimonial;
use Livewire\Component;

class ShowHome extends Component
{
    // public function render()
    // {
    //     $testimonials = Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')->take(4)->get();
    //     $our_teams = OurTeam::select('id', 'name',
    //         'phone',
    //         'email',
    //         'details',
    //         'position')->get();
    //     $our_values = OurValues::get();
    //     $home_intro = HomeIntro::first();

    //     return view('livewire.site.show-home-page')->with(compact('testimonials', 'our_teams', 'our_values', 'home_intro'));

    // }

    public function render()
{
    return cache()->remember('home_page_view', now()->addHours(6), function () {
        $testimonials = Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')->take(4)->get();
        $our_teams = OurTeam::select('id', 'name', 'phone', 'email', 'details', 'position')->get();
        $our_values = OurValues::get();
        $home_intro = HomeIntro::first();

        return view('livewire.site.show-home-page', compact('testimonials', 'our_teams', 'our_values', 'home_intro'))->render();
    });
}

}
