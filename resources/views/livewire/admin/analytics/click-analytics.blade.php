<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Live Click Analytics</h1>

    <div class="row">
        <div class="col-md-6">
            <label>Date From:</label>
            <input type="date" wire:model="dateFrom" class="form-control mb-2">
        </div>
        <div class="col-md-6">
            <label>Date To:</label>
            <input type="date" wire:model="dateTo" class="form-control mb-2">
        </div>
    </div>

    <div class="row">
        @foreach ([
            ['label' => 'Total Clicks', 'count' => $totalClicks, 'color' => 'primary'],
            ['label' => 'Today', 'count' => $clicksToday, 'color' => 'success'],
            ['label' => 'This Week', 'count' => $clicksThisWeek, 'color' => 'info'],
            ['label' => 'This Month', 'count' => $clicksThisMonth, 'color' => 'warning'],
        ] as $stat)
            <div class="col-md-3 mb-4">
                <div class="card border-left-{{ $stat['color'] }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="text-xs font-weight-bold text-{{ $stat['color'] }} text-uppercase mb-1">
                            {{ $stat['label'] }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $stat['count'] }}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Top URLs</div>
                <div class="card-body">
                    <div id="urlChart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Clicks by Country</div>
                <div class="card-body">
                    <div id="countryChart"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script>
            document.addEventListener('livewire:load', function () {
                window.livewire.on('chartDataUpdated', (urlData, countryData) => {
                    Highcharts.chart('urlChart', {
                        chart: { type: 'bar' },
                        title: { text: 'Top Visited URLs' },
                        xAxis: { categories: urlData.labels },
                        yAxis: { title: { text: 'Clicks' } },
                        series: [{ name: 'Clicks', data: urlData.data }]
                    });

                    Highcharts.chart('countryChart', {
                        chart: { type: 'pie' },
                        title: { text: 'Clicks by Country' },
                        series: [{
                            name: 'Clicks',
                            colorByPoint: true,
                            data: countryData
                        }]
                    });
                });
            });
        </script>
    @endpush
</div>
