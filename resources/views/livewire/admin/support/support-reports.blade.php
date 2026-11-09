<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Support Reports</h1>
        <div>
            <a href="{{ route('admin.support.reports.export', $exportQuery + ['format' => 'xlsx']) }}" class="btn btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.support.reports.export', $exportQuery + ['format' => 'pdf']) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>

    {{-- Report type --}}
    <ul class="nav nav-pills mb-3">
        @foreach ($types as $key => $label)
            <li class="nav-item mb-1">
                <a href="#" class="nav-link py-1 {{ $type === $key ? 'active' : '' }}" wire:click.prevent="setType('{{ $key }}')">{{ $label }}</a>
            </li>
        @endforeach
    </ul>

    {{-- Filters --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body py-3">
            <div class="form-row align-items-end">
                @if ($type !== 'outstanding')
                    <div class="form-group col-lg-2 col-md-3 mb-2">
                        <label class="small mb-0">From</label>
                        <input type="date" class="form-control" wire:model="from">
                    </div>
                    <div class="form-group col-lg-2 col-md-3 mb-2">
                        <label class="small mb-0">To</label>
                        <input type="date" class="form-control" wire:model="to">
                    </div>
                @endif
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <label class="small mb-0">Category</label>
                    <select class="form-control" wire:model="category_id">
                        <option value="">All</option>
                        @foreach ($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <label class="small mb-0">Module</label>
                    <select class="form-control" wire:model="system_id">
                        <option value="">All</option>
                        @foreach ($systems as $s)<option value="{{ $s->id }}">{{ $s->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <label class="small mb-0">Priority</label>
                    <select class="form-control" wire:model="priority_id">
                        <option value="">All</option>
                        @foreach ($priorities as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <label class="small mb-0">Developer</label>
                    <select class="form-control" wire:model="developer_id">
                        <option value="">All</option>
                        @foreach ($developers as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
                    </select>
                </div>
            </div>
            @if ($type !== 'outstanding')
                <div class="small">
                    Quick range:
                    <a href="#" wire:click.prevent="thisMonth">This month</a> &middot;
                    <a href="#" wire:click.prevent="lastMonth">Last month</a> &middot;
                    <a href="#" wire:click.prevent="thisYear">This year</a>
                </div>
            @endif
        </div>
    </div>

    {{-- Totals --}}
    @if (count($report['totals']))
        <div class="row">
            @foreach ($report['totals'] as [$label, $value])
                <div class="col-xl-2 col-md-3 col-6 mb-3">
                    <div class="card border-left-primary shadow-sm h-100">
                        <div class="card-body py-2 px-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase">{{ $label }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ is_float($value) ? rtrim(rtrim(number_format($value, 2), '0'), '.') ?: '0' : $value }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Data --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between">
            <h6 class="mb-0 font-weight-bold">{{ $report['title'] }}</h6>
            <small class="text-muted">{{ $report['subtitle'][0] }}</small>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        @foreach ($report['columns'] as $i => $col)
                            <th class="{{ in_array($i, $report['numeric'], true) ? 'text-right' : '' }}">{{ $col }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse ($report['rows'] as $row)
                        <tr>
                            @foreach ($row as $i => $cell)
                                <td class="{{ in_array($i, $report['numeric'], true) ? 'text-right text-nowrap' : '' }}">
                                    @if ($i === 0 && is_string($cell) && str_starts_with($cell, config('support.reference_prefix', 'TKT') . '-'))
                                        <a href="{{ route('admin.support.all', ['search' => $cell]) }}">{{ $cell }}</a>
                                    @else
                                        {{ is_float($cell) ? rtrim(rtrim(number_format($cell, 2), '0'), '.') ?: '0' : \Illuminate\Support\Str::limit((string) $cell, 120) }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr><td colspan="{{ count($report['columns']) }}" class="text-center text-muted py-4">No data for the selected filters.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($totalRows > $limit)
            <div class="card-footer small text-muted">Showing the first {{ $limit }} of {{ $totalRows }} rows. Export to get everything.</div>
        @endif
    </div>
</div>
