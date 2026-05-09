<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Role Details</h1>
            <p class="text-muted mb-0">Attach and detach permissions and users for this role.</p>
        </div>
        <a href="{{ route('system.roles') }}" class="btn btn-sm btn-outline-secondary">Back to Roles</a>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Attach Permissions</h5>
                </div>
                <div class="card-body">
                    @if ($all_permissions->count() > 0)
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;"></th>
                                        <th>Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_permissions as $permission)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->id }}">
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->slug }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button wire:click="attachPermission" type="button" class="btn btn-primary btn-sm" @if (count($selectedPermissions) === 0) disabled @endif>
                            Attach Selected Permissions
                        </button>
                    @else
                        <div class="text-muted">All permissions are already attached.</div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Attached Permissions</h5>
                    <span class="badge badge-light">{{ $role->permissions->count() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($role->permissions as $index => $permission)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $permission->name }}</td>
                                        <td>{{ $permission->slug }}</td>
                                        <td>
                                            <button onclick="detachPermission({{ $permission->id }})" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No Permissions Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Attach Users</h5>
                </div>
                <div class="card-body">
                    @if ($all_users->count() > 0)
                        <div class="table-responsive mb-3">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th style="width:40px;"></th>
                                        <th>Name</th>
                                        <th>Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_users as $user)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedUsers" value="{{ $user->id }}">
                                            </td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button wire:click="attachUsers" type="button" class="btn btn-primary btn-sm" @if (count($selectedUsers) === 0) disabled @endif>
                            Attach Selected Users
                        </button>
                    @else
                        <div class="text-muted">All users are already attached.</div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Attached Users</h5>
                    <span class="badge badge-light">{{ $role->users->count() }}</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th style="width:100px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($role->users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <button onclick="detachUser({{ $user->id }})" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No Users Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function detachPermission(id) {
            if (confirm("Are you sure to detach this permission?")) {
                window.livewire.emit('detachPermission', id);
            }
        }

        function detachUser(id) {
            if (confirm("Are you sure to detach this user?")) {
                window.livewire.emit('detachUser', id);
            }
        }
    </script>
</div>
