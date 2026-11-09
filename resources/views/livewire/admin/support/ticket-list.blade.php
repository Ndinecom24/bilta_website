<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $mode === 'mine' ? 'My Support Tickets' : 'All Support Tickets' }}</h1>
        @can('submit-support-tickets')
            <a href="{{ route('admin.support.submit') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Ticket
            </a>
        @endcan
    </div>

    @if (session()->has('success'))
        <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
    @endif

    {{-- Summary --}}
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body py-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Open</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['open'] }}</div>
                    <small class="text-muted">of {{ $summary['total'] }} tickets</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body py-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Awaiting feedback</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['awaiting'] }}</div>
                    <small class="text-muted">{{ $mode === 'mine' ? 'Waiting for your reply' : 'Waiting for submitters' }}</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body py-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Resolved</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['resolved'] }}</div>
                    <small class="text-muted">Awaiting confirmation</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-secondary shadow-sm h-100 py-2">
                <div class="card-body py-2">
                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Closed</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $summary['closed'] }}</div>
                    <small class="text-muted">Completed</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body py-3">
            <div class="form-row">
                <div class="form-group col-lg-4 col-md-6 mb-2">
                    <input type="text" class="form-control" placeholder="Search reference, subject or description..." wire:model.debounce.400ms="search">
                </div>
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <select class="form-control" wire:model="status">
                        <option value="">All statuses</option>
                        @foreach (\App\Models\Support\Ticket::STATUSES as $key => $s)
                            <option value="{{ $key }}">{{ $s['label'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <select class="form-control" wire:model="priority_id">
                        <option value="">All priorities</option>
                        @foreach ($priorities as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <select class="form-control" wire:model="category_id">
                        <option value="">All categories</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-3 mb-2">
                    <select class="form-control" wire:model="system_id">
                        <option value="">All modules</option>
                        @foreach ($systems as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row align-items-center">
                @if ($mode === 'all')
                    <div class="form-group col-lg-3 col-md-4 mb-2">
                        <select class="form-control" wire:model="assignee_id">
                            <option value="">Any developer</option>
                            <option value="none">Unassigned</option>
                            @foreach ($developers as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="form-group col-lg-2 col-md-4 mb-2">
                    <input type="date" class="form-control" wire:model="date_from" title="Created from">
                </div>
                <div class="form-group col-lg-2 col-md-4 mb-2">
                    <input type="date" class="form-control" wire:model="date_to" title="Created to">
                </div>
                <div class="form-group col-auto mb-2">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="overdueFilter" wire:model="overdue">
                        <label class="custom-control-label" for="overdueFilter">Overdue only</label>
                    </div>
                </div>
                <div class="form-group col-auto mb-2 ml-auto">
                    <button type="button" class="btn btn-sm btn-outline-secondary" wire:click="resetFilters">Reset filters</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Reference</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        @if ($mode === 'all')<th>Submitted by</th>@endif
                        <th>Assigned to</th>
                        <th>Due</th>
                        <th>Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tickets as $ticket)
                        <tr>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.support.show', $ticket->id) }}" class="font-weight-bold">{{ $ticket->reference }}</a>
                            </td>
                            <td style="min-width: 220px;">
                                <a href="{{ route('admin.support.show', $ticket->id) }}" class="text-dark">{{ \Illuminate\Support\Str::limit($ticket->subject, 70) }}</a>
                                @if ($ticket->system)<br><small class="text-muted">{{ $ticket->system->name }}</small>@endif
                            </td>
                            <td>{{ $ticket->category->name ?? '-' }}</td>
                            <td><span class="badge bg-{{ $ticket->priority->color ?? 'secondary' }} text-white">{{ $ticket->priority->name ?? '-' }}</span></td>
                            <td><span class="badge bg-{{ $ticket->status_color }} text-white">{{ $ticket->status_label }}</span></td>
                            @if ($mode === 'all')<td>{{ $ticket->submitter->name ?? '-' }}</td>@endif
                            <td>{{ $ticket->assignee->name ?? 'Unassigned' }}</td>
                            <td class="text-nowrap">
                                @if ($ticket->due_date)
                                    <span class="{{ $ticket->isOverdue() ? 'text-danger font-weight-bold' : '' }}">{{ $ticket->due_date->format('d M Y') }}</span>
                                    @if ($ticket->isOverdue())<i class="fas fa-exclamation-circle text-danger" title="Overdue"></i>@endif
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-nowrap small text-muted">{{ optional($ticket->last_activity_at)->diffForHumans() ?? $ticket->created_at->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $mode === 'all' ? 9 : 8 }}" class="text-center text-muted py-5">
                                No tickets match your filters.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($tickets->hasPages())
            <div class="card-footer d-flex justify-content-center">{{ $tickets->links() }}</div>
        @endif
    </div>
</div>
