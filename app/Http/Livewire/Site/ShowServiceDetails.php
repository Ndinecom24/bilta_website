<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\OurServices;
use Livewire\Component;

class ShowServiceDetails extends Component
{
    public $service;

    public function mount(OurServices $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $otherServices = OurServices::where('id', '!=', $this->service->id)
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.site.show-service-details', [
            'title' => $this->service->title,
            'otherServices' => $otherServices,
        ]);
    }
}
