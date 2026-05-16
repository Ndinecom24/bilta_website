<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\Newsletter;
use Livewire\Component;
use Livewire\WithPagination;

class MyNewsletterList extends Component
{
    use WithPagination;

    public function render()
    {
        $newsletters = Newsletter::with('media')
            ->where('status_id', config('constants.status.active'))
            ->orderBy('publish_date', 'desc')
            ->orderBy('display_order')
            ->paginate(12);

        return view('livewire.site.show-newsletter-list', compact('newsletters'));
    }
}
