<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\WeeklyPrayerPoints;
use Livewire\Component;
use Livewire\WithPagination;

class ShowWeeklyPrayerPoints extends Component
{
    use WithPagination;

    public function render()
    {
        $dataset = WeeklyPrayerPoints::with('media')
            ->where('status_id', config('constants.status.active'))
            ->orderBy('post_date', 'desc')
            ->paginate(12);

        return view('livewire.site.show-prayer-points')->with(compact('dataset'));
    }
}
