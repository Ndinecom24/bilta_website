<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Users</h1>
            <p class="text-muted mb-0">Create and review system users, roles, and account status.</p>
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
                <div class="card-header">
                    <h5 class="mb-0">Add User</h5>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="store">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="userName">Name</label>
                                <input id="userName" type="text" class="form-control" wire:model.defer="name" required>
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="userEmail">Email Address</label>
                                <input id="userEmail" type="email" class="form-control" wire:model.defer="email" required>
                                @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="userPhone">Phone</label>
                                <input id="userPhone" type="text" class="form-control" wire:model.defer="phone" required>
                                @error('phone') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="userPassword">Password</label>
                                <input id="userPassword" type="password" class="form-control" wire:model.defer="password" required autocomplete="new-password">
                                @error('password') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="userRole">Role</label>
                                <select id="userRole" class="form-control" wire:model.defer="role_id" required>
                                    <option value="">-- Select --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
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
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">System Users</h5>
                    <span class="badge badge-light">{{ $users->total() }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Role Count</th>
                                    <th>Status</th>
                                    <th>Logins</th>
                                    <th style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->roles->count() }}</td>
                                        <td>{{ $user->status->name ?? '--' }}</td>
                                        <td>{{ $user->logins ?? 0 }}</td>
                                        <td>
                                            <a href="{{ route('system.users.show', $user->uuid ?? '0') }}"
                                               onclick="event.preventDefault(); document.getElementById('user-profile-form{{ $user->uuid ?? '0' }}').submit();"
                                               class="btn btn-success btn-sm">View</a>
                                            <form id="user-profile-form{{ $user->uuid ?? '0' }}" action="{{ route('system.users.show', $user->uuid ?? '0') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No Users Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
