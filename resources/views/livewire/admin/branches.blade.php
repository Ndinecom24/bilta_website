<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Branches</h1>
        @canany(['create-branches', 'manage-branches'])
        <button wire:click="toggleForm" class="btn btn-{{ $showForm ? 'outline-secondary' : 'primary' }}">
            <i class="fas fa-{{ $showForm ? 'times' : 'plus' }}"></i>
            {{ $showForm ? 'Close' : 'Add Branch' }}
        </button>
        @endcanany
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        {{-- Overview stats --}}
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Branches</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['branches'] }}</div>
                    <small class="text-muted">{{ $stats['active_branches'] }} active</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Employees in branches</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['assigned'] }} <small class="text-muted">/ {{ $stats['total_employees'] }}</small></div>
                    <small class="text-muted">Average {{ $stats['average'] }} per branch</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Not assigned to a branch</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['unassigned'] }}</div>
                    <small class="text-muted">Employees without a branch</small>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Largest / smallest</div>
                    <div class="font-weight-bold text-gray-800">
                        {{ $stats['largest'] ? $stats['largest']->name . ' (' . $stats['largest']->employees_count . ')' : '—' }}
                    </div>
                    <small class="text-muted">
                        Smallest: {{ $stats['smallest'] ? $stats['smallest']->name . ' (' . $stats['smallest']->employees_count . ')' : '—' }}
                    </small>
                </div>
            </div>
        </div>

        {{-- Headcount comparison --}}
        @if ($stats['ranking']->count())
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header"><h6 class="mb-0 font-weight-bold"><i class="fas fa-chart-bar mr-1"></i> Headcount by Branch</h6></div>
                <div class="card-body">
                    @foreach ($stats['ranking'] as $rb)
                        @php
                            $pctOfMax = $stats['max_count'] > 0 ? round($rb->employees_count / $stats['max_count'] * 100) : 0;
                            $pctOfStaff = $stats['assigned'] > 0 ? round($rb->employees_count / $stats['assigned'] * 100, 1) : 0;
                        @endphp
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small">
                                <span class="font-weight-bold">{{ $rb->name }}</span>
                                <span>{{ $rb->employees_count }} employees ({{ $pctOfStaff }}% of branch staff)</span>
                            </div>
                            <div class="progress" style="height: 14px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $pctOfMax }}%"></div>
                            </div>
                        </div>
                    @endforeach
                    @if ($stats['branches'] > 8)
                        <small class="text-muted">Showing the 8 largest branches.</small>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Create / Edit Form --}}
        @if ($showForm)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $isEdit ? 'Edit Branch' : 'New Branch' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Branch Name *</label>
                                <input type="text" class="form-control" wire:model.defer="name" placeholder="e.g. Lusaka Head Office">
                            </div>
                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="font-weight-bold">Code</label>
                                <input type="text" class="form-control" wire:model.defer="code" maxlength="20" placeholder="e.g. LSK">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">City / Town</label>
                                <input type="text" class="form-control" wire:model.defer="city">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Status</label>
                                <select class="form-control" wire:model.defer="status_id">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 mb-3">
                                <label class="font-weight-bold">Address</label>
                                <input type="text" class="form-control" wire:model.defer="address">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Phone</label>
                                <input type="text" class="form-control" wire:model.defer="phone">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Email</label>
                                <input type="email" class="form-control" wire:model.defer="email">
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Branch Manager</label>
                                <select class="form-control" wire:model.defer="manager_id">
                                    <option value="">— None —</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-8 mb-3">
                                <label class="font-weight-bold">Description</label>
                                <textarea class="form-control" rows="2" wire:model.defer="description"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update Branch' : 'Create Branch' }}</button>
                        <button wire:click.prevent="toggleForm" type="button" class="btn btn-outline-danger">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Branch detail --}}
        @if ($detail)
        @php $b = $detail['branch']; @endphp
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-info">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-white"><i class="fas fa-code-branch mr-1"></i> {{ $b->name }} {{ $b->code ? '(' . $b->code . ')' : '' }}</h5>
                    <button wire:click="closeView" class="btn btn-sm btn-light">Close</button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2"><small class="text-muted">City</small><div>{{ $b->city ?: '—' }}</div></div>
                        <div class="col-md-5 mb-2"><small class="text-muted">Address</small><div>{{ $b->address ?: '—' }}</div></div>
                        <div class="col-md-2 mb-2"><small class="text-muted">Phone</small><div>{{ $b->phone ?: '—' }}</div></div>
                        <div class="col-md-2 mb-2"><small class="text-muted">Email</small><div>{{ $b->email ?: '—' }}</div></div>
                        <div class="col-md-3 mb-2"><small class="text-muted">Branch Manager</small><div class="font-weight-bold">{{ optional($b->manager)->name ?: '—' }}</div></div>
                        <div class="col-md-9 mb-2"><small class="text-muted">Description</small><div>{{ $b->description ?: '—' }}</div></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 mb-2"><div class="border rounded p-2 text-center"><div class="h4 mb-0">{{ $detail['employees']->count() }}</div><small class="text-muted">Employees</small></div></div>
                        <div class="col-md-3 mb-2"><div class="border rounded p-2 text-center"><div class="h4 mb-0">{{ $detail['active'] }}</div><small class="text-muted">Active accounts</small></div></div>
                        <div class="col-md-3 mb-2"><div class="border rounded p-2 text-center"><div class="h4 mb-0">{{ $detail['employees']->count() - $detail['active'] }}</div><small class="text-muted">Inactive accounts</small></div></div>
                        <div class="col-md-3 mb-2"><div class="border rounded p-2 text-center"><div class="h4 mb-0">{{ $detail['avg_tenure'] !== null ? $detail['avg_tenure'] . ' yrs' : '—' }}</div><small class="text-muted">Average tenure</small></div></div>
                    </div>

                    {{-- Breakdowns --}}
                    @php
                        $total = max($detail['employees']->count(), 1);
                        $breakdowns = [
                            'By Department' => $detail['by_department'],
                            'By Position' => $detail['by_position'],
                            'By Contract Type' => $detail['by_contract'],
                            'By Gender' => $detail['by_gender'],
                        ];
                    @endphp
                    <div class="row">
                        @foreach ($breakdowns as $title => $rows)
                            <div class="col-lg-3 col-md-6 mb-3">
                                <h6 class="font-weight-bold">{{ $title }}</h6>
                                @forelse ($rows as $label => $n)
                                    <div class="small d-flex justify-content-between"><span>{{ $label }}</span><span>{{ $n }} ({{ round($n / $total * 100) }}%)</span></div>
                                    <div class="progress mb-2" style="height: 6px;"><div class="progress-bar bg-info" style="width: {{ round($n / $total * 100) }}%"></div></div>
                                @empty
                                    <small class="text-muted">No data</small>
                                @endforelse
                            </div>
                        @endforeach
                    </div>

                    {{-- Assign employee --}}
                    @canany(['edit-branches', 'manage-branches'])
                    <div class="border rounded bg-light p-3 mb-3">
                        <label class="font-weight-bold small mb-1">Assign an employee without a branch</label>
                        <div class="d-flex">
                            <select class="form-control form-control-sm mr-2" wire:model.defer="assignUserId">
                                <option value="">-- Select employee --</option>
                                @foreach ($unassigned as $u)
                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                @endforeach
                            </select>
                            <button wire:click="assignEmployee" class="btn btn-sm btn-primary">Assign</button>
                        </div>
                        <small class="text-muted">You can also set the branch on each employee's profile.</small>
                    </div>
                    @endcanany

                    {{-- Employees --}}
                    <h6 class="font-weight-bold">Employees</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr><th>Name</th><th>Position</th><th>Department</th><th>Contract</th><th>Joined</th><th>Status</th><th></th></tr>
                            </thead>
                            <tbody>
                                @forelse ($detail['employees'] as $emp)
                                    <tr>
                                        <td>{{ $emp->name }}</td>
                                        <td>{{ optional($emp->positionRelation)->name ?: ($emp->position ?: '—') }}</td>
                                        <td>{{ optional($emp->departmentRelation)->name ?: '—' }}</td>
                                        <td>{{ $emp->contract_type ? ucfirst($emp->contract_type) : '—' }}</td>
                                        <td>{{ $emp->date_joined ? $emp->date_joined->format('d M Y') : '—' }}</td>
                                        <td>{{ optional($emp->status)->name ?: '—' }}</td>
                                        <td class="text-right">
                                            @canany(['edit-branches', 'manage-branches'])
                                            <button wire:click="removeEmployee({{ $emp->id }})" class="btn btn-outline-danger btn-sm" onclick="return confirm('Remove this employee from the branch?')">Remove</button>
                                            @endcanany
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="text-center text-muted">No employees assigned to this branch yet.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Branches Table --}}
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 mr-2">All Branches</h5>
                        <span class="badge badge-light">{{ $branches->total() }} total</span>
                    </div>
                    <div class="d-flex">
                        <input type="text" class="form-control form-control-sm mr-2" placeholder="Search name, code or city..." wire:model.debounce.300ms="search" style="min-width: 220px;">
                        <select class="form-control form-control-sm" wire:model="filterStatus" style="min-width: 140px;">
                            <option value="">All statuses</option>
                            <option value="1">Active</option>
                            <option value="2">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Branch</th>
                                    <th>City</th>
                                    <th>Manager</th>
                                    <th>Employees</th>
                                    <th>Share</th>
                                    <th>Status</th>
                                    <th style="width: 220px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($branches as $key => $br)
                                    <tr>
                                        <td>{{ $branches->firstItem() + $key }}</td>
                                        <td>
                                            <strong>{{ $br->name }}</strong>
                                            @if ($br->code) <span class="badge bg-secondary text-white">{{ $br->code }}</span> @endif
                                        </td>
                                        <td>{{ $br->city ?: '—' }}</td>
                                        <td>{{ optional($br->manager)->name ?: '—' }}</td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ $br->employees_count }} staff</span>
                                            <small class="text-muted">({{ $br->active_employees_count }} active)</small>
                                        </td>
                                        <td style="min-width: 120px;">
                                            @php $share = $stats['assigned'] > 0 ? round($br->employees_count / $stats['assigned'] * 100) : 0; @endphp
                                            <div class="progress" style="height: 8px;"><div class="progress-bar" style="width: {{ $share }}%"></div></div>
                                            <small class="text-muted">{{ $share }}%</small>
                                        </td>
                                        <td>
                                            @if ($br->status_id == 1)
                                                <span class="badge bg-success text-white">Active</span>
                                            @else
                                                <span class="badge bg-danger text-white">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="viewBranch({{ $br->id }})" class="btn btn-info btn-sm">View</button>
                                            @canany(['edit-branches', 'manage-branches'])
                                            <button wire:click="edit({{ $br->id }})" class="btn btn-warning btn-sm">Edit</button>
                                            @endcanany
                                            @canany(['delete-branches', 'manage-branches'])
                                            <button onclick="deleteBranch({{ $br->id }})" class="btn btn-danger btn-sm">Delete</button>
                                            @endcanany
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center text-muted">No branches found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $branches->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteBranch(id) {
            if (confirm("Are you sure you want to delete this branch?")) {
                window.livewire.emit('deleteBranch', id);
            }
        }
    </script>
</div>
