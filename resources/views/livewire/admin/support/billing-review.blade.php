<div>
    @php $fmt = function ($n) { return rtrim(rtrim(number_format((float) $n, 2), '0'), '.') ?: '0'; }; @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Billing Review</h1>
        <a href="{{ route('admin.support.settings') }}" class="btn btn-outline-secondary"><i class="fas fa-cog"></i> Billing Rates</a>
    </div>

    <div class="alert alert-info small">
        Approving work records the billable hours and the rate in force on the work date. It does not change the hours worked and no invoice is created.
    </div>

    @if (session()->has('success'))<div class="alert alert-success">{{ session()->get('success') }}</div>@endif
    @if (session()->has('error'))<div class="alert alert-danger">{{ session()->get('error') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0 pl-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-3"><div class="card border-left-warning shadow-sm"><div class="card-body py-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase">Awaiting review</div>
            <div class="h5 mb-0 font-weight-bold">{{ $fmt($summary['unreviewed']) }}h</div>
        </div></div></div>
        <div class="col-md-4 mb-3"><div class="card border-left-success shadow-sm"><div class="card-body py-2">
            <div class="text-xs font-weight-bold text-success text-uppercase">Approved billable</div>
            <div class="h5 mb-0 font-weight-bold">{{ $fmt($summary['approved']) }}h</div>
        </div></div></div>
        <div class="col-md-4 mb-3"><div class="card border-left-secondary shadow-sm"><div class="card-body py-2">
            <div class="text-xs font-weight-bold text-secondary text-uppercase">Non-billable</div>
            <div class="h5 mb-0 font-weight-bold">{{ $fmt($summary['non_billable']) }}h</div>
        </div></div></div>
    </div>

    <div class="card shadow-sm mb-3">
        <div class="card-body py-3">
            <div class="form-row">
                <div class="form-group col-md-2 mb-2">
                    <select class="form-control" wire:model="status">
                        <option value="unreviewed">Awaiting review</option>
                        <option value="approved">Approved</option>
                        <option value="non_billable">Non-billable</option>
                        <option value="all">All</option>
                    </select>
                </div>
                <div class="form-group col-md-3 mb-2">
                    <select class="form-control" wire:model="developer_id">
                        <option value="">All developers</option>
                        @foreach ($developers as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
                    </select>
                </div>
                <div class="form-group col-md-2 mb-2"><input type="date" class="form-control" wire:model="from" title="Worked from"></div>
                <div class="form-group col-md-2 mb-2"><input type="date" class="form-control" wire:model="to" title="Worked to"></div>
                <div class="form-group col-md-3 mb-2"><input type="text" class="form-control" placeholder="Ticket reference or subject" wire:model.debounce.400ms="search"></div>
            </div>
        </div>
    </div>

    @if ($status === 'unreviewed' && $logs->count())
        <div class="mb-2">
            <button class="btn btn-sm btn-success" wire:click="approveSelected" wire:loading.attr="disabled">
                <i class="fas fa-check"></i> Approve selected (full hours)
            </button>
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 30px;"></th>
                        <th>Date</th>
                        <th>Ticket</th>
                        <th>Developer</th>
                        <th>Work</th>
                        <th class="text-right">Worked</th>
                        <th>Rate</th>
                        <th>Billing</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        @php $rate = $rates[$log->id]; @endphp
                        <tr>
                            <td>
                                @if ($log->billing_status === 'unreviewed')
                                    <input type="checkbox" value="{{ $log->id }}" wire:model="selected">
                                @endif
                            </td>
                            <td class="text-nowrap">{{ $log->work_date->format('d M Y') }}</td>
                            <td class="text-nowrap"><a href="{{ route('admin.support.show', $log->ticket_id) }}">{{ $log->ticket->reference }}</a><br><small class="text-muted">{{ \Illuminate\Support\Str::limit($log->ticket->subject, 32) }}</small></td>
                            <td>{{ $log->developer->name ?? '-' }}</td>
                            <td style="min-width: 200px; white-space: pre-wrap;">{{ \Illuminate\Support\Str::limit($log->description, 120) }}<br><small class="text-muted">{{ $log->work_type_label }}@if (!$log->is_billable && $log->billing_status === 'unreviewed') &middot; proposed non-billable @endif</small></td>
                            <td class="text-right">{{ $fmt($log->hours) }}h</td>
                            <td class="text-nowrap small">
                                @if ($log->billing_status === 'approved')
                                    {{ $fmt($log->rate_applied) }} {{ $log->currency }}/h
                                @elseif ($rate)
                                    {{ $fmt($rate->hourly_rate) }} {{ $rate->currency }}/h
                                @else
                                    <span class="text-danger">No rate</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                @if ($log->billing_status === 'approved')
                                    <span class="badge bg-success text-white">{{ $fmt($log->billable_hours) }}h = {{ number_format($log->billable_amount, 2) }} {{ $log->currency }}</span>
                                @elseif ($log->billing_status === 'non_billable')
                                    <span class="badge bg-secondary text-white">Non-billable</span>
                                @else
                                    <span class="badge bg-light text-dark border">Unreviewed</span>
                                @endif
                            </td>
                            <td class="text-right text-nowrap">
                                @if ($log->billing_status === 'unreviewed')
                                    <input type="number" step="0.25" min="0.25" max="{{ $log->hours }}" class="form-control form-control-sm d-inline-block" style="width: 80px;"
                                           placeholder="{{ $fmt($log->hours) }}" wire:model.defer="billable.{{ $log->id }}" title="Billable hours (blank = all)">
                                    <button class="btn btn-sm btn-success" wire:click="approve({{ $log->id }})" title="Approve">Approve</button>
                                    <button class="btn btn-sm btn-outline-secondary" wire:click="markNonBillable({{ $log->id }})" title="Mark non-billable">Non-billable</button>
                                @else
                                    <button class="btn btn-sm btn-outline-warning" wire:click="undoReview({{ $log->id }})" title="Send back to review">Undo</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="text-center text-muted py-5">Nothing to review.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())<div class="card-footer d-flex justify-content-center">{{ $logs->links() }}</div>@endif
    </div>
</div>
