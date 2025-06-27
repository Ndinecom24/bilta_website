<?php

namespace App\Http\Livewire\Admin\Company;

use App\Models\Bilta\HomeIntro;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\Bilta\Projects;
use App\Models\Bilta\Testimonial;
use App\Models\Bilta\News;
use App\Models\Bilta\Click;
use App\Models\ContactMessage;

class ShowAdminHome extends Component
{

    public $userCount, $projectCount, $testimonialCount, $messageCount, $newsCount;
    public $chartLabels = [], $chartData = [];

    public $clickChartUrls = [], $clicksToday = [], $clicksWeek = [], $clicksMonth = [];

    public $newsChartLabels = [], $newsChartData = [];

    public function mount()
    {
        $this->userCount = User::count();
        $this->projectCount = Projects::count();
        $this->testimonialCount = Testimonial::count();
        $this->messageCount = ContactMessage::count();
        $this->newsCount = News::count();

        // Project category chart
        $projectGroups = Projects::selectRaw('count(*) as total, category_id')
            ->groupBy('category_id')
            ->with('myCategory')
            ->get();

        foreach ($projectGroups as $group) {
            $this->chartLabels[] = $group->myCategory->name ?? 'Unknown';
            $this->chartData[] = $group->total;
        }

        // Clicks chart data
        $urls = Click::select('url')
            ->distinct()
            ->pluck('url');

        foreach ($urls as $url) {
            $this->clickChartUrls[] = $url;
            $this->clicksToday[] = Click::where('url', $url)->whereDate('created_at', now())->count();
            $this->clicksWeek[] = Click::where('url', $url)->whereBetween('created_at', [now()->startOfWeek(), now()])->count();
            $this->clicksMonth[] = Click::where('url', $url)->whereMonth('created_at', now()->month)->count();
        }

         // Group news by month
         $newsStats = News::select(
            \DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            \DB::raw("COUNT(*) as count")
        )
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

    foreach ($newsStats as $stat) {
        $this->newsChartLabels[] = \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->format('F Y');
        $this->newsChartData[] = $stat->count;
    }


    }



    public function render()
    {
       return view('livewire.admin.home-page.show-home');
    }


}
