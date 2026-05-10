<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Departments</h1>
        <button wire:click="toggleForm" class="btn btn-{{ $showForm ? 'outline-secondary' : 'primary' }}">
            <i class="fas fa-{{ $showForm ? 'times' : 'plus' }}"></i>
            {{ $showForm ? 'Close' : 'Add Department' }}
        </button>
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
                    <h5 class="mb-0">{{ $isEdit ? 'Edit Department' : 'New Department' }}</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Department Name *</label>
                                <input type="text" class="form-control" wire:model.defer="name" placeholder="e.g. Translation">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-2 col-md-6 mb-3">
                                <label class="font-weight-bold">Code</label>
                                <input type="text" class="form-control" wire:model.defer="code" placeholder="e.g. TRANS" maxlength="20">
                                @error('code') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Department Head</label>
                                <select class="form-control" wire:model.defer="head_id">
                                    <option value="">— None —</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}{{ $u->position ? ' ('.$u->position.')' : '' }}</option>
                                    @endforeach
                                </select>
                                @error('head_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Status</label>
                                <select class="form-control" wire:model.defer="status_id">
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="font-weight-bold">Description</label>
                                <textarea class="form-control" wire:model.defer="description" rows="2" placeholder="Brief description of department functions"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ $isEdit ? 'Update Department' : 'Create Department' }}
                            </button>
                            <button wire:click.prevent="toggleForm" type="button" class="btn btn-outline-danger">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif

        {{-- Departments Table --}}
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">All Departments</h5>
                    <span class="badge badge-light">{{ $departments->total() }} total</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Head</th>
                                    <th>Members</th>
                                    <th>Status</th>
                                    <th style="width: 180px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($departments as $key => $dept)
                                    <tr>
                                        <td>{{ $departments->firstItem() + $key }}</td>
                                        <td>
                                            <strong>{{ $dept->name }}</strong>
                                            @if ($dept->description)
                                                <br><small class="text-muted">{{ Str::limit($dept->description, 60) }}</small>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-secondary text-white">{{ $dept->code ?? '—' }}</span></td>
                                        <td>{{ $dept->head->name ?? '—' }}</td>
                                        <td><span class="badge bg-info text-white">{{ $dept->members_count }}</span></td>
                                        <td>
                                            @if ($dept->status_id == 1)
                                                <span class="badge bg-success text-white">Active</span>
                                            @else
                                                <span class="badge bg-danger text-white">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="edit({{ $dept->id }})" class="btn btn-warning btn-sm">Edit</button>
                                            <button onclick="deleteDepartment({{ $dept->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No departments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $departments->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteDepartment(id) {
            if (confirm("Are you sure you want to delete this department?")) {
                window.livewire.emit('deleteDepartment', id);
            }
        }
    </script>
</div>
