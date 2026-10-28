<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Positions</h1>
        @canany(['create-positions', 'manage-positions'])
        <button wire:click="toggleForm" class="btn btn-{{ $showForm ? 'outline-secondary' : 'primary' }}">
            <i class="fas fa-{{ $showForm ? 'times' : 'plus' }}"></i>
            {{ $showForm ? 'Close' : 'Add Position' }}
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

        {{-- Create / Edit Form --}}
        @if ($showForm)
        <div class="col-md-12 mb-3">
            <div class="card shadow-sm border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">{{ $isEdit ? 'Edit Position' : 'New Position' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Position Title *</label>
                                <input type="text" class="form-control" wire:model.defer="name" placeholder="e.g. Translation Consultant">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="font-weight-bold">Code</label>
                                <input type="text" class="form-control" wire:model.defer="code" placeholder="e.g. TC" maxlength="20">
                                @error('code') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Department</label>
                                <select class="form-control" wire:model.defer="department_id">
                                    <option value="">— Cross-departmental / None —</option>
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Status</label>
                                <select class="form-control" wire:model.defer="status_id">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="font-weight-bold">Job Description / Responsibilities</label>
                                <textarea class="form-control" wire:model.defer="description" rows="2" placeholder="Brief overview of responsibilities and scope for this position"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Update Position' : 'Create Position' }}
                            </button>
                            <button wire:click.prevent="toggleForm" type="button" class="btn btn-outline-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Positions Table --}}
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="mb-0">All Positions</h5>
                        <span class="badge badge-light">{{ $positions->total() }} total</span>
                    </div>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" placeholder="Search title or code..." wire:model.debounce.300ms="search" style="min-width: 200px;">
                        <select class="form-control form-control-sm" wire:model="filterDepartment" style="min-width: 180px;">
                            <option value="">All Departments</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Code</th>
                                    <th>Department</th>
                                    <th>Assigned Staff</th>
                                    <th>Status</th>
                                    <th style="width: 180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($positions as $key => $pos)
                                    <tr>
                                        <td>{{ $positions->firstItem() + $key }}</td>
                                        <td>
                                            <strong>{{ $pos->name }}</strong>
                                            @if ($pos->description)
                                                <br><small class="text-muted">{{ Str::limit($pos->description, 60) }}</small>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-secondary text-white">{{ $pos->code ?? '—' }}</span></td>
                                        <td>
                                            @if ($pos->department)
                                                <span class="badge bg-primary text-white">{{ $pos->department->name }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-white">{{ $pos->users_count }} staff</span>
                                        </td>
                                        <td>
                                            @if ($pos->status_id == 1)
                                                <span class="badge bg-success text-white">Active</span>
                                            @else
                                                <span class="badge bg-danger text-white">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @canany(['edit-positions', 'manage-positions'])
                                            <button wire:click="edit({{ $pos->id }})" class="btn btn-warning btn-sm">Edit</button>
                                            @endcanany
                                            @canany(['delete-positions', 'manage-positions'])
                                            <button onclick="deletePosition({{ $pos->id }})" class="btn btn-danger btn-sm">Delete</button>
                                            @endcanany
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No positions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $positions->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deletePosition(id) {
            if (confirm("Are you sure you want to delete this position?")) {
                window.livewire.emit('deletePosition', id);
            }
        }
    </script>
</div>
