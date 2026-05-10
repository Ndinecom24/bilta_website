<?php

namespace App\Http\Livewire\Site;

use Livewire\Component;

class ShowServices extends Component
{
    public function render()
    {
        return view('livewire.site.show-services', [
            'title' => 'Explore our core ministry services in translation, literacy, scripture access, and community engagement.',
        ]);
    }
}
