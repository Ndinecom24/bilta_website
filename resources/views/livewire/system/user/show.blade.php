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
                    <p><b>Position</b>: {{ $user->position ?? '—' }}</p>
                    <p><b>Department</b>: {{ $user->departmentRelation->name ?? ($user->department ?? '—') }}</p>
                    <p><b>Supervisor</b>: {{ $user->supervisor->name ?? '—' }}</p>
                    <p><b>Employee ID</b>: {{ $user->employee_id ?? '—' }}</p>
                    <p><b>NRC #</b>: {{ $user->nrc ?? '—' }}</p>
                    <p><b>MAN Number</b>: {{ $user->man_number ?? '—' }}</p>
                    <p><b>Gender</b>: {{ $user->gender ? ucfirst($user->gender) : '—' }}</p>
                    <p><b>Date of Birth</b>: {{ $user->date_of_birth ? $user->date_of_birth->format('d M Y') : '—' }}</p>
                    <p><b>Date Joined</b>: {{ $user->date_joined ? $user->date_joined->format('d M Y') : '—' }}</p>
                    <p><b>Contract Type</b>: {{ $user->contract_type ? ucfirst($user->contract_type) : '—' }}</p>
                    <p><b>Address</b>: {{ $user->address ?? '—' }}</p>
                    <p><b>Emergency Contact</b>: {{ $user->emergency_contact_name ?? '—' }} {{ $user->emergency_contact_phone ? '('.$user->emergency_contact_phone.')' : '' }}</p>
                    <p><b>Status</b>: {{ $user->status->name ?? '--' }}</p>
                    <p><b>Total Logins</b>: {{ $user->logins ?? 0 }}</p>
                    <p class="mb-0"><b>Last Login</b>: {{ $user->last_login ?? '--' }}</p>
                </div>
                <div class="card-footer d-flex flex-wrap gap-2">
                    <button wire:click="togglePasswordReset" class="btn btn-warning btn-sm">Password Reset</button>
                    <button wire:click="toggleEdit" class="btn btn-primary btn-sm">Edit</button>
                    @if ($canManage)
                    <button onclick="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm">Delete</button>
                    @endif
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
                                <div class="col-12 mb-2"><h6 class="font-weight-bold text-primary border-bottom pb-1">Basic Info</h6></div>
                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userName">Name *</label>
                                    <input id="userName" type="text" class="form-control" wire:model.defer="name" required>
                                    @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userEmail">Email Address *</label>
                                    <input id="userEmail" type="email" class="form-control" wire:model.defer="email" required>
                                    @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userPhone">Phone *</label>
                                    <input id="userPhone" type="text" class="form-control" wire:model.defer="phone" required>
                                    @error('phone') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                @if ($canManage)
                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="userStatus">Status *</label>
                                    <select id="userStatus" class="form-control" wire:model.defer="status_id" required>
                                        <option value="">-- Select --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>
                                @endif

                                <div class="col-12 mb-2 mt-1"><h6 class="font-weight-bold text-primary border-bottom pb-1">Employment</h6></div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Employee ID</label>
                                    <input type="text" class="form-control" wire:model.defer="employee_id">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Position</label>
                                    <input type="text" class="form-control" wire:model.defer="position">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Department</label>
                                    <select class="form-control" wire:model.defer="department_id">
                                        <option value="">-- Select --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Supervisor</label>
                                    <select class="form-control" wire:model.defer="supervisor_id">
                                        <option value="">-- None --</option>
                                        @foreach($supervisors as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}{{ $sup->position ? ' ('.$sup->position.')' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">NRC #</label>
                                    <input type="text" class="form-control" wire:model.defer="nrc">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">MAN Number</label>
                                    <input type="text" class="form-control" wire:model.defer="man_number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Contract Type</label>
                                    <select class="form-control" wire:model.defer="contract_type">
                                        <option value="">-- Select --</option>
                                        <option value="permanent">Permanent</option>
                                        <option value="contract">Contract</option>
                                        <option value="part-time">Part-Time</option>
                                        <option value="intern">Intern</option>
                                        <option value="volunteer">Volunteer</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Gender</label>
                                    <select class="form-control" wire:model.defer="gender">
                                        <option value="">-- Select --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Date of Birth</label>
                                    <input type="date" class="form-control" wire:model.defer="date_of_birth">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Date Joined</label>
                                    <input type="date" class="form-control" wire:model.defer="date_joined">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold">Address</label>
                                    <input type="text" class="form-control" wire:model.defer="address">
                                </div>

                                <div class="col-12 mb-2 mt-1"><h6 class="font-weight-bold text-primary border-bottom pb-1">Emergency Contact</h6></div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Emergency Contact Name</label>
                                    <input type="text" class="form-control" wire:model.defer="emergency_contact_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold">Emergency Contact Phone</label>
                                    <input type="text" class="form-control" wire:model.defer="emergency_contact_phone">
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
            @if ($canManage)
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
            @endif

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
                                    @if ($canManage)
                                    <th style="width:100px;">Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user->roles as $index => $role)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>{{ $role->slug }}</td>
                                        @if ($canManage)
                                        <td>
                                            <button onclick="detachRole({{ $role->id }})" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $canManage ? 4 : 3 }}" class="text-center text-muted">No Roles Found.</td>
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
