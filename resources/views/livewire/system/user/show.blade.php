<div>
    {{-- ──────────── PAGE HEADER ──────────── --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">{{ $isOwnProfile ? 'My Profile' : 'User Profile' }}</h1>
            <p class="text-muted mb-0">{{ $isOwnProfile ? 'Manage your personal information and account settings.' : 'View and manage user account details.' }}</p>
        </div>
        <a href="{{ route('system.users') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Users
        </a>
    </div>

    {{-- ──────────── ALERTS ──────────── --}}
    <div class="row">
        <div class="col-md-12">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-1"></i> {{ session()->get('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session()->get('error') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif
        </div>
    </div>

    {{-- ──────────── OTP RESULT CARD (shown at top when active) ──────────── --}}
    @if ($lastOtp)
        <div class="card shadow-sm mb-4" style="border-left: 4px solid #dc2626;">
            <div class="card-header d-flex align-items-center justify-content-between py-2" style="background: #fef2f2;">
                <h6 class="mb-0 text-danger"><i class="fas fa-key mr-1"></i> Password Reset OTP Generated</h6>
                <button wire:click="dismissOtp" type="button" class="btn btn-sm btn-outline-secondary">Dismiss</button>
            </div>
            <div class="card-body py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-1">OTP generated for <strong>{{ $otpResetUser }}</strong></p>
                        @if ($otpEmailSent)
                            <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Email sent</span>
                        @endif
                        @if ($otpEmailFailed)
                            <span class="badge badge-danger"><i class="fas fa-times mr-1"></i> Email failed — share OTP manually</span>
                        @endif
                    </div>
                    <div class="col-md-6 text-center">
                        <div class="p-2 rounded d-inline-block" style="background: #fef2f2; border: 2px dashed #fca5a5;">
                            <small class="d-block text-muted text-uppercase font-weight-bold" style="letter-spacing: 2px; font-size: .65rem;">One-Time Password</small>
                            <span id="otpDisplay" style="font-size: 1.6rem; font-weight: 800; letter-spacing: 6px; color: #dc2626; font-family: 'Courier New', monospace;">{{ $lastOtp }}</span>
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm ml-2" onclick="copyOtp()">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
                <small class="text-muted d-block mt-2"><i class="fas fa-info-circle mr-1 text-warning"></i> User logs in with this OTP and will be prompted to set a new password. Expires in 72 hours.</small>
            </div>
        </div>
    @endif

    <div class="row">
        {{-- ──────────── LEFT: PROFILE CARD ──────────── --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 overflow-hidden">
                {{-- Profile header gradient --}}
                <div class="text-center py-4 position-relative" style="background: linear-gradient(135deg, #111147 0%, #1d4ed8 100%);">
                    @php
                        $photoUrl = $user->profile_photo_url;
                        $initials = $user->initials;
                        $bgColors = ['#dc2626','#2563eb','#059669','#d97706','#7c3aed','#0891b2','#be185d','#4f46e5'];
                        $colorIndex = crc32($user->name ?? 'U') % count($bgColors);
                    @endphp

                    {{-- Avatar --}}
                    <div class="mx-auto mb-3 position-relative" style="width: 110px; height: 110px;">
                        @if ($profile_photo)
                            {{-- Live preview of upload --}}
                            <img src="{{ $profile_photo->temporaryUrl() }}"
                                class="rounded-circle border border-3 border-white shadow"
                                style="width: 110px; height: 110px; object-fit: cover;"
                                alt="Preview">
                        @elseif ($photoUrl)
                            <img src="{{ $photoUrl }}"
                                class="rounded-circle border border-3 border-white shadow"
                                style="width: 110px; height: 110px; object-fit: cover;"
                                alt="{{ $user->name }}">
                        @else
                            <div class="rounded-circle border border-3 border-white shadow d-flex align-items-center justify-content-center"
                                style="width: 110px; height: 110px; background: {{ $bgColors[$colorIndex] }}; font-size: 2.2rem; font-weight: 800; color: #fff; letter-spacing: 2px;">
                                {{ $initials }}
                            </div>
                        @endif

                        {{-- Camera overlay button --}}
                        <label for="profilePhotoInput" class="position-absolute d-flex align-items-center justify-content-center"
                            style="bottom: 2px; right: 2px; width: 32px; height: 32px; background: #fff; border-radius: 50%; cursor: pointer; box-shadow: 0 2px 8px rgba(0,0,0,.15); border: 2px solid #e2e8f0;"
                            title="Change photo">
                            <i class="fas fa-camera" style="font-size: .8rem; color: #475569;"></i>
                        </label>
                        <input type="file" id="profilePhotoInput" wire:model="profile_photo" accept="image/*" class="d-none">
                    </div>

                    {{-- Upload actions (shown when file selected) --}}
                    @if ($profile_photo)
                        <div class="d-flex justify-content-center gap-2 mb-2">
                            <button wire:click="uploadProfilePhoto" class="btn btn-sm btn-light font-weight-bold">
                                <i class="fas fa-check mr-1 text-success"></i> Save Photo
                            </button>
                            <button wire:click="$set('profile_photo', null)" class="btn btn-sm btn-outline-light">Cancel</button>
                        </div>
                    @elseif ($photoUrl)
                        <button wire:click="removeProfilePhoto" class="btn btn-sm btn-link text-white-50" style="font-size: .75rem;"
                            onclick="return confirm('Remove profile photo?')">
                            <i class="fas fa-trash-alt mr-1"></i> Remove photo
                        </button>
                    @endif

                    <div wire:loading wire:target="profile_photo" class="text-white-50" style="font-size: .8rem;">
                        <span class="spinner-border spinner-border-sm mr-1"></span> Uploading...
                    </div>

                    {{-- Name & Position --}}
                    <h5 class="text-white font-weight-bold mb-0">{{ $user->name }}</h5>
                    @if ($user->position)
                        <small class="text-white" style="opacity: .8;">{{ $user->position }}</small>
                    @endif
                </div>

                {{-- Quick info --}}
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center py-2 px-3">
                            <i class="fas fa-envelope fa-fw mr-3 text-muted" style="font-size: .85rem;"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Email</small>
                                <span style="font-size: .88rem;">{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center py-2 px-3">
                            <i class="fas fa-phone fa-fw mr-3 text-muted" style="font-size: .85rem;"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Phone</small>
                                <span style="font-size: .88rem;">{{ $user->phone }}</span>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center py-2 px-3">
                            <i class="fas fa-building fa-fw mr-3 text-muted" style="font-size: .85rem;"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Department</small>
                                <span style="font-size: .88rem;">{{ $user->departmentRelation->name ?? ($user->department ?? '—') }}</span>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center py-2 px-3">
                            <i class="fas fa-user-tie fa-fw mr-3 text-muted" style="font-size: .85rem;"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Supervisor</small>
                                <span style="font-size: .88rem;">{{ $user->supervisor->name ?? '—' }}</span>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center py-2 px-3">
                            <i class="fas fa-shield-alt fa-fw mr-3 text-muted" style="font-size: .85rem;"></i>
                            <div>
                                <small class="text-muted d-block" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Status</small>
                                @php $statusName = $user->status->name ?? 'Unknown'; @endphp
                                <span class="badge {{ strtolower($statusName) === 'active' ? 'badge-success' : 'badge-secondary' }}">{{ $statusName }}</span>
                                @if ($user->password_change == 1)
                                    <span class="badge badge-warning text-dark ml-1"><i class="fas fa-key mr-1"></i> OTP Reset</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Roles badges --}}
                <div class="card-body border-top py-2 px-3">
                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Roles</small>
                    @forelse ($user->roles as $role)
                        <span class="badge badge-primary mr-1 mb-1" style="font-size: .75rem;">{{ $role->name }}</span>
                    @empty
                        <span class="text-muted" style="font-size: .82rem;">No roles assigned</span>
                    @endforelse
                </div>

                {{-- Login stats --}}
                <div class="card-body border-top py-2 px-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted d-block" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Total Logins</small>
                            <span class="font-weight-bold">{{ $user->logins ?? 0 }}</span>
                        </div>
                        <div class="text-right">
                            <small class="text-muted d-block" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Last Login</small>
                            <span style="font-size: .85rem;">{{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d M Y H:i') : 'Never' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="card-footer bg-white d-flex flex-wrap gap-1 py-2">
                    <button wire:click="setTab('edit')" class="btn btn-sm {{ $activeTab === 'edit' ? 'btn-primary' : 'btn-outline-primary' }}">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </button>
                    <button wire:click="setTab('security')" class="btn btn-sm {{ $activeTab === 'security' ? 'btn-warning' : 'btn-outline-warning' }}">
                        <i class="fas fa-lock mr-1"></i> Security
                    </button>
                    @if ($canManage)
                        <button onclick="deleteUser({{ $user->id }})" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash-alt mr-1"></i> Delete
                        </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- ──────────── RIGHT: TABBED CONTENT ──────────── --}}
        <div class="col-lg-8 mb-4">

            {{-- Tab navigation --}}
            <ul class="nav nav-tabs mb-0" style="border-bottom: 2px solid #e2e8f0;">
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'profile' ? 'active font-weight-bold' : '' }}" href="#" wire:click.prevent="setTab('profile')" style="border-radius: 8px 8px 0 0;">
                        <i class="fas fa-user mr-1"></i> Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'employment' ? 'active font-weight-bold' : '' }}" href="#" wire:click.prevent="setTab('employment')" style="border-radius: 8px 8px 0 0;">
                        <i class="fas fa-briefcase mr-1"></i> Employment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'files' ? 'active font-weight-bold' : '' }}" href="#" wire:click.prevent="setTab('files')" style="border-radius: 8px 8px 0 0;">
                        <i class="fas fa-folder-open mr-1"></i> User Files
                        @if(!empty($userFiles))
                            <span class="badge badge-light ml-1">{{ count($userFiles) }}</span>
                        @endif
                    </a>
                </li>
                @if ($canManage)
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'roles' ? 'active font-weight-bold' : '' }}" href="#" wire:click.prevent="setTab('roles')" style="border-radius: 8px 8px 0 0;">
                        <i class="fas fa-user-shield mr-1"></i> Roles
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'edit' ? 'active font-weight-bold' : '' }}" href="#" wire:click.prevent="setTab('edit')" style="border-radius: 8px 8px 0 0;">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $activeTab === 'security' ? 'active font-weight-bold' : '' }}" href="#" wire:click.prevent="setTab('security')" style="border-radius: 8px 8px 0 0;">
                        <i class="fas fa-lock mr-1"></i> Security
                    </a>
                </li>
            </ul>

            {{-- ═══════════ TAB: PROFILE ═══════════ --}}
            @if ($activeTab === 'profile')
                <div class="card shadow-sm border-top-0" style="border-radius: 0 0 8px 8px;">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-id-card mr-1"></i> Personal Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Full Name</small>
                                    <span class="font-weight-bold">{{ $user->name }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Gender</small>
                                    <span class="font-weight-bold">{{ $user->gender ? ucfirst($user->gender) : '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Date of Birth</small>
                                    <span class="font-weight-bold">{{ $user->date_of_birth ? $user->date_of_birth->format('d M Y') : '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">NRC Number</small>
                                    <span class="font-weight-bold">{{ $user->nrc ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Address</small>
                                    <span class="font-weight-bold">{{ $user->address ?? '—' }}</span>
                                </div>
                            </div>
                        </div>

                        <h6 class="font-weight-bold text-primary mb-3 mt-2"><i class="fas fa-phone-alt mr-1"></i> Contact Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Email</small>
                                    <span class="font-weight-bold">{{ $user->email }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Phone</small>
                                    <span class="font-weight-bold">{{ $user->phone }}</span>
                                </div>
                            </div>
                        </div>

                        <h6 class="font-weight-bold text-danger mb-3 mt-2"><i class="fas fa-ambulance mr-1"></i> Emergency Contact</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #fef2f2;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Contact Name</small>
                                    <span class="font-weight-bold">{{ $user->emergency_contact_name ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #fef2f2;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Contact Phone</small>
                                    <span class="font-weight-bold">{{ $user->emergency_contact_phone ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ═══════════ TAB: EMPLOYMENT ═══════════ --}}
            @if ($activeTab === 'employment')
                <div class="card shadow-sm border-top-0" style="border-radius: 0 0 8px 8px;">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-id-badge mr-1"></i> Employment Details</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Employee ID</small>
                                    <span class="font-weight-bold">{{ $user->employee_id ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">MAN Number</small>
                                    <span class="font-weight-bold">{{ $user->man_number ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Position</small>
                                    <span class="font-weight-bold">{{ $user->position ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Department</small>
                                    <span class="font-weight-bold">{{ $user->departmentRelation->name ?? ($user->department ?? '—') }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Supervisor</small>
                                    <span class="font-weight-bold">{{ $user->supervisor->name ?? '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Contract Type</small>
                                    <span class="font-weight-bold">{{ $user->contract_type ? ucfirst($user->contract_type) : '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">Date Joined</small>
                                    <span class="font-weight-bold">{{ $user->date_joined ? $user->date_joined->format('d M Y') : '—' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 rounded" style="background: #f8fafc;">
                                    <small class="text-muted d-block mb-1" style="font-size: .7rem; text-transform: uppercase; letter-spacing: 1px;">NRC Number</small>
                                    <span class="font-weight-bold">{{ $user->nrc ?? '—' }}</span>
                                </div>
                            </div>
                        </div>

                        <h6 class="font-weight-bold text-primary mb-3 mt-2"><i class="fas fa-chart-line mr-1"></i> Account Activity</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="text-center p-3 rounded" style="background: #eff6ff;">
                                    <div style="font-size: 1.8rem; font-weight: 800; color: #2563eb;">{{ $user->logins ?? 0 }}</div>
                                    <small class="text-muted text-uppercase font-weight-bold" style="letter-spacing: 1px; font-size: .68rem;">Total Logins</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center p-3 rounded" style="background: #f0fdf4;">
                                    <div style="font-size: 1.1rem; font-weight: 700; color: #059669;">
                                        {{ $user->last_login ? \Carbon\Carbon::parse($user->last_login)->format('d M Y') : '—' }}
                                    </div>
                                    <small class="text-muted text-uppercase font-weight-bold" style="letter-spacing: 1px; font-size: .68rem;">Last Login</small>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="text-center p-3 rounded" style="background: #fefce8;">
                                    <div style="font-size: 1.1rem; font-weight: 700; color: #d97706;">
                                        {{ $user->created_at ? $user->created_at->format('d M Y') : '—' }}
                                    </div>
                                    <small class="text-muted text-uppercase font-weight-bold" style="letter-spacing: 1px; font-size: .68rem;">Account Created</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ═══════════ TAB: USER FILES ═══════════ --}}
            @if ($activeTab === 'files')
                <div class="card shadow-sm border-top-0" style="border-radius: 0 0 8px 8px;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold text-primary mb-0"><i class="fas fa-folder-open mr-1"></i> Employee Documents</h6>
                            <span class="badge badge-secondary">{{ count($userFiles) }} file(s)</span>
                        </div>

                        @if($canManageUserFiles)
                            <div class="p-3 rounded mb-4" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                <h6 class="font-weight-bold mb-3" style="font-size: .95rem;"><i class="fas fa-upload mr-1 text-success"></i> Upload New File</h6>
                                <form wire:submit.prevent="uploadUserFile">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="userFileType" class="font-weight-bold" style="font-size: .85rem;">File Type *</label>
                                            <select id="userFileType" class="form-control" wire:model.defer="user_file_type" required>
                                                @foreach($userFileTypeOptions as $typeValue => $typeLabel)
                                                    <option value="{{ $typeValue }}">{{ $typeLabel }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_file_type') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="userFileTitle" class="font-weight-bold" style="font-size: .85rem;">Title (Optional)</label>
                                            <input id="userFileTitle" type="text" class="form-control" wire:model.defer="user_file_title" placeholder="e.g. 2026 Offer Letter">
                                            @error('user_file_title') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="userFileInput" class="font-weight-bold" style="font-size: .85rem;">Document File *</label>
                                            <input id="userFileInput" type="file" class="form-control" wire:model="user_file" required>
                                            @error('user_file') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="userFileDescription" class="font-weight-bold" style="font-size: .85rem;">Description (Optional)</label>
                                            <textarea id="userFileDescription" class="form-control" rows="2" wire:model.defer="user_file_description" placeholder="Any notes about this document"></textarea>
                                            @error('user_file_description') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled" wire:target="uploadUserFile,user_file">
                                            <i class="fas fa-save mr-1"></i> Upload File
                                        </button>
                                        <div wire:loading wire:target="uploadUserFile,user_file" class="text-muted ml-3" style="font-size: .85rem;">
                                            <span class="spinner-border spinner-border-sm mr-1"></span> Uploading...
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th style="width: 45px;">#</th>
                                        <th>File</th>
                                        <th>Type</th>
                                        <th>Uploaded</th>
                                        <th>By</th>
                                        <th style="width: 180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($userFiles as $index => $file)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <div class="font-weight-bold">{{ $file->title ?: $file->file_name }}</div>
                                                <div class="text-muted" style="font-size: .78rem;">
                                                    {{ $file->file_name }} • {{ $this->formatFileSize($file->file_size) }}
                                                </div>
                                                @if($file->description)
                                                    <div class="text-muted" style="font-size: .78rem;">{{ $file->description }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-info" style="font-size: .72rem;">{{ $this->userFileTypeLabel($file->file_type) }}</span>
                                            </td>
                                            <td>{{ $file->created_at ? $file->created_at->format('d M Y H:i') : '—' }}</td>
                                            <td>{{ $file->uploader->name ?? 'System' }}</td>
                                            <td>
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2" title="View">
                                                    <i class="fas fa-eye mr-1"></i>View
                                                </a>
                                                <a href="{{ asset('storage/' . $file->file_path) }}" download class="btn btn-sm btn-outline-success py-0 px-2" title="Download">
                                                    <i class="fas fa-download mr-1"></i>Download
                                                </a>
                                                @if($canManageUserFiles)
                                                    <button wire:click="deleteUserFile({{ $file->id }})" type="button" class="btn btn-sm btn-outline-danger py-0 px-2"
                                                        onclick="return confirm('Delete this file?')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                <i class="fas fa-folder-open fa-2x d-block mb-2 text-muted"></i>
                                                No employee files uploaded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            {{-- ═══════════ TAB: ROLES ═══════════ --}}
            @if ($activeTab === 'roles' && $canManage)
                <div class="card shadow-sm border-top-0" style="border-radius: 0 0 8px 8px;">
                    <div class="card-body">
                        {{-- Assigned Roles --}}
                        <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-user-tag mr-1"></i> Assigned Roles <span class="badge badge-light ml-1">{{ $user->roles->count() }}</span></h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-sm table-hover mb-0">
                                <thead style="background: #f8fafc;">
                                    <tr>
                                        <th style="width: 40px;">#</th>
                                        <th>Role</th>
                                        <th>Slug</th>
                                        <th style="width: 100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($user->roles as $index => $role)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><span class="font-weight-bold">{{ $role->name }}</span></td>
                                            <td><code>{{ $role->slug }}</code></td>
                                            <td>
                                                <button onclick="detachRole({{ $role->id }})" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: .78rem;">
                                                    <i class="fas fa-times mr-1"></i> Remove
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">No roles assigned.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- Attach Roles --}}
                        @if ($all_roles->count() > 0)
                            <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-plus-circle mr-1"></i> Attach Roles</h6>
                            <div class="table-responsive mb-3">
                                <table class="table table-sm table-hover mb-0">
                                    <thead style="background: #f8fafc;">
                                        <tr>
                                            <th style="width: 40px;"></th>
                                            <th>Role</th>
                                            <th>Slug</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($all_roles as $role)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" wire:model="selectedRoles" value="{{ $role->id }}">
                                                </td>
                                                <td>{{ $role->name }}</td>
                                                <td><code>{{ $role->slug }}</code></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <button wire:click="attachRole" type="button" class="btn btn-primary btn-sm" @if (count($selectedRoles) === 0) disabled @endif>
                                <i class="fas fa-link mr-1"></i> Attach Selected Roles
                            </button>
                        @else
                            <div class="text-center py-3 text-muted">
                                <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                                All available roles are already assigned.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- ═══════════ TAB: EDIT ═══════════ --}}
            @if ($activeTab === 'edit')
                <div class="card shadow-sm border-top-0" style="border-radius: 0 0 8px 8px;">
                    <div class="card-body">
                        <form wire:submit.prevent="update">
                            <div class="row">
                                <div class="col-12 mb-2"><h6 class="font-weight-bold text-primary"><i class="fas fa-user mr-1"></i> Basic Information</h6></div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Full Name *</label>
                                    <input type="text" class="form-control" wire:model.defer="name" required>
                                    @error('name') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Email Address *</label>
                                    <input type="email" class="form-control" wire:model.defer="email" required>
                                    @error('email') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Phone *</label>
                                    <input type="text" class="form-control" wire:model.defer="phone" required>
                                    @error('phone') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                </div>
                                @if ($canManage)
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Status *</label>
                                    <select class="form-control" wire:model.defer="status_id" required>
                                        <option value="">-- Select --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                </div>
                                @endif
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Gender</label>
                                    <select class="form-control" wire:model.defer="gender">
                                        <option value="">-- Select --</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Date of Birth</label>
                                    <input type="date" class="form-control" wire:model.defer="date_of_birth">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Address</label>
                                    <input type="text" class="form-control" wire:model.defer="address">
                                </div>

                                <div class="col-12 mb-2 mt-1"><h6 class="font-weight-bold text-primary"><i class="fas fa-briefcase mr-1"></i> Employment</h6></div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Employee ID</label>
                                    <input type="text" class="form-control" wire:model.defer="employee_id">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Position</label>
                                    <input type="text" class="form-control" wire:model.defer="position">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Department</label>
                                    <select class="form-control" wire:model.defer="department_id">
                                        <option value="">-- Select --</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Supervisor</label>
                                    <select class="form-control" wire:model.defer="supervisor_id">
                                        <option value="">-- None --</option>
                                        @foreach($supervisors as $sup)
                                            <option value="{{ $sup->id }}">{{ $sup->name }}{{ $sup->position ? ' ('.$sup->position.')' : '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">NRC #</label>
                                    <input type="text" class="form-control" wire:model.defer="nrc">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">MAN Number</label>
                                    <input type="text" class="form-control" wire:model.defer="man_number">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Contract Type</label>
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
                                    <label class="font-weight-bold" style="font-size: .85rem;">Date Joined</label>
                                    <input type="date" class="form-control" wire:model.defer="date_joined">
                                </div>

                                <div class="col-12 mb-2 mt-1"><h6 class="font-weight-bold text-danger"><i class="fas fa-ambulance mr-1"></i> Emergency Contact</h6></div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Emergency Contact Name</label>
                                    <input type="text" class="form-control" wire:model.defer="emergency_contact_name">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Emergency Contact Phone</label>
                                    <input type="text" class="form-control" wire:model.defer="emergency_contact_phone">
                                </div>
                            </div>

                            <hr>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save mr-1"></i> Save Changes
                                </button>
                                <button wire:click.prevent="setTab('profile')" type="button" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            {{-- ═══════════ TAB: SECURITY ═══════════ --}}
            @if ($activeTab === 'security')
                <div class="card shadow-sm border-top-0" style="border-radius: 0 0 8px 8px;">
                    <div class="card-body">
                        {{-- Password Change Section --}}
                        <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-key mr-1"></i> Change Password</h6>
                        <p class="text-muted mb-3" style="font-size: .88rem;">Set a new password manually. The user will use this password on their next login.</p>
                        <form wire:submit.prevent="updatePassword">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">New Password</label>
                                    <input type="password" class="form-control" wire:model.defer="password" autocomplete="new-password" required placeholder="Minimum 8 characters">
                                    @error('password') <span class="text-danger d-block" style="font-size: .82rem;">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" style="font-size: .85rem;">Confirm Password</label>
                                    <input type="password" class="form-control" wire:model.defer="password_confirmation" autocomplete="new-password" required placeholder="Re-enter password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-lock mr-1"></i> Reset Password
                            </button>
                        </form>

                        @if ($canManage && !$isOwnProfile)
                            <hr class="my-4">
                            <h6 class="font-weight-bold text-danger mb-3"><i class="fas fa-paper-plane mr-1"></i> OTP Password Reset</h6>
                            <div class="p-3 rounded mb-3" style="background: #fef2f2; border: 1px solid #fecaca;">
                                <p class="mb-2" style="font-size: .88rem;">
                                    <i class="fas fa-info-circle text-danger mr-1"></i>
                                    This generates a <strong>6-digit one-time password</strong>, sends it to the user's email, and forces them to change their password on next login.
                                </p>
                                <ul class="mb-0 pl-3" style="font-size: .82rem; color: #6b7280;">
                                    <li>The OTP replaces the user's current password</li>
                                    <li>The OTP is shown to you in case the email fails</li>
                                    <li>The OTP expires after 72 hours</li>
                                </ul>
                            </div>
                            <button wire:click="resetPasswordWithOtp" class="btn btn-outline-danger"
                                onclick="return confirm('This will reset the user\'s password and send them a one-time password via email. Continue?')">
                                <i class="fas fa-key mr-1"></i> Generate & Send OTP
                            </button>
                        @endif

                        @if ($user->password_change == 1)
                            <hr class="my-4">
                            <div class="p-3 rounded" style="background: #fffbeb; border: 1px solid #fde68a;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle text-warning mr-2" style="font-size: 1.3rem;"></i>
                                    <div>
                                        <strong class="text-dark">Password change pending</strong>
                                        <p class="mb-0 text-muted" style="font-size: .82rem;">This user will be required to set a new password on their next login.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function detachRole(id) {
            if (confirm("Are you sure to detach this role?")) {
                window.livewire.emit('detachRole', id);
            }
        }

        function deleteUser(id) {
            if (confirm("Are you sure to delete this user? This action cannot be undone.")) {
                window.livewire.emit('deleteUser', id);
            }
        }

        function copyOtp() {
            var otp = document.getElementById('otpDisplay');
            if (otp) {
                var text = otp.innerText.trim();
                navigator.clipboard.writeText(text).then(function() {
                    alert('OTP copied to clipboard!');
                }).catch(function() {
                    var ta = document.createElement('textarea');
                    ta.value = text;
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                    alert('OTP copied to clipboard!');
                });
            }
        }
    </script>
</div>
