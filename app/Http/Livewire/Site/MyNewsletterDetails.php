<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\Newsletter;
use Livewire\Component;

class MyNewsletterDetails extends Component
{
    public $newsletterId;
    public $newsletter;

    public function mount($id)
    {
        $this->newsletterId = $id;
        $this->newsletter = Newsletter::where('id', $id)
            ->where('status_id', config('constants.status.active'))
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.site.show-newsletter-details');
    }
}
