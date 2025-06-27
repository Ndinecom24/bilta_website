<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

   <!-- Totals Cards -->
<div class="row">
    @foreach ([
        ['label' => 'Users', 'count' => $userCount, 'icon' => 'fas fa-users', 'color' => 'primary'],
        ['label' => 'Projects', 'count' => $projectCount, 'icon' => 'fas fa-project-diagram', 'color' => 'success'],
        ['label' => 'Testimonials', 'count' => $testimonialCount, 'icon' => 'fas fa-comments', 'color' => 'info'],
        ['label' => 'Messages', 'count' => $messageCount, 'icon' => 'fas fa-envelope', 'color' => 'warning'],
        ['label' => 'News', 'count' => $newsCount, 'icon' => 'fas fa-newspaper', 'color' => 'danger'],
    ] as $card)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-{{ $card['color'] }} shadow h-100 py-2">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-xs font-weight-bold text-{{ $card['color'] }} text-uppercase mb-1">
                            {{ $card['label'] }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $card['count'] }}</div>
                    </div>
                    <i class="{{ $card['icon'] }} fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

    
   <!-- News Graph -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">News Posts per Month</h6>
            </div>
            <div class="card-body">
                <div id="newsGraph" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>

    <!-- Chart -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Projects by Category</h6>
                </div>
                <div class="card-body">
                    <div id="projectChart" style="height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clicks Chart -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">URL Clicks: Today, This Week, This Month</h6>
            </div>
            <div class="card-body">
                <div id="clicksChart" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</div>


</div>

<!-- Highcharts Script -->
@push('scripts')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        Highcharts.chart('projectChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Projects Distribution by Category'
            },
            xAxis: {
                categories: {!! json_encode($chartLabels) !!},
                title: {
                    text: 'Category'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of Projects'
                }
            },
            series: [{
                name: 'Projects',
                data: {!! json_encode($chartData) !!}
            }],
            colors: ['#1cc88a']
        });
    });
</script>

<script>
    document.addEventListener('livewire:load', function () {
        Highcharts.chart('clicksChart', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Clicks per URL'
            },
            xAxis: {
                categories: {!! json_encode($clickChartUrls) !!},
                title: {
                    text: 'URLs'
                },
                labels: {
                    rotation: -45,
                    style: {
                        fontSize: '10px'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Click Count'
                }
            },
            tooltip: {
                shared: true
            },
            plotOptions: {
                column: {
                    grouping: true,
                    shadow: false
                }
            },
            series: [{
                name: 'Today',
                data: {!! json_encode($clicksToday) !!},
                color: '#4e73df'
            }, {
                name: 'This Week',
                data: {!! json_encode($clicksWeek) !!},
                color: '#1cc88a'
            }, {
                name: 'This Month',
                data: {!! json_encode($clicksMonth) !!},
                color: '#36b9cc'
            }]
        });
    });
</script>


<script>
    document.addEventListener('livewire:load', function () {
        Highcharts.chart('newsGraph', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'News Posts Over Time'
            },
            xAxis: {
                categories: {!! json_encode($newsChartLabels) !!},
                title: {
                    text: 'Month'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of News Posts'
                }
            },
            series: [{
                name: 'News',
                data: {!! json_encode($newsChartData) !!},
                color: '#f6c23e'
            }]
        });
    });
</script>



@endpush
