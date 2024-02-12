<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\Videos;
use Livewire\Component;

class ShowVideos extends Component
{
    public function render()
    {
        $video_items = Videos::get();
        $categories= $video_items->pluck('category')->unique() ;
        return view('livewire.site.show-videos')->with(compact('video_items', 'categories'));
    }
}
