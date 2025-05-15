<?php

namespace App\Http\Livewire\Site\Company;

use App\Models\Bilta\AboutUs;
use App\Models\Bilta\ContactUs;
use Livewire\Component;

class ShowAbout extends Component
{
    public function render()
    {
        $about_us_details = cache()->remember('about_us_details', now()->addHours(6), function () {
            return AboutUs::first();
        });

        $contact_us_details = cache()->remember('contact_us_details', now()->addHours(6), function () {
            return ContactUs::first();
        });

        return view('livewire.site.show-about')->with(compact('about_us_details', 'contact_us_details' )) ;
    }
}
