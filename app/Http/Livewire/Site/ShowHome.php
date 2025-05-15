<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\HomeIntro;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\OurValues;
use App\Models\Bilta\Testimonial;
use App\Models\Bilta\ChairmanMessage;
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

        $chairman = cache()->remember('chairman', now()->addHours(6), function () {
            return ChairmanMessage::latest()->first(); 
        });


        $searchKey = $this->search;
        $page = request()->get('page', 1);
        $cacheKey = 'audio_files_' . md5($searchKey . '_page_' . $page);
        
        $audioFiles = cache()->remember($cacheKey, now()->addHours(6), function () use ($searchKey) {
            return AudioFile::query()
                ->where('status_id', config('constants.status.active'))
                ->where(function ($query) use ($searchKey) {
                    $query->where('title', 'like', '%' . $searchKey . '%')
                        ->orWhereHas('project', function ($query) use ($searchKey) {
                            $query->where('title', 'like', '%' . $searchKey . '%');
                        })
                        ->orWhereHas('project.myCategory', function ($query) use ($searchKey) {
                            $query->where('name', 'like', '%' . $searchKey . '%');
                        });
                })
                ->paginate(10);
        });


        return view('livewire.site.show-home-page')->with(compact('testimonials', 'our_teams', 'our_values', 'home_intro', 'audioFiles', 'chairman' ));
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
