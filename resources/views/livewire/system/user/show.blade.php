<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">User Details</h1>
            <p class="text-muted mb-0">Manage profile information, password reset, and role assignments.</p>
        </div>
        <a href="{{ route('system.users') }}" class="btn btn-sm btn-outline-secondary">Back to Users</a>
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

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm mb-3">
                <div class="card-header text-center">
                    <img class="img-profile rounded-circle" width="90" src="{{ asset('admin/img/undraw_profile.svg') }}" alt="Profile avatar">
                </div>
                <div class="card-body">
                    <p><b>Name</b>: {{ $user->name }}</p>
                    <p><b>Email</b>: {{ $user->email }}</p>
                    <p><b>Phone</b>: {{ $user->phone }}</p>
                    <p><b>Status</b>: {{ $user->status->name ?? '--' }}</p>
                    <p><b>Total Logins</b>: {{ $user->logins ?? 0 }}</p>
                    <p class="mb-0"><b>Last Login</b>: {{ $user->last_login ?? '--' }}</p>
                </div>
                <div class="card-footer d-flex flex-wrap gap-2">
                    <button wire:click="togglePasswordReset" class="btn btn-warning btn-sm">Password Reset</button>
                    <button wire:click="toggleEdit" class="btn btn-primary btn-sm">Edit</button>
                    <button onclick="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm">Delete</button>
                </div>
            </div>

            @if($updateUser)
                <div class="card shadow-sm">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Update User</h5>
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Close</button>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="update">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userName">Name</label>
                                    <input id="userName" type="text" class="form-control" wire:model.defer="name" required>
                                    @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userEmail">Email Address</label>
                                    <input id="userEmail" type="email" class="form-control" wire:model.defer="email" required>
                                    @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userPhone">Phone</label>
                                    <input id="userPhone" type="text" class="form-control" wire:model.defer="phone" required>
                                    @error('phone') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userStatus">Status</label>
                                    <select id="userStatus" class="form-control" wire:model.defer="status_id" required>
                                        <option value="">-- Select --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if($showPasswordReset)
                <div class="card shadow-sm mt-3">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Password Reset</h5>
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Close</button>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="updatePassword">
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="newPassword">New Password</label>
                                    <input id="newPassword" type="password" class="form-control" wire:model.defer="password" autocomplete="new-password" required>
                                    @error('password') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="confirmPassword">Confirm Password</label>
                                    <input id="confirmPassword" type="password" class="form-control" wire:model.defer="password_confirmation" autocomplete="new-password" required>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-warning">Reset Password</button>
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Attach Roles</h5>
                </div>
                <div class="card-body">
                    @if ($all_roles->count() > 0)
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
                                    @foreach($all_roles as $role)
                                        <tr>
                                            <td>
                                                <input type="checkbox" wire:model="selectedRoles" value="{{ $role->id }}">
                                            </td>
                                            <td>{{ $role->name }}</td>
                                            <td>{{ $role->slug }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button wire:click="attachRole" type="button" class="btn btn-primary btn-sm" @if (count($selectedRoles) === 0) disabled @endif>
                            Attach Selected Roles
                        </button>
                    @else
                        <div class="text-muted">All roles are already attached.</div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Assigned Roles</h5>
                    <span class="badge badge-light">{{ $user->roles->count() }}</span>
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
                                @forelse ($user->roles as $index => $role)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->slug }}</td>
                                        <td>
                                            <button onclick="detachRole({{ $role->id }})" class="btn btn-sm btn-outline-danger">Remove</button>
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
                </div>
            </div>
        </div>
    </div>

    <script>
        function detachRole(id) {
            if (confirm("Are you sure to detach this role?")) {
                window.livewire.emit('detachRole', id);
            }
        }

        function deleteUser(id) {
            if (confirm("Are you sure to delete this user?")) {
                window.livewire.emit('deleteUser', id);
            }
        }
    </script>
</div>
