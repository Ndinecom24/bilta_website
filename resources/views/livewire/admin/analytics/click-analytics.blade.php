<style>
    .analytics-filter-card,
    .analytics-stat-card,
    .analytics-chart-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 10px 24px rgba(15, 23, 42, .05);
    }

    .analytics-filter-card { padding: .95rem; margin-bottom: 1rem; }
    .analytics-stat-card { padding: .9rem .95rem; height: 100%; }

    .analytics-stat-label {
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: .06em;
        font-size: .72rem;
        font-weight: 700;
        margin-bottom: .35rem;
    }

    .analytics-stat-count {
        color: #111147;
        font-size: 1.55rem;
        line-height: 1;
        font-weight: 800;
    }

    .analytics-chart-header {
        border-bottom: 1px solid #e2e8f0;
        padding: .85rem .95rem;
        font-size: .92rem;
        font-weight: 700;
        color: #111147;
    }

    .analytics-chart-body {
        padding: .6rem .75rem .9rem;
    }

    .analytics-insight-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: .85rem .95rem;
        margin-bottom: .75rem;
    }

    .analytics-insight-title {
        font-weight: 700;
        color: #111147;
        margin-bottom: .25rem;
    }

    .analytics-insight-meta {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        margin-bottom: .4rem;
    }

    .analytics-insight-meta.positive { color: #15803d; }
    .analytics-insight-meta.warning { color: #9a2804; }
    .analytics-insight-meta.neutral { color: #475569; }
</style>

<div>
    <h1 class="h3 mb-3 text-gray-800">Live Click Analytics</h1>

    <div class="analytics-filter-card">
        <div class="row">
            <div class="col-md-6 mb-2 mb-md-0">
                <label class="font-weight-bold" for="dateFrom">Date From</label>
                <input id="dateFrom" type="date" wire:model="dateFrom" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="font-weight-bold" for="dateTo">Date To</label>
                <input id="dateTo" type="date" wire:model="dateTo" class="form-control">
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ([
            ['label' => 'Total Clicks', 'count' => $totalClicks],
            ['label' => 'Today', 'count' => $clicksToday],
            ['label' => 'This Week', 'count' => $clicksThisWeek],
            ['label' => 'This Month', 'count' => $clicksThisMonth],
            ['label' => 'Unique Visitors', 'count' => $uniqueVisitors],
            ['label' => 'Avg Daily Clicks', 'count' => $avgDailyClicks],
            ['label' => 'Peak Day Clicks', 'count' => $peakDayClicks],
            ['label' => 'Top Page', 'count' => $topPageName],
        ] as $stat)
            <div class="col-md-3 mb-3">
                <div class="analytics-stat-card">
                    <div class="analytics-stat-label">{{ $stat['label'] }}</div>
                    <div class="analytics-stat-count">{{ $stat['count'] }}</div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Top URLs</div>
                <div class="analytics-chart-body"><div id="urlChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Daily Trend</div>
                <div class="analytics-chart-body"><div id="dailyTrendChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Clicks by Country</div>
                <div class="analytics-chart-body"><div id="countryChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Clicks by Browser</div>
                <div class="analytics-chart-body"><div id="browserChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Clicks by Platform</div>
                <div class="analytics-chart-body"><div id="platformChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Clicks by Device Type</div>
                <div class="analytics-chart-body"><div id="deviceTypeChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Top Cities</div>
                <div class="analytics-chart-body"><div id="cityChart" style="height: 320px;"></div></div>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">Top Referrers</div>
                <div class="analytics-chart-body"><div id="referrerChart" style="height: 320px;"></div></div>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="analytics-chart-card">
                <div class="analytics-chart-header">AI Insights</div>
                <div class="analytics-chart-body">
                    @if (!empty($aiInsights))
                        @foreach ($aiInsights as $insight)
                            <div class="analytics-insight-card">
                                <div class="analytics-insight-title">{{ $insight['title'] ?? 'Insight' }}</div>
                                <div class="analytics-insight-meta {{ $insight['type'] ?? 'neutral' }}">
                                    Confidence: {{ $insight['confidence'] ?? 'Medium' }}
                                </div>
                                <div class="mb-1">{{ $insight['summary'] ?? '' }}</div>
                                <small class="text-muted">Recommendation: {{ $insight['recommendation'] ?? '' }}</small>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">Not enough data to generate insights for the selected date range.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script>
            const initialAnalyticsPayload = {
                urlData: {
                    labels: @json(collect($topUrls)->pluck('url')->values()),
                    data: @json(collect($topUrls)->pluck('total')->map(fn($v) => (int) $v)->values())
                },
                countryData: @json(collect($clicksByCountry)->map(fn($item) => ['name' => $item['country'] ?? 'Unknown', 'y' => (int) ($item['total'] ?? 0)])->values()),
                browserData: @json(collect($clicksByBrowser)->map(fn($item) => ['name' => $item['browser'] ?? 'Unknown', 'y' => (int) ($item['total'] ?? 0)])->values()),
                platformData: @json(collect($clicksByPlatform)->map(fn($item) => ['name' => $item['platform'] ?? 'Unknown', 'y' => (int) ($item['total'] ?? 0)])->values()),
                deviceTypeData: @json(collect($clicksByDeviceType)->map(fn($item) => ['name' => $item['device_type'] ?? 'Unknown', 'y' => (int) ($item['total'] ?? 0)])->values()),
                cityData: {
                    labels: @json(collect($clicksByCity)->pluck('city')->values()),
                    data: @json(collect($clicksByCity)->pluck('total')->map(fn($v) => (int) $v)->values())
                },
                dailyTrendData: {
                    labels: @json(collect($dailyTrend)->pluck('day')->map(fn($d) => \Illuminate\Support\Carbon::parse($d)->format('M d'))->values()),
                    data: @json(collect($dailyTrend)->pluck('total')->map(fn($v) => (int) $v)->values())
                },
                referrerData: {
                    labels: @json(collect($topReferrers)->pluck('referrer')->map(fn($r) => \Illuminate\Support\Str::limit($r, 50, '...'))->values()),
                    data: @json(collect($topReferrers)->pluck('total')->map(fn($v) => (int) $v)->values())
                }
            };

            const drawAnalyticsCharts = (payload) => {
                if (!payload) return;

                Highcharts.setOptions({
                    credits: { enabled: false },
                    legend: { itemStyle: { fontWeight: '500' } },
                    tooltip: { shared: true }
                });

                const urlData = payload.urlData || { labels: [], data: [] };
                const countryData = payload.countryData || [];
                const browserData = payload.browserData || [];
                const platformData = payload.platformData || [];
                const deviceTypeData = payload.deviceTypeData || [];
                const cityData = payload.cityData || { labels: [], data: [] };
                const dailyTrendData = payload.dailyTrendData || { labels: [], data: [] };
                const referrerData = payload.referrerData || { labels: [], data: [] };

                Highcharts.chart('urlChart', {
                    chart: { type: 'bar' },
                    title: { text: null },
                    xAxis: { categories: urlData.labels },
                    yAxis: { title: { text: 'Clicks' } },
                    series: [{ name: 'Clicks', data: urlData.data, color: '#2563eb' }]
                });

                Highcharts.chart('dailyTrendChart', {
                    chart: { type: 'line' },
                    title: { text: null },
                    xAxis: { categories: dailyTrendData.labels },
                    yAxis: { title: { text: 'Clicks' } },
                    series: [{ name: 'Daily Clicks', data: dailyTrendData.data, color: '#0ea5e9' }]
                });

                Highcharts.chart('countryChart', {
                    chart: { type: 'pie' },
                    title: { text: null },
                    series: [{ name: 'Clicks', colorByPoint: true, data: countryData }]
                });

                Highcharts.chart('browserChart', {
                    chart: { type: 'pie' },
                    title: { text: null },
                    series: [{ name: 'Clicks', colorByPoint: true, data: browserData }]
                });

                Highcharts.chart('platformChart', {
                    chart: { type: 'pie' },
                    title: { text: null },
                    series: [{ name: 'Clicks', colorByPoint: true, data: platformData }]
                });

                Highcharts.chart('deviceTypeChart', {
                    chart: { type: 'pie' },
                    title: { text: null },
                    series: [{ name: 'Clicks', colorByPoint: true, data: deviceTypeData }]
                });

                Highcharts.chart('cityChart', {
                    chart: { type: 'column' },
                    title: { text: null },
                    xAxis: { categories: cityData.labels },
                    yAxis: { title: { text: 'Clicks' } },
                    series: [{ name: 'Clicks', data: cityData.data, color: '#f97316' }]
                });

                Highcharts.chart('referrerChart', {
                    chart: { type: 'bar' },
                    title: { text: null },
                    xAxis: { categories: referrerData.labels },
                    yAxis: { title: { text: 'Clicks' } },
                    series: [{ name: 'Clicks', data: referrerData.data, color: '#64748b' }]
                });
            };

            document.addEventListener('livewire:load', () => {
                drawAnalyticsCharts(initialAnalyticsPayload);
            });

            window.addEventListener('chartDataUpdated', (event) => {
                drawAnalyticsCharts((event && event.detail) ? event.detail : {});
            });
        </script>
    @endpush
</div>
