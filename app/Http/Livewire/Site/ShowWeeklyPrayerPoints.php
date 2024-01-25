<?php

namespace App\Http\Livewire\Site;

use App\Models\Bilta\WeeklyPrayerPoints;
use Livewire\Component;

class ShowWeeklyPrayerPoints extends Component
{
    public $start_date, $end_date ;
    public function render()
    {
        $dataset = WeeklyPrayerPoints::select('status_id','post_date', 'details', 'title', 'scriptures', 'created_by')
            ->where('status_id', config('constants.status.active'))
            ->paginate(20);

        return view('livewire.show-weekly-prayer-points')->with(compact('dataset'));
    }

    public function search(){

    }
}
