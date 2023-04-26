<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AboutUs;
use Livewire\Component;

class ShowHomePage extends Component
{
    public function render()
    {
        $about_us = AboutUs::first();
        return view('livewire.site.show-home-page')->with(compact('about_us'));
    }
}
