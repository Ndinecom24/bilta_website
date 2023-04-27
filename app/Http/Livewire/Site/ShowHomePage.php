<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\AboutUs;
use App\Models\Bilta\ContactUs;
use Livewire\Component;

class ShowHomePage extends Component
{
    public function render()
    {
        return view('livewire.site.show-home-page');
    }
}
