<?php

namespace App\Http\Livewire\Admin\Analytics;

use Livewire\Component;


use App\Models\Bilta\Click;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ClickAnalytics extends Component
{
    public $totalClicks;
    public $clicksToday;
    public $clicksThisWeek;
    public $clicksThisMonth;
    public $uniqueVisitors;
    public $avgDailyClicks;
    public $topPageName;
    public $peakDayClicks;

    public $topUrls = [];
    public $clicksByCountry = [];
    public $clicksByBrowser = [];
    public $clicksByPlatform = [];
    public $topReferrers = [];
    public $topPages = [];
    public $clicksByDeviceType = [];
    public $clicksByCity = [];
    public $dailyTrend = [];
    public $aiInsights = [];



    public $dateFrom;
    public $dateTo;

    public function mount()
    {
        $this->dateFrom = Carbon::now()->subMonth()->toDateString();
        $this->dateTo = Carbon::now()->toDateString();
        $this->loadStats();
    }

    public function updatedDateFrom()
    {
        $this->loadStats();
    }

    public function updatedDateTo()
    {
        $this->loadStats();
    }

    private function filteredQuery()
    {
        return Click::query()
            ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
            ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo));
    }

    public function loadStats()
    {
        if ($this->dateFrom && $this->dateTo && Carbon::parse($this->dateFrom)->gt(Carbon::parse($this->dateTo))) {
            [$this->dateFrom, $this->dateTo] = [$this->dateTo, $this->dateFrom];
        }

        $query = $this->filteredQuery();

        $this->totalClicks = (clone $query)->count();
        $this->clicksToday = (clone $query)->whereDate('created_at', Carbon::today())->count();
        $this->clicksThisWeek = (clone $query)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
        $this->clicksThisMonth = (clone $query)->whereMonth('created_at', Carbon::now()->month)->count();
        $this->uniqueVisitors = (clone $query)->distinct('ip_address')->count('ip_address');

        $dailyTrend = (clone $query)
            ->selectRaw('DATE(created_at) as day, count(*) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $this->avgDailyClicks = $dailyTrend->count() ? round($dailyTrend->avg('total'), 1) : 0;
        $this->peakDayClicks = $dailyTrend->max('total') ?? 0;

        $topPages = (clone $query)
            ->selectRaw("COALESCE(NULLIF(page_name, ''), 'Unknown') as page_name, count(*) as total")
            ->groupBy('page_name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topUrls = (clone $query)
            ->select('url', DB::raw('count(*) as total'))
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topReferrers = (clone $query)
            ->selectRaw("COALESCE(NULLIF(referrer, ''), 'Direct/Unknown') as referrer, count(*) as total")
            ->groupBy('referrer')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $clicksByCountry = (clone $query)
            ->selectRaw("COALESCE(NULLIF(country, ''), 'Unknown') as country, count(*) as total")
            ->groupBy('country')
            ->orderByDesc('total')
            ->get();

        $clicksByBrowser = (clone $query)
            ->selectRaw("COALESCE(NULLIF(browser, ''), 'Unknown') as browser, count(*) as total")
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        $clicksByPlatform = (clone $query)
            ->selectRaw("COALESCE(NULLIF(platform, ''), 'Unknown') as platform, count(*) as total")
            ->groupBy('platform')
            ->orderByDesc('total')
            ->get();

        $clicksByDeviceType = (clone $query)
            ->selectRaw("COALESCE(NULLIF(device_type, ''), 'Unknown') as device_type, count(*) as total")
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        $clicksByCity = (clone $query)
            ->selectRaw("COALESCE(NULLIF(city, ''), 'Unknown') as city, count(*) as total")
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $this->topUrls = $topUrls->toArray();
        $this->topReferrers = $topReferrers->toArray();
        $this->topPages = $topPages->toArray();
        $this->clicksByCountry = $clicksByCountry->toArray();
        $this->clicksByBrowser = $clicksByBrowser->toArray();
        $this->clicksByPlatform = $clicksByPlatform->toArray();
        $this->clicksByDeviceType = $clicksByDeviceType->toArray();
        $this->clicksByCity = $clicksByCity->toArray();
        $this->dailyTrend = $dailyTrend->toArray();
        $this->topPageName = optional($topPages->first())->page_name ?? 'N/A';

        $this->aiInsights = $this->generateAiInsights(
            $dailyTrend,
            $topReferrers,
            $clicksByDeviceType,
            $clicksByCountry,
            $topPages
        );

        $this->dispatchBrowserEvent('chartDataUpdated', [
            'urlData' => [
                'labels' => $topUrls->pluck('url'),
                'data' => $topUrls->pluck('total'),
            ],
            'countryData' => $clicksByCountry->map(fn($item) => [
                'name' => $item->country,
                'y' => $item->total,
            ]),
            'browserData' => $clicksByBrowser->map(fn($item) => [
                'name' => $item->browser,
                'y' => $item->total,
            ]),
            'platformData' => $clicksByPlatform->map(fn($item) => [
                'name' => $item->platform,
                'y' => $item->total,
            ]),
            'deviceTypeData' => $clicksByDeviceType->map(fn($item) => [
                'name' => $item->device_type,
                'y' => $item->total,
            ]),
            'cityData' => [
                'labels' => $clicksByCity->pluck('city'),
                'data' => $clicksByCity->pluck('total'),
            ],
            'dailyTrendData' => [
                'labels' => $dailyTrend->pluck('day')->map(fn($d) => Carbon::parse($d)->format('M d')),
                'data' => $dailyTrend->pluck('total'),
            ],
            'referrerData' => [
                'labels' => $topReferrers->pluck('referrer')->map(fn($r) => mb_strimwidth($r, 0, 50, '...')),
                'data' => $topReferrers->pluck('total'),
            ],
        ]);
    }

    private function generateAiInsights($dailyTrend, $topReferrers, $clicksByDeviceType, $clicksByCountry, $topPages)
    {
        $insights = [];

        $trendValues = $dailyTrend->pluck('total')->values();
        $firstHalfAvg = $trendValues->count() > 1
            ? round($trendValues->slice(0, (int) ceil($trendValues->count() / 2))->avg(), 2)
            : 0;
        $secondHalfAvg = $trendValues->count() > 1
            ? round($trendValues->slice((int) ceil($trendValues->count() / 2))->avg(), 2)
            : 0;

        if ($firstHalfAvg > 0 || $secondHalfAvg > 0) {
            $delta = $secondHalfAvg - $firstHalfAvg;
            $pct = $firstHalfAvg > 0 ? round(($delta / $firstHalfAvg) * 100, 1) : 0;

            $insights[] = [
                'type' => $delta >= 0 ? 'positive' : 'warning',
                'title' => 'Traffic Momentum',
                'summary' => $delta >= 0
                    ? "Clicks are trending up by {$pct}% in the most recent half of the selected period."
                    : "Clicks are trending down by " . abs($pct) . "% in the most recent half of the selected period.",
                'confidence' => $trendValues->count() >= 7 ? 'High' : 'Medium',
                'recommendation' => $delta >= 0
                    ? 'Replicate channels and pages driving recent growth to sustain momentum.'
                    : 'Investigate recent content/channel changes and refresh top-performing pages.',
            ];
        }

        $topReferrer = $topReferrers->first();
        if ($topReferrer) {
            $share = $this->totalClicks > 0 ? round(($topReferrer->total / $this->totalClicks) * 100, 1) : 0;
            $insights[] = [
                'type' => $share >= 50 ? 'warning' : 'neutral',
                'title' => 'Acquisition Concentration',
                'summary' => "Top referrer contributes {$share}% of clicks ({$topReferrer->referrer}).",
                'confidence' => $this->totalClicks >= 100 ? 'High' : 'Medium',
                'recommendation' => $share >= 50
                    ? 'Diversify acquisition by strengthening SEO, social, and direct traffic campaigns.'
                    : 'Current referrer mix is balanced; continue optimizing top referrers.',
            ];
        }

        $topDevice = $clicksByDeviceType->first();
        if ($topDevice) {
            $deviceShare = $this->totalClicks > 0 ? round(($topDevice->total / $this->totalClicks) * 100, 1) : 0;
            $insights[] = [
                'type' => 'neutral',
                'title' => 'Primary Device Pattern',
                'summary' => "{$topDevice->device_type} accounts for {$deviceShare}% of total clicks.",
                'confidence' => 'Medium',
                'recommendation' => 'Prioritize UX and performance testing on this dominant device segment first.',
            ];
        }

        $topCountry = $clicksByCountry->first();
        if ($topCountry) {
            $countryShare = $this->totalClicks > 0 ? round(($topCountry->total / $this->totalClicks) * 100, 1) : 0;
            $insights[] = [
                'type' => 'neutral',
                'title' => 'Geographic Opportunity',
                'summary' => "Top country ({$topCountry->country}) contributes {$countryShare}% of clicks.",
                'confidence' => 'Medium',
                'recommendation' => 'Tailor campaigns, language, and posting time for the leading region.',
            ];
        }

        $topPage = $topPages->first();
        if ($topPage) {
            $pageShare = $this->totalClicks > 0 ? round(($topPage->total / $this->totalClicks) * 100, 1) : 0;
            $insights[] = [
                'type' => $pageShare >= 40 ? 'warning' : 'positive',
                'title' => 'Content Performance',
                'summary' => "Top page ({$topPage->page_name}) captures {$pageShare}% of clicks.",
                'confidence' => 'High',
                'recommendation' => $pageShare >= 40
                    ? 'Add internal links and stronger CTAs on this page to distribute traffic to priority pages.'
                    : 'Promote the top page as an entry point and replicate its structure in other content.',
            ];
        }

        return collect($insights)->take(5)->values()->toArray();
    }




    public function render()
    {
        return view('livewire.admin.analytics.click-analytics');
    }
}
