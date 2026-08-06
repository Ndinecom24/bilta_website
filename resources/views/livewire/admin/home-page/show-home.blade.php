<div>
<style>
.dashboard-hero {
    background: linear-gradient(135deg, #0c2340 0%, #0d3b66 40%, #155d8a 100%);
    border-radius: 16px;
    color: #fff;
    padding: 1.4rem 1.5rem;
    margin-bottom: 1rem;
    box-shadow: 0 14px 28px rgba(12, 35, 64, 0.22);
    position: relative;
    overflow: hidden;
}

    .dashboard-hero::before {
        content: '';
        position: absolute;
        width: 220px;
        height: 220px;
        background: radial-gradient(circle, rgba(205,91,19,0.18) 0%, transparent 70%);
        border-radius: 50%;
        top: -80px;
        right: -40px;
        pointer-events: none;
    }

    .dashboard-hero::after {
        content: '';
        position: absolute;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 70%);
        border-radius: 50%;
        bottom: -50px;
        left: 30px;
        pointer-events: none;
    }

    .dashboard-hero-title {
        font-size: 1.45rem;
        font-weight: 800;
        margin-bottom: .15rem;
        position: relative;
        z-index: 1;
    }

    .dashboard-hero-subtitle {
        color: #94a3b8;
        font-size: .92rem;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }

    .dashboard-stat-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: .9rem .95rem;
        height: 100%;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, .08);
    }

    .dashboard-stat-label {
        font-size: .74rem;
        letter-spacing: .06em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: .35rem;
        font-weight: 700;
    }

    .dashboard-stat-count {
        font-size: 1.55rem;
        font-weight: 800;
        color: #111147;
        line-height: 1;
    }

    .dashboard-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .dashboard-stat-icon.users { background: #eff6ff; color: #2563eb; }
    .dashboard-stat-icon.projects { background: #ecfdf5; color: #059669; }
    .dashboard-stat-icon.testimonials { background: #ecfeff; color: #0891b2; }
    .dashboard-stat-icon.messages { background: #fff3eb; color: #cd5b13; }
    .dashboard-stat-icon.news { background: #fef2f2; color: #dc2626; }

    .dashboard-chart-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
        margin-bottom: 1rem;
    }

    .dashboard-chart-header {
        border-bottom: 1px solid #e2e8f0;
        padding: .9rem 1rem;
    }

    .dashboard-chart-title {
        margin: 0;
        font-size: .95rem;
        font-weight: 700;
        color: #111147;
    }

    .dashboard-chart-body {
        padding: .65rem .8rem .95rem;
    }
</style>

    <div class="dashboard-hero">
        <div class="dashboard-hero-title">Dashboard Overview</div>
        <p class="dashboard-hero-subtitle">Monitor content performance, engagement trends, and latest activity at a glance.</p>
    </div>

    <div class="row mb-2">
        @foreach ([
            ['label' => 'Users', 'count' => $userCount, 'icon' => 'fas fa-users', 'class' => 'users'],
            ['label' => 'Projects', 'count' => $projectCount, 'icon' => 'fas fa-project-diagram', 'class' => 'projects'],
            ['label' => 'Testimonials', 'count' => $testimonialCount, 'icon' => 'fas fa-comments', 'class' => 'testimonials'],
            ['label' => 'Messages', 'count' => $messageCount, 'icon' => 'fas fa-envelope', 'class' => 'messages'],
            ['label' => 'News', 'count' => $newsCount, 'icon' => 'fas fa-newspaper', 'class' => 'news'],
        ] as $card)
            <div class="col-xl col-lg-4 col-md-6 mb-3">
                <div class="dashboard-stat-card d-flex align-items-center justify-content-between">
                    <div>
                        <div class="dashboard-stat-label">{{ $card['label'] }}</div>
                        <div class="dashboard-stat-count">{{ $card['count'] }}</div>
                    </div>
                    <div class="dashboard-stat-icon {{ $card['class'] }}">
                        <i class="{{ $card['icon'] }}"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Announcements Dashboard Widget --}}
    <div class="row mb-2">
        <div class="col-lg-12">
            @livewire('admin.announcements-page.announcement-widget')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="dashboard-chart-card">
                <div class="dashboard-chart-header">
                    <h6 class="dashboard-chart-title">Click Trend (Last 14 Days)</h6>
                </div>
                <div class="dashboard-chart-body">
                    <div id="clickTrendChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="dashboard-chart-card h-100">
                <div class="dashboard-chart-header">
                    <h6 class="dashboard-chart-title">Top Clicked URLs</h6>
                </div>
                <div class="dashboard-chart-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>URL</th>
                                    <th class="text-right">Clicks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($topClickedUrls as $item)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::limit($item->url, 55) }}</td>
                                        <td class="text-right">{{ $item->total }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-muted text-center">No click data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="dashboard-chart-card">
                <div class="dashboard-chart-header">
                    <h6 class="dashboard-chart-title">Projects by Category</h6>
                </div>
                <div class="dashboard-chart-body">
                    <div id="projectChart" style="height: 330px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="dashboard-chart-card">
                <div class="dashboard-chart-header">
                    <h6 class="dashboard-chart-title">News Posts Per Month</h6>
                </div>
                <div class="dashboard-chart-body">
                    <div id="newsGraph" style="height: 330px;"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-chart-card mb-3">
        <div class="dashboard-chart-header">
            <h6 class="dashboard-chart-title">URL Clicks (Today / Week / Month)</h6>
        </div>
        <div class="dashboard-chart-body">
            <div id="clicksChart" style="height: 380px;"></div>
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-lg-6 mb-3">
            <div class="dashboard-chart-card h-100">
                <div class="dashboard-chart-header">
                    <h6 class="dashboard-chart-title">Recent News</h6>
                </div>
                <div class="dashboard-chart-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentNews as $item)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::limit($item->title, 45) }}</td>
                                        <td>{{ $item->author }}</td>
                                        <td>{{ optional($item->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted text-center">No recent news.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-3">
            <div class="dashboard-chart-card h-100">
                <div class="dashboard-chart-header">
                    <h6 class="dashboard-chart-title">Recent Contact Messages</h6>
                </div>
                <div class="dashboard-chart-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentMessages as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($item->subject, 35) }}</td>
                                        <td>{{ optional($item->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-muted text-center">No recent messages.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('custom-scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        Highcharts.chart('projectChart', {
            chart: { type: 'column' },
            title: { text: null },
            credits: { enabled: false },
            xAxis: { categories: {!! json_encode($chartLabels) !!} },
            yAxis: { min: 0, title: { text: 'Projects' } },
            series: [{ name: 'Projects', data: {!! json_encode($chartData) !!}, color: '#0ea5e9' }]
        });

        Highcharts.chart('clicksChart', {
            chart: { type: 'column' },
            title: { text: null },
            credits: { enabled: false },
            xAxis: {
                categories: {!! json_encode($clickChartUrls) !!},
                labels: { rotation: -45, style: { fontSize: '10px' } }
            },
            yAxis: { min: 0, title: { text: 'Click Count' } },
            tooltip: { shared: true },
            plotOptions: { column: { grouping: true, shadow: false } },
            series: [
                { name: 'Today', data: {!! json_encode($clicksToday) !!}, color: '#2563eb' },
                { name: 'This Week', data: {!! json_encode($clicksWeek) !!}, color: '#059669' },
                { name: 'This Month', data: {!! json_encode($clicksMonth) !!}, color: '#cd5b13' }
            ]
        });

        Highcharts.chart('newsGraph', {
            chart: { type: 'line' },
            title: { text: null },
            credits: { enabled: false },
            xAxis: { categories: {!! json_encode($newsChartLabels) !!} },
            yAxis: { min: 0, title: { text: 'News Posts' } },
            series: [{ name: 'News', data: {!! json_encode($newsChartData) !!}, color: '#cd5b13' }]
        });

        Highcharts.chart('clickTrendChart', {
            chart: { type: 'areaspline' },
            title: { text: null },
            credits: { enabled: false },
            xAxis: { categories: {!! json_encode($clickTrendLabels) !!} },
            yAxis: { min: 0, title: { text: 'Clicks' } },
            series: [{ name: 'Daily Clicks', data: {!! json_encode($clickTrendData) !!}, color: '#1d4ed8' }]
        });
    });
</script>
@endpush
</div>
