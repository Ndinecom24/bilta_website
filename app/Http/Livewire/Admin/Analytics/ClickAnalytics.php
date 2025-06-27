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

    public $topUrls = [];
    public $clicksByCountry = [];
    public $clicksByBrowser = [];
    public $clicksByPlatform = [];


    public $dateFrom;
public $dateTo;

public function mount()
{
    $this->dateFrom = Carbon::now()->subMonth()->toDateString();
    $this->dateTo = Carbon::now()->toDateString();
    $this->loadStats();
}

public function updatedDateFrom() { $this->loadStats(); }
public function updatedDateTo() { $this->loadStats(); }

public function loadStats()
{
    $query = Click::query()
        ->when($this->dateFrom, fn($q) => $q->whereDate('created_at', '>=', $this->dateFrom))
        ->when($this->dateTo, fn($q) => $q->whereDate('created_at', '<=', $this->dateTo));

    $this->totalClicks = $query->count();
    $this->clicksToday = Click::whereDate('created_at', Carbon::today())->count();
    $this->clicksThisWeek = Click::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()])->count();
    $this->clicksThisMonth = Click::whereMonth('created_at', Carbon::now()->month)->count();

    $topUrls = $query->select('url', DB::raw('count(*) as total'))
        ->groupBy('url')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    $clicksByCountry = $query->select('country', DB::raw('count(*) as total'))
        ->groupBy('country')
        ->orderByDesc('total')
        ->get();

    $this->dispatchBrowserEvent('chartDataUpdated', [
        'labels' => $topUrls->pluck('url'),
        'data' => $topUrls->pluck('total'),
    ], $clicksByCountry->map(fn($item) => [
        'name' => $item->country ?? 'Unknown',
        'y' => $item->total
    ]));
}




    public function render()
    {
        return view('livewire.admin.analytics.click-analytics');
    }
}
