<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\HomeIntro;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\OurValues;
use App\Models\Bilta\Testimonial;
use Livewire\Component;

class ShowHome extends Component
{
    public $search;

    public function render()
    {
        $testimonials = cache()->remember('home_testimonials', now()->addHours(6), function () {
            return Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')->take(4)->get();
        });

        $our_teams = cache()->remember('home_our_teams', now()->addHours(6), function () {
            return OurTeam::select('id', 'name', 'phone', 'email', 'details', 'position')->get();
        });

        $our_values = cache()->remember('home_our_values', now()->addHours(6), function () {
            return OurValues::get();
        });

        $home_intro = cache()->remember('home_intro', now()->addHours(6), function () {
            return HomeIntro::first();
        });

        $audioFiles = AudioFile::query()
            ->where('status_id', config('constants.status.active') )
            ->where('title', 'like', '%' . $this->search . '%')
            ->orWhereHas('project', function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('project.myCategory', function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);



        return view('livewire.site.show-home-page')->with(compact('testimonials', 'our_teams', 'our_values', 'home_intro', 'audioFiles'));
    }


    //     public function render()
// {
//     return cache()->remember('home_page_view', now()->addHours(6), function () {
//         $testimonials = Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')->take(4)->get();
//         $our_teams = OurTeam::select('id', 'name', 'phone', 'email', 'details', 'position')->get();
//         $our_values = OurValues::get();
//         $home_intro = HomeIntro::first();

    //         return view('livewire.site.show-home-page', compact('testimonials', 'our_teams', 'our_values', 'home_intro'))->render();
//     });
// }

}
