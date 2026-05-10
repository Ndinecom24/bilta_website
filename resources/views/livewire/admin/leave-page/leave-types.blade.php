<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Leave Types</h1>
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

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateLeaveType ? 'Edit Leave Type' : 'Add Leave Type' }}</h5>
                    @if ($updateLeaveType)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateLeaveType ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Name</label>
                                <input type="text" class="form-control" wire:model="name" placeholder="e.g. Annual Leave">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Slug</label>
                                <input type="text" class="form-control" wire:model.defer="slug" placeholder="auto-generated">
                                @error('slug') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Default Days / Year</label>
                                <input type="number" class="form-control" wire:model.defer="default_days" min="0">
                                @error('default_days') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="font-weight-bold">Description</label>
                                <textarea rows="2" class="form-control" wire:model.defer="description" placeholder="Optional description"></textarea>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Status</label>
                                <select class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Choose --</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" wire:model.defer="is_paid" id="isPaid">
                                    <label class="form-check-label font-weight-bold" for="isPaid">Paid Leave</label>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" wire:model.defer="requires_document" id="requiresDoc">
                                    <label class="form-check-label font-weight-bold" for="requiresDoc">Requires Document</label>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" wire:model.defer="carry_over" id="carryOver">
                                    <label class="form-check-label font-weight-bold" for="carryOver">Allow Carry Over</label>
                                </div>
                            </div>

                            @if ($carry_over)
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Max Carry Over Days</label>
                                <input type="number" class="form-control" wire:model.defer="max_carry_over_days" min="0">
                            </div>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateLeaveType ? 'Update' : 'Save Leave Type' }}</button>
                            @if ($updateLeaveType)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header"><h5 class="mb-0">Leave Types</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Default Days</th>
                                    <th>Paid</th>
                                    <th>Document</th>
                                    <th>Carry Over</th>
                                    <th>Status</th>
                                    <th style="width: 170px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($leaveTypes as $type)
                                    <tr>
                                        <td>{{ $type->name }}</td>
                                        <td>{{ $type->default_days }}</td>
                                        <td>{!! $type->is_paid ? '<span class="badge bg-success text-white">Yes</span>' : '<span class="badge bg-secondary text-white">No</span>' !!}</td>
                                        <td>{!! $type->requires_document ? '<span class="badge bg-warning text-dark">Required</span>' : '-' !!}</td>
                                        <td>{{ $type->carry_over ? $type->max_carry_over_days . ' days' : 'No' }}</td>
                                        <td>{!! $type->status_id == 1 ? '<span class="badge bg-success text-white">Active</span>' : '<span class="badge bg-secondary text-white">Inactive</span>' !!}</td>
                                        <td>
                                            <button wire:click="edit({{ $type->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteLeaveType({{ $type->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Leave Types Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">{{ $leaveTypes->links() }}</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteLeaveType(id) {
            if (confirm("Are you sure you want to delete this leave type?"))
                window.livewire.emit('deleteLeaveType', id);
        }
    </script>
</div>
