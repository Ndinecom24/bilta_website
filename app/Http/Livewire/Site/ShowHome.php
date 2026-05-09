<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AudioFile;
use App\Models\Bilta\HomeIntro;
use App\Models\Bilta\News;
use App\Models\Bilta\OurTeam;
use App\Models\Bilta\OurValues;
use App\Models\Bilta\Projects;
use App\Models\Bilta\Testimonial;
use App\Models\Bilta\ChairmanMessage;
use App\Models\Bilta\Sponsor;
use Livewire\Component;

class ShowHome extends Component
{
    public $search;
    public $successMessage;


    public function render()
    {
     
        $testimonials = cache()->remember('home_testimonials', now()->addHours(6), function () {
            return Testimonial::select('id', 'testimonial', 'title', 'status_id', 'name')
            ->whereHas('status', function ($query)  {
                $query->where('name', 'like', '%Active%');
            })
            ->take(10)->get();
        });

        $our_teams = cache()->remember('home_our_teams', now()->addHours(6), function () {
            return OurTeam::select('id', 'name', 'phone', 'email', 'details', 'position', 'display_order')
                ->orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->get();
        });

        $our_values = cache()->remember('home_our_values', now()->addHours(6), function () {
            return OurValues::get();
        });

        $home_intro = cache()->remember('home_intro', now()->addHours(6), function () {
            return HomeIntro::first();
        });

        $missionSliderImages = cache()->remember('home_mission_slider_images', now()->addHours(6), function () use ($home_intro) {
            if (!$home_intro) {
                return [];
            }

            return $home_intro
                ->getMedia('mission_slider_images')
                ->map(fn($media) => $media->getUrl())
                ->values()
                ->all();
        });

        $chairman = cache()->remember('chairman', now()->addHours(6), function () {
            return ChairmanMessage::latest()->first();
        });

        $sponsors  = cache()->remember('sponsors', now()->addHours(6), function(){
            return Sponsor::orderBy('display_order')->orderBy('created_at', 'desc')->get();
        });

        $projects = cache()->remember('projects', now()->addHours(6), function () {
            return Projects::orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        });

        $latestNews = cache()->remember('latest_news_home', now()->addHours(6), function () {
            return News::query()
                ->where('status_id', config('constants.status.active'))
                ->orderBy('display_order')
                ->orderBy('created_at', 'desc')
                ->take(3)
                ->get();
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


        return view('livewire.site.show-home-page')->with(compact('testimonials', 'our_teams', 'our_values', 'home_intro', 'audioFiles', 'chairman', 'projects' , 'sponsors', 'latestNews', 'missionSliderImages'  ));
    }





}
