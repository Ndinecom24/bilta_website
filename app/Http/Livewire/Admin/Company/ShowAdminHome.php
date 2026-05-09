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
use Illuminate\Support\Facades\DB;

class ShowAdminHome extends Component
{

    public $userCount, $projectCount, $testimonialCount, $messageCount, $newsCount;
    public $chartLabels = [], $chartData = [];

    public $clickChartUrls = [], $clicksToday = [], $clicksWeek = [], $clicksMonth = [];

    public $newsChartLabels = [], $newsChartData = [];
    public $topClickedUrls = [];
    public $recentNews = [];
    public $recentMessages = [];
    public $clickTrendLabels = [], $clickTrendData = [];

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

        // Clicks chart data (top 10 URLs by total clicks)
        $urls = Click::select('url', DB::raw('count(*) as total'))
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        foreach ($urls as $row) {
            $url = $row->url;
            $this->clickChartUrls[] = $url;
            $this->clicksToday[] = Click::where('url', $url)->whereDate('created_at', now())->count();
            $this->clicksWeek[] = Click::where('url', $url)->whereBetween('created_at', [now()->startOfWeek(), now()])->count();
            $this->clicksMonth[] = Click::where('url', $url)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->count();
        }

        // Group news by month
        $newsStats = News::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
            DB::raw("COUNT(*) as count")
        )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        foreach ($newsStats as $stat) {
            $this->newsChartLabels[] = \Carbon\Carbon::createFromFormat('Y-m', $stat->month)->format('F Y');
            $this->newsChartData[] = $stat->count;
        }

        // Top clicked URLs table
        $this->topClickedUrls = Click::select('url', DB::raw('count(*) as total'))
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // Recent records
        $this->recentNews = News::select('id', 'title', 'author', 'created_at')
            ->latest()
            ->limit(6)
            ->get();

        $this->recentMessages = ContactMessage::select('id', 'name', 'email', 'subject', 'created_at')
            ->latest()
            ->limit(6)
            ->get();

        // Click trend (last 14 days)
        $trend = Click::select(DB::raw('DATE(created_at) as day'), DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', now()->subDays(13))
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $trendMap = $trend->keyBy('day');
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->toDateString();
            $this->clickTrendLabels[] = now()->subDays($i)->format('M d');
            $this->clickTrendData[] = (int) ($trendMap[$day]->total ?? 0);
        }


    }



    public function render()
    {
       return view('livewire.admin.home-page.show-home');
    }


}
