<?php

namespace App\Http\Livewire\Admin\PrayerPointsPage;

use App\Models\Bilta\WeeklyPrayerPoints;
use App\Models\System\Status;
use Livewire\Component;
use Livewire\WithPagination;

class ShowPrayerPoints extends Component
{


    use WithPagination;

    public $weekly_prayer_point_id, $details, $title, $status_id , $post_date, $scriptures, $year, $month, $week, $day;

    public $updateWeeklyPrayerPoint = false;
    protected $listeners = [
        'deleteFAQ' => 'destroy'
    ];
    // Validation Rules
    protected $rules = [
        'title' => 'required',
        'details' => 'required',
        'status_id' => 'required',
        'post_date' => 'required',
        'scriptures' => 'required',
    ];

    public function render()
    {
        $statuses = Status::all();
        $weekly_prayer_points = WeeklyPrayerPoints::select('id', 'title', 'details', 'status_id', 'post_date','scriptures', 'created_by', 'year', 'month', 'week', 'day')->paginate(20);
        return view('livewire.admin.prayer-points-page.index')->with(compact('weekly_prayer_points', 'statuses'));
    }

    public function resetFields()
    {
        $this->title = '';
        $this->details = '';
        $this->status_id = '';
        $this->post_date = '';
        $this->scriptures = '';
    }

    public function store()
    {
        $date = date_parse_from_format('Y-m-d', $this->post_date);

       // $date_info = $date ;
//        if ($date_info['error_count'] === 0 && $date_info['warning_count'] === 0) {
//            $week_number = date('W', mktime(0, 0, 0, $date_info['month'], $date_info['day'], $date_info['year']));
//        } else {
//            $week_number = 0 ;
//        }
//        dd([  date("W", strtotime($this->post_date )) , $week_number]);


        // Validate Form Request
        $this->validate();
        try {
            // Create WeeklyPrayerPoint
            WeeklyPrayerPoints::updateOrCreate([
                'title' => $this->title,
                'details' => $this->details,
                'post_date' => $this->post_date,
                'scriptures' => $this->scriptures,
            ],
                [
                    'title' => $this->title,
                    'details' => $this->details,
                    'post_date' => $this->post_date,
                    'scriptures' => $this->scriptures,
                    'status_id' => $this->status_id,
                    'created_by' => auth()->user()->id ,
                    'year'=> $date['year'],
                    'month' => $date['month'],
                    'week' =>  date("W", strtotime($this->post_date ))  ,
                    'day' => $date['day'],
                ]

            );

            // Set Flash Message
            session()->flash('success', 'WeeklyPrayerPoint Created Successfully!!');
            // Reset Form Fields After Creating WeeklyPrayerPoint
            $this->resetFields();

        } catch (\Exception $e) {

            // Set Flash Message
            session()->flash('error', 'Something goes wrong while creating about us!!' . $e->getMessage());
            // Reset Form Fields After Creating WeeklyPrayerPoint
            $this->resetFields();
        }
    }

    public function edit($id)
    {
        $weekly_prayer_point = WeeklyPrayerPoints::findOrFail($id);
        $this->title = $weekly_prayer_point->title;
        $this->details = $weekly_prayer_point->details;
        $this->post_date = $weekly_prayer_point->post_date;
        $this->scriptures = $weekly_prayer_point->scriptures;
        $this->status_id = $weekly_prayer_point->status_id;
        $this->year = $weekly_prayer_point->year;
        $this->month = $weekly_prayer_point->month;
        $this->week = $weekly_prayer_point->week;
        $this->day = $weekly_prayer_point->day;
        $this->weekly_prayer_point_id = $weekly_prayer_point->id;
        $this->updateWeeklyPrayerPoint = true;
    }

    public function cancel()
    {
        $this->updateWeeklyPrayerPoint = false;
        $this->resetFields();
    }

    public function update()
    {
        // Validate request
        $this->validate();
        try {
            $date = date_parse_from_format('Y-m-d W', $this->post_date);
            // Update weekly_prayer_point
            WeeklyPrayerPoints::find($this->weekly_prayer_point_id)->fill([
                'title' => $this->title,
                'details' => $this->details,
                'post_date' => $this->post_date,
                'scriptures' => $this->scriptures,
                'status_id' => $this->status_id,
                'created_by' => auth()->user()->id,
                'year'=> $date['year'],
                'month' => $date['month'],
                'week' =>  date("W", strtotime($this->post_date )) ,
                'day' => $date['day'],
            ])->save();
            session()->flash('success', 'Weekly Prayer Point Updated Successfully!!');

            $this->cancel();
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong while updating weekly prayer point!!');
            $this->cancel();
        }
    }

    public function destroy($id)
    {
        try {
            WeeklyPrayerPoints::find($id)->delete();
            session()->flash('success', "Weekly Prayer Point Deleted Successfully!!");
        } catch (\Exception $e) {
            session()->flash('error', "Something goes wrong while deleting weekly prayer point!!");
        }
    }

}
