<div>
    @php
        $tabs = [];
        if ($canSettings) {
            $tabs['categories'] = 'Categories';
            $tabs['systems'] = 'Systems / Modules';
            $tabs['priorities'] = 'Priorities';
        }
        if ($canBilling) {
            $tabs['rates'] = 'Billing Rates';
        }
        $label = ['categories' => 'Category', 'systems' => 'System / module', 'priorities' => 'Priority', 'rates' => 'Billing rate'][$tab];
    @endphp

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Support Settings</h1>
        @if ($canBilling)
            <a href="{{ route('admin.support.billing') }}" class="btn btn-outline-primary"><i class="fas fa-file-invoice-dollar"></i> Billing Review</a>
        @endif
    </div>

    @if (session()->has('success'))<div class="alert alert-success">{{ session()->get('success') }}</div>@endif
    @if ($errors->any())
        <div class="alert alert-danger"><ul class="mb-0 pl-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <ul class="nav nav-tabs mb-3">
        @foreach ($tabs as $key => $text)
            <li class="nav-item"><a href="#" class="nav-link {{ $tab === $key ? 'active' : '' }}" wire:click.prevent="setTab('{{ $key }}')">{{ $text }}</a></li>
        @endforeach
    </ul>

    <div class="row">
        {{-- List --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            @if ($tab === 'rates')
                                <tr><th>Name</th><th>Applies to</th><th class="text-right">Rate / hour</th><th>Effective</th><th>Status</th><th></th></tr>
                            @elseif ($tab === 'priorities')
                                <tr><th>Name</th><th>Level</th><th>Target</th><th>Tickets</th><th>Status</th><th></th></tr>
                            @else
                                <tr><th>Name</th><th>Order</th><th>Tickets</th><th>Status</th><th></th></tr>
                            @endif
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                                <tr>
                                    @if ($tab === 'rates')
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->developer->name ?? 'Everyone (default)' }}</td>
                                        <td class="text-right">{{ number_format($row->hourly_rate, 2) }} {{ $row->currency }}</td>
                                        <td class="text-nowrap small">{{ $row->effective_from->format('d M Y') }} &rarr; {{ $row->effective_to ? $row->effective_to->format('d M Y') : 'open' }}</td>
                                    @elseif ($tab === 'priorities')
                                        <td><span class="badge bg-{{ $row->color }} text-white">{{ $row->name }}</span></td>
                                        <td>{{ $row->level }}</td>
                                        <td>{{ $row->resolution_target_hours }}h</td>
                                        <td>{{ $row->tickets_count }}</td>
                                    @else
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->sort_order }}</td>
                                        <td>{{ $row->tickets_count }}</td>
                                    @endif
                                    <td><span class="badge bg-{{ $row->is_active ? 'success' : 'secondary' }} text-white">{{ $row->is_active ? 'Active' : 'Inactive' }}</span></td>
                                    <td class="text-right text-nowrap">
                                        <button class="btn btn-sm btn-outline-primary" wire:click="edit({{ $row->id }})">Edit</button>
                                        <button class="btn btn-sm btn-outline-secondary" wire:click="toggleActive({{ $row->id }})">{{ $row->is_active ? 'Deactivate' : 'Activate' }}</button>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">Nothing here yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($tab !== 'rates')
                <small class="text-muted">Items in use cannot be deleted. Deactivate them to hide them from new tickets.</small>
            @endif
        </div>

        {{-- Form --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header"><h6 class="mb-0 font-weight-bold">{{ $editingId ? 'Edit' : 'Add' }} {{ strtolower($label) }}</h6></div>
                <div class="card-body">
                    <form wire:submit.prevent="save">
                        <div class="form-group">
                            <label class="small font-weight-bold mb-0">Name</label>
                            <input type="text" class="form-control" wire:model.defer="name" maxlength="100">
                        </div>

                        @if ($tab === 'priorities')
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label class="small font-weight-bold mb-0">Level (1 = lowest)</label>
                                    <input type="number" class="form-control" wire:model.defer="level" min="1" max="10">
                                </div>
                                <div class="form-group col-6">
                                    <label class="small font-weight-bold mb-0">Target (hours)</label>
                                    <input type="number" class="form-control" wire:model.defer="target_hours" min="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold mb-0">Colour</label>
                                <select class="form-control" wire:model.defer="color">
                                    @foreach ($colors as $c)<option value="{{ $c }}">{{ ucfirst($c) }}</option>@endforeach
                                </select>
                            </div>
                        @elseif ($tab === 'rates')
                            <div class="form-row">
                                <div class="form-group col-7">
                                    <label class="small font-weight-bold mb-0">Rate per hour</label>
                                    <input type="number" step="0.01" min="0" class="form-control" wire:model.defer="hourly_rate">
                                </div>
                                <div class="form-group col-5">
                                    <label class="small font-weight-bold mb-0">Currency</label>
                                    <input type="text" class="form-control text-uppercase" maxlength="3" wire:model.defer="currency">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small font-weight-bold mb-0">Developer</label>
                                <select class="form-control" wire:model.defer="developer_id">
                                    <option value="">Everyone (default rate)</option>
                                    @foreach ($developers as $d)<option value="{{ $d->id }}">{{ $d->name }}</option>@endforeach
                                </select>
                                <small class="text-muted">A developer-specific rate overrides the default.</small>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <label class="small font-weight-bold mb-0">Effective from</label>
                                    <input type="date" class="form-control" wire:model.defer="effective_from">
                                </div>
                                <div class="form-group col-6">
                                    <label class="small font-weight-bold mb-0">Until (optional)</label>
                                    <input type="date" class="form-control" wire:model.defer="effective_to">
                                </div>
                            </div>
                        @else
                            <div class="form-group">
                                <label class="small font-weight-bold mb-0">Sort order</label>
                                <input type="number" class="form-control" wire:model.defer="sort_order" min="0">
                            </div>
                        @endif

                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="setActive" wire:model.defer="is_active">
                            <label class="custom-control-label" for="setActive">Active</label>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                        @if ($editingId)<button type="button" class="btn btn-outline-secondary" wire:click="cancel">Cancel</button>@endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
