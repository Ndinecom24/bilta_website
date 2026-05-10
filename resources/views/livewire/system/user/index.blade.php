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
                            {{-- Basic Info --}}
                            <div class="col-12 mb-2"><h6 class="font-weight-bold text-primary border-bottom pb-1">Basic Information</h6></div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="userName">Full Name *</label>
                                <input id="userName" type="text" class="form-control" wire:model.defer="name" required>
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="userEmail">Email Address *</label>
                                <input id="userEmail" type="email" class="form-control" wire:model.defer="email" required>
                                @error('email') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="userPhone">Phone *</label>
                                <input id="userPhone" type="text" class="form-control" wire:model.defer="phone" required>
                                @error('phone') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="userPassword">Password *</label>
                                <input id="userPassword" type="password" class="form-control" wire:model.defer="password" required autocomplete="new-password">
                                @error('password') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="userRole">Role *</label>
                                <select id="userRole" class="form-control" wire:model.defer="role_id" required>
                                    <option value="">-- Select --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold" for="userStatus">Status *</label>
                                <select id="userStatus" class="form-control" wire:model.defer="status_id" required>
                                    <option value="">-- Select --</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            {{-- HR / Employment Info --}}
                            <div class="col-12 mb-2 mt-2"><h6 class="font-weight-bold text-primary border-bottom pb-1">Employment Details</h6></div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Employee ID</label>
                                <input type="text" class="form-control" wire:model.defer="employee_id" placeholder="e.g. BLT-001">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Position / Title</label>
                                <input type="text" class="form-control" wire:model.defer="position" placeholder="e.g. Translator">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Department</label>
                                <select class="form-control" wire:model.defer="department_id">
                                    <option value="">-- Select --</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Supervisor</label>
                                <select class="form-control" wire:model.defer="supervisor_id">
                                    <option value="">-- None --</option>
                                    @foreach($supervisors as $sup)
                                        <option value="{{ $sup->id }}">{{ $sup->name }}{{ $sup->position ? ' ('.$sup->position.')' : '' }}</option>
                                    @endforeach
                                </select>
                                @error('supervisor_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">NRC #</label>
                                <input type="text" class="form-control" wire:model.defer="nrc" placeholder="NRC number">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">MAN Number</label>
                                <input type="text" class="form-control" wire:model.defer="man_number" placeholder="MAN number">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
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
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Gender</label>
                                <select class="form-control" wire:model.defer="gender">
                                    <option value="">-- Select --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Date of Birth</label>
                                <input type="date" class="form-control" wire:model.defer="date_of_birth">
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <label class="font-weight-bold">Date Joined</label>
                                <input type="date" class="form-control" wire:model.defer="date_joined">
                            </div>

                            {{-- Emergency Contact --}}
                            <div class="col-12 mb-2 mt-2"><h6 class="font-weight-bold text-primary border-bottom pb-1">Emergency Contact & Address</h6></div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Emergency Contact Name</label>
                                <input type="text" class="form-control" wire:model.defer="emergency_contact_name">
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Emergency Contact Phone</label>
                                <input type="text" class="form-control" wire:model.defer="emergency_contact_phone">
                            </div>
                            <div class="col-lg-4 col-md-6 mb-3">
                                <label class="font-weight-bold">Address</label>
                                <input type="text" class="form-control" wire:model.defer="address" placeholder="Physical address">
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
                                    <th>Department</th>
                                    <th>Supervisor</th>
                                    <th>Role Count</th>
                                    <th>Status</th>
                                    <th style="width: 120px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>
                                            {{ $user->name }}
                                            @if ($user->position)
                                                <br><small class="text-muted">{{ $user->position }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->departmentRelation->name ?? ($user->department ?? '—') }}</td>
                                        <td>{{ $user->supervisor->name ?? '—' }}</td>
                                        <td>{{ $user->roles->count() }}</td>
                                        <td>{{ $user->status->name ?? '--' }}</td>
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
                                        <td colspan="9" class="text-center text-muted">No Users Found.</td>
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
