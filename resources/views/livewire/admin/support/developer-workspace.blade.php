<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Developer Workspace</h1>
        <a href="{{ route('admin.support.all') }}" class="btn btn-outline-secondary"><i class="fas fa-inbox"></i> All Tickets</a>
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body py-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Estimated hours (my open tickets)</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ rtrim(rtrim(number_format($workload['open_estimate'], 2), '0'), '.') ?: '0' }}h</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body py-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hours logged this week</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ rtrim(rtrim(number_format($workload['week_hours'], 2), '0'), '.') ?: '0' }}h</div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body py-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Resolved in last 30 days</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $workload['resolved_30d'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-3">
        @foreach ($tabs as $key => [$label, $icon])
            <li class="nav-item">
                <a href="#" class="nav-link {{ $tab === $key ? 'active' : '' }}" wire:click.prevent="setTab('{{ $key }}')">
                    <i class="fas {{ $icon }}"></i> {{ $label }}
                    <span class="badge bg-{{ $key === 'overdue' && $counts[$key] > 0 ? 'danger' : 'secondary' }} text-white">{{ $counts[$key] }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <div class="card shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Reference</th>
                        <th>Subject</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Submitted by</th>
                        <th>Due</th>
                        <th class="text-right">Est. / Logged</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td class="text-nowrap"><a href="{{ route('admin.support.show', $ticket->id) }}" class="font-weight-bold">{{ $ticket->reference }}</a></td>
                            <td style="min-width: 220px;">
                                <a href="{{ route('admin.support.show', $ticket->id) }}" class="text-dark">{{ \Illuminate\Support\Str::limit($ticket->subject, 70) }}</a>
                                <br><small class="text-muted">{{ $ticket->category->name ?? '-' }}@if ($ticket->system) &middot; {{ $ticket->system->name }}@endif</small>
                            </td>
                            <td><span class="badge bg-{{ $ticket->priority->color ?? 'secondary' }} text-white">{{ $ticket->priority->name ?? '-' }}</span></td>
                            <td><span class="badge bg-{{ $ticket->status_color }} text-white">{{ $ticket->status_label }}</span></td>
                            <td>{{ $ticket->submitter->name ?? '-' }}</td>
                            <td class="text-nowrap">
                                @if ($ticket->due_date)
                                    <span class="{{ $ticket->isOverdue() ? 'text-danger font-weight-bold' : '' }}">{{ $ticket->due_date->format('d M Y') }}</span>
                                @else - @endif
                            </td>
                            <td class="text-right text-nowrap small">
                                {{ $ticket->estimated_hours !== null ? rtrim(rtrim(number_format($ticket->estimated_hours, 2), '0'), '.') : '-' }}
                                /
                                {{ rtrim(rtrim(number_format((float) $ticket->logged_hours, 2), '0'), '.') ?: '0' }}h
                            </td>
                            <td class="text-right text-nowrap">
                                @if ($tab === 'unassigned')
                                    <button class="btn btn-sm btn-success" wire:click="accept({{ $ticket->id }})" wire:loading.attr="disabled">Accept</button>
                                @else
                                    <a href="{{ route('admin.support.show', $ticket->id) }}" class="btn btn-sm btn-outline-primary">Open</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="text-center text-muted py-5">Nothing here. Nice and tidy.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($tickets->hasPages())
            <div class="card-footer d-flex justify-content-center">{{ $tickets->links() }}</div>
        @endif
    </div>
</div>
