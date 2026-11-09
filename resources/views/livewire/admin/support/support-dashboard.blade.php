<div>
    @php
        $fmt = function ($n) { return rtrim(rtrim(number_format((float) $n, 2), '0'), '.') ?: '0'; };
    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Support Dashboard</h1>
        @can('view-support-reports')
            <a href="{{ route('admin.support.reports') }}" class="btn btn-outline-primary"><i class="fas fa-chart-line"></i> Reports</a>
        @endcan
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="form-row align-items-end">
                <div class="form-group col-md-3 mb-2">
                    <label class="small mb-0">Tickets created</label>
                    <select class="form-control" wire:model="period">
                        <option value="7">Last 7 days</option>
                        <option value="30">Last 30 days</option>
                        <option value="90">Last 90 days</option>
                        <option value="year">This year</option>
                        <option value="all">All time</option>
                    </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <label class="small mb-0">Category</label>
                    <select class="form-control" wire:model="category_id">
                        <option value="">All categories</option>
                        @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group col-md-2 mb-2">
                    <label class="small mb-0">Priority</label>
                    <select class="form-control" wire:model="priority_id">
                        <option value="">All</option>
                        @foreach ($priorities as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <label class="small mb-0">Developer</label>
                    <select class="form-control" wire:model="developer_id">
                        <option value="">All developers</option>
                        <option value="none">Unassigned</option>
                        @foreach ($developers as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group col-md-1 mb-2">
                    <button class="btn btn-outline-secondary btn-block" wire:click="resetFilters" title="Reset filters"><i class="fas fa-undo"></i></button>
                </div>
            </div>
        </div>
    </div>

    {{-- Counters --}}
    @php
        $tiles = [
            ['Total tickets', $cards['total'], 'primary', 'fa-ticket-alt', ''],
            ['Unassigned', $cards['unassigned'], 'warning', 'fa-inbox', 'open & not assigned'],
            ['In progress', $cards['in_progress'], 'info', 'fa-spinner', 'acknowledged / assigned / working'],
            ['Awaiting feedback', $cards['awaiting'], 'dark', 'fa-question-circle', ''],
            ['On hold', $cards['on_hold'], 'secondary', 'fa-pause-circle', ''],
            ['Reopened', $cards['reopened'], 'danger', 'fa-undo', ''],
            ['Resolved', $cards['resolved'], 'success', 'fa-check-circle', 'awaiting confirmation'],
            ['Closed', $cards['closed'], 'secondary', 'fa-lock', ''],
            ['Overdue', $cards['overdue'], 'danger', 'fa-exclamation-triangle', 'past due date, still open'],
        ];
    @endphp
    <div class="row">
        @foreach ($tiles as [$label, $value, $color, $icon, $hint])
            <div class="col-xl-4 col-md-6 mb-3">
                <div class="card border-left-{{ $color }} shadow-sm h-100 py-2">
                    <div class="card-body py-2">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-{{ $color }} text-uppercase mb-1">{{ $label }}</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $value }}</div>
                                @if ($hint)<small class="text-muted">{{ $hint }}</small>@endif
                            </div>
                            <div class="col-auto"><i class="fas {{ $icon }} fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm h-100"><div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Avg. time to resolve</div>
                <div class="h5 mb-0 font-weight-bold">{{ $avgResolutionHours !== null ? ($avgResolutionHours >= 48 ? round($avgResolutionHours / 24, 1) . ' days' : $avgResolutionHours . ' hours') : '-' }}</div>
            </div></div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card shadow-sm h-100"><div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Resolved on time</div>
                <div class="h5 mb-0 font-weight-bold">{{ $onTimePct !== null ? $onTimePct . '%' : '-' }}</div>
                <small class="text-muted">within the due date</small>
            </div></div>
        </div>
        <div class="col-xl-6 mb-3">
            <div class="card shadow-sm h-100"><div class="card-body py-3">
                <div class="text-xs font-weight-bold text-uppercase mb-1">Hours (kept separate)</div>
                <div class="d-flex flex-wrap">
                    <div class="mr-4"><span class="h5 font-weight-bold">{{ $fmt($hours['estimated']) }}h</span><br><small class="text-muted">Estimated</small></div>
                    <div class="mr-4"><span class="h5 font-weight-bold">{{ $fmt($hours['actual']) }}h</span><br><small class="text-muted">Actual worked</small></div>
                    <div class="mr-4"><span class="h5 font-weight-bold">{{ $fmt($hours['billable']) }}h</span><br><small class="text-muted">Billable (approved)</small></div>
                    <div><span class="h5 font-weight-bold">{{ $fmt($hours['unreviewed']) }}h</span><br><small class="text-muted">Awaiting billing review</small></div>
                </div>
            </div></div>
        </div>
    </div>

    <div class="row">
        {{-- By priority --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><h6 class="mb-0 font-weight-bold">Open tickets by priority</h6></div>
                <div class="card-body">
                    @php $maxP = max(1, max(array_merge([0], array_values($priorityOpen)))); @endphp
                    @foreach ($priorities as $p)
                        @php $n = (int) ($priorityOpen[$p->id] ?? 0); @endphp
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small"><span>{{ $p->name }}</span><span class="font-weight-bold">{{ $n }}</span></div>
                            <div class="progress" style="height: 10px;"><div class="progress-bar bg-{{ $p->color }}" style="width: {{ round($n / $maxP * 100) }}%"></div></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- By category --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><h6 class="mb-0 font-weight-bold">Tickets by category</h6></div>
                <div class="card-body">
                    @php $maxC = max(1, max(array_merge([0], array_values($categoryAll)))); @endphp
                    @foreach ($categories as $c)
                        @php $n = (int) ($categoryAll[$c->id] ?? 0); $o = (int) ($categoryOpen[$c->id] ?? 0); @endphp
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small"><span>{{ $c->name }}</span><span><span class="font-weight-bold">{{ $n }}</span> <span class="text-muted">({{ $o }} open)</span></span></div>
                            <div class="progress" style="height: 10px;"><div class="progress-bar bg-primary" style="width: {{ round($n / $maxC * 100) }}%"></div></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- By module --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><h6 class="mb-0 font-weight-bold">Tickets by system / module</h6></div>
                <div class="card-body">
                    @php $maxS = max(1, max(array_merge([0], array_values($systemAll)))); @endphp
                    @foreach ($systems as $s)
                        @php $n = (int) ($systemAll[$s->id] ?? 0); $o = (int) ($systemOpen[$s->id] ?? 0); @endphp
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small"><span>{{ $s->name }}</span><span><span class="font-weight-bold">{{ $n }}</span> <span class="text-muted">({{ $o }} open)</span></span></div>
                            <div class="progress" style="height: 10px;"><div class="progress-bar bg-info" style="width: {{ round($n / $maxS * 100) }}%"></div></div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Developer workload --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><h6 class="mb-0 font-weight-bold">Developer workload</h6></div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="thead-light"><tr><th>Developer</th><th class="text-right">Open</th><th class="text-right">Overdue</th><th class="text-right">Resolved</th><th class="text-right">Hours logged</th></tr></thead>
                        <tbody>
                            @forelse ($workload as $row)
                                <tr>
                                    <td>{{ $row['name'] }}</td>
                                    <td class="text-right">{{ $row['open'] }}</td>
                                    <td class="text-right {{ $row['overdue'] ? 'text-danger font-weight-bold' : '' }}">{{ $row['overdue'] }}</td>
                                    <td class="text-right">{{ $row['resolved'] }}</td>
                                    <td class="text-right">{{ $fmt($row['hours']) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">No support developers yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Overdue --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header"><h6 class="mb-0 font-weight-bold text-danger"><i class="fas fa-exclamation-triangle mr-1"></i> Overdue tickets</h6></div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="thead-light"><tr><th>Reference</th><th>Subject</th><th>Priority</th><th>Assigned</th><th>Due</th></tr></thead>
                        <tbody>
                            @forelse ($overdueTickets as $t)
                                <tr>
                                    <td class="text-nowrap"><a href="{{ route('admin.support.show', $t->id) }}">{{ $t->reference }}</a></td>
                                    <td>{{ \Illuminate\Support\Str::limit($t->subject, 40) }}</td>
                                    <td><span class="badge bg-{{ $t->priority->color ?? 'secondary' }} text-white">{{ $t->priority->name ?? '-' }}</span></td>
                                    <td>{{ $t->assignee->name ?? 'Unassigned' }}</td>
                                    <td class="text-danger text-nowrap">{{ $t->due_date->format('d M') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-3">No overdue tickets.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
