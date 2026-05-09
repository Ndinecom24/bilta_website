<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Roles</h1>
            <p class="text-muted mb-0">Manage role groups and access scopes for system users.</p>
        </div>
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
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateRole ? 'Edit Role' : 'Add Role' }}</h5>
                    @if ($updateRole)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateRole ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="roleName">Name</label>
                                <input id="roleName" type="text" class="form-control" wire:model.defer="name" placeholder="Enter role name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="roleSlug">Description / Slug</label>
                                <input id="roleSlug" type="text" class="form-control" wire:model.defer="slug" placeholder="Enter description">
                                @error('slug') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateRole ? 'Update Role' : 'Save Role' }}</button>
                            @if ($updateRole)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">System Roles</h5>
                    <span class="badge badge-light">{{ $roles->total() }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th style="width: 220px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $roles->firstItem() + $key }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->slug }}</td>
                                        <td>
                                            <a href="{{ route('system.roles.show', $role) }}" class="btn btn-success btn-sm">View</a>
                                            <button wire:click="edit({{ $role->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteRole({{ $role->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No Roles Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteRole(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteRole', id);
        }
    </script>
</div>
