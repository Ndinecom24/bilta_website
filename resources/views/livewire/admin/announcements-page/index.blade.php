<div>

    {{-- PAGE HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-bullhorn text-primary mr-2"></i>Memos & Announcements
            </h1>
            <p class="mb-0 text-muted small">Create, manage, and publish internal communications.</p>
        </div>
        <div class="d-flex align-items-center" style="gap: 10px;">
            <button wire:click="$toggle('showArchived')" class="btn btn-sm {{ $showArchived ? 'btn-warning' : 'btn-outline-warning' }} rounded-pill px-3">
                <i class="fas fa-archive mr-1"></i> {{ $showArchived ? 'Viewing Archived' : 'View Archived' }}
            </button>
        </div>
    </div>

    {{-- ALERTS --}}
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3" role="alert">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-lg mb-3 d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session()->get('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger border-0 shadow-sm rounded-lg mb-3 d-flex align-items-center" role="alert">
            <i class="fas fa-times-circle mr-2"></i> {{ session()->get('error') }}
        </div>
    @endif

    {{-- FORM CARD --}}
    <div class="card shadow mb-4 border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header py-3 d-flex align-items-center justify-content-between"
             style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); border: none;">
            <h5 class="mb-0 text-white font-weight-bold">
                <i class="fas {{ $updateItem ? 'fa-edit' : 'fa-plus-circle' }} mr-2"></i>
                {{ $updateItem ? 'Edit' : 'Create' }} {{ ucfirst($type) }}
            </h5>
            @if ($updateItem)
                <button wire:click="cancel" type="button" class="btn btn-sm btn-light rounded-pill px-3 font-weight-bold shadow-sm">
                    <i class="fas fa-plus mr-1"></i> Create New
                </button>
            @endif
        </div>

        <div class="card-body p-4">
            <form wire:submit.prevent="{{ $updateItem ? 'update' : 'store' }}" enctype="multipart/form-data">

                {{-- Basic Info --}}
                <div class="row mb-3">
                    <div class="col-lg-6 mb-3">
                        <label class="font-weight-bold small text-gray-700">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                               wire:model.defer="title" placeholder="Enter title" style="border-radius: 10px;">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="font-weight-bold small text-gray-700">Type <span class="text-danger">*</span></label>
                        <select class="form-control @error('type') is-invalid @enderror" wire:model.defer="type" style="border-radius: 10px;">
                            <option value="announcement">Announcement</option>
                            <option value="memo">Memo</option>
                        </select>
                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="font-weight-bold small text-gray-700">Priority <span class="text-danger">*</span></label>
                        <select class="form-control @error('priority') is-invalid @enderror" wire:model.defer="priority" style="border-radius: 10px;">
                            <option value="low">Low</option>
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                        </select>
                        @error('priority') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Dates & Status --}}
                <div class="row mb-3">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="font-weight-bold small text-gray-700">Publish Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('publish_date') is-invalid @enderror"
                               wire:model.defer="publish_date" style="border-radius: 10px;">
                        @error('publish_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="font-weight-bold small text-gray-700">Expiry Date <span class="text-muted">(optional)</span></label>
                        <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                               wire:model.defer="expiry_date" style="border-radius: 10px;">
                        @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="font-weight-bold small text-gray-700">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status_id') is-invalid @enderror" wire:model.defer="status_id" style="border-radius: 10px;">
                            <option value="">-- Select --</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('status_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-lg-3 col-md-6 mb-3">
                        <label class="font-weight-bold small text-gray-700">Visibility</label>
                        <select class="form-control @error('visibility') is-invalid @enderror" wire:model="visibility" style="border-radius: 10px;">
                            <option value="all">All Employees</option>
                            <option value="department">Specific Departments</option>
                            <option value="specific">Specific Employees</option>
                        </select>
                        @error('visibility') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Conditional: Department multi-select --}}
                @if ($visibility === 'department')
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="font-weight-bold small text-gray-700">
                                <i class="fas fa-building mr-1 text-primary"></i> Select Departments <span class="text-danger">*</span>
                            </label>
                            <div class="border rounded-lg p-3 bg-light" style="border-radius: 10px !important; max-height: 220px; overflow-y: auto;">
                                @foreach ($departments as $dept)
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input type="checkbox" class="custom-control-input" id="dept_{{ $dept->id }}"
                                               wire:model.defer="selectedDepartments" value="{{ $dept->id }}">
                                        <label class="custom-control-label d-flex align-items-center justify-content-between" for="dept_{{ $dept->id }}">
                                            <span>{{ $dept->name }}</span>
                                            <span class="badge badge-primary badge-pill ml-2" style="font-size: .7rem;">
                                                {{ $dept->members()->count() }} {{ Str::plural('member', $dept->members()->count()) }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedDepartments') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror

                            {{-- Preview employees in selected departments --}}
                            @if (!empty($selectedDepartments))
                                @php
                                    $deptUsers = $users->whereIn('department_id', $selectedDepartments);
                                @endphp
                                @if ($deptUsers->count())
                                    <div class="mt-2 border rounded-lg p-3" style="border-radius: 10px !important; max-height: 200px; overflow-y: auto; background: #f0f7ff;">
                                        <small class="font-weight-bold text-primary d-block mb-2">
                                            <i class="fas fa-users mr-1"></i> {{ $deptUsers->count() }} {{ Str::plural('employee', $deptUsers->count()) }} will be notified:
                                        </small>
                                        <div class="d-flex flex-wrap" style="gap: 6px;">
                                            @foreach ($deptUsers as $u)
                                                <span class="badge badge-light border px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                                    {{ $u->name }}
                                                    @if ($u->position) <small class="text-muted">({{ $u->position }})</small> @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Conditional: Employee multi-select --}}
                @if ($visibility === 'specific')
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="font-weight-bold small text-gray-700">
                                <i class="fas fa-user-check mr-1 text-success"></i> Select Employees <span class="text-danger">*</span>
                            </label>
                            <div class="border rounded-lg p-3 bg-light" style="border-radius: 10px !important; max-height: 300px; overflow-y: auto;">
                                @php
                                    $groupedUsers = $users->groupBy(function ($u) {
                                        return $u->departmentRelation->name ?? 'No Department';
                                    })->sortKeys();
                                @endphp
                                @foreach ($groupedUsers as $deptName => $deptMembers)
                                    <div class="mb-3">
                                        <small class="font-weight-bold text-uppercase text-muted d-block mb-1" style="font-size: .7rem; letter-spacing: .05em;">
                                            <i class="fas fa-building mr-1"></i> {{ $deptName }}
                                        </small>
                                        @foreach ($deptMembers as $emp)
                                            <div class="custom-control custom-checkbox ml-3 mb-1">
                                                <input type="checkbox" class="custom-control-input" id="user_{{ $emp->id }}"
                                                       wire:model.defer="selectedUsers" value="{{ $emp->id }}">
                                                <label class="custom-control-label" for="user_{{ $emp->id }}">
                                                    {{ $emp->name }}
                                                    @if ($emp->position) <small class="text-muted">({{ $emp->position }})</small> @endif
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedUsers') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror

                            {{-- Selection summary --}}
                            @if (!empty($selectedUsers))
                                <div class="mt-2 border rounded-lg p-2" style="border-radius: 10px !important; background: #f0fff4;">
                                    <small class="font-weight-bold text-success">
                                        <i class="fas fa-check-circle mr-1"></i> {{ count($selectedUsers) }} {{ Str::plural('employee', count($selectedUsers)) }} selected
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Send Email Notification Toggle --}}
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="sendEmailToggle" wire:model.defer="sendEmail">
                            <label class="custom-control-label font-weight-bold small text-gray-700" for="sendEmailToggle">
                                <i class="fas fa-envelope mr-1 text-info"></i> Send email notification to targeted employees
                            </label>
                        </div>
                        <small class="text-muted ml-4 pl-2">When enabled, an email will be sent to all employees matching the visibility selection above.</small>
                    </div>
                </div>

                {{-- Content --}}
                <div class="mb-3">
                    <label class="font-weight-bold small text-gray-700">Content</label>
                    <input id="announcementContent" type="hidden" wire:model.defer="content">
                    <div class="border rounded-lg overflow-hidden" style="border-radius: 10px !important;">
                        <trix-editor input="announcementContent" class="bg-white" style="min-height: 250px;"></trix-editor>
                    </div>
                    @error('content') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Attachments --}}
                <div class="mb-3">
                    <label class="font-weight-bold small text-gray-700">
                        <i class="fas fa-paperclip mr-1"></i> Attachments <span class="text-muted font-weight-normal">(optional)</span>
                    </label>
                    <div class="custom-file-upload position-relative border rounded-lg p-3 text-center bg-light" style="border-radius: 10px !important; border-style: dashed !important; cursor: pointer;">
                        <input type="file" class="position-absolute w-100 h-100" style="top:0;left:0;opacity:0;cursor:pointer;" wire:model="attachments" multiple>
                        <div>
                            <i class="fas fa-cloud-upload-alt text-primary mb-2" style="font-size: 1.5rem;"></i>
                            <p class="mb-0 small text-muted">Click or drag to upload files (PDF, Word, Excel, Images, ZIP)</p>
                            <small class="text-muted">Max 20 MB per file &bull; Multiple allowed</small>
                        </div>
                        <div wire:loading wire:target="attachments" class="mt-2">
                            <div class="spinner-border spinner-border-sm text-primary"></div>
                            <small class="text-primary ml-1">Uploading...</small>
                        </div>
                    </div>
                    @error('attachments.*') <span class="text-danger small d-block mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Existing attachments when editing --}}
                @if ($updateItem && $announcement)
                    @php $existingFiles = $announcement->getMedia('announcement_attachments'); @endphp
                    @if ($existingFiles->count())
                        <div class="mb-3">
                            <label class="font-weight-bold small text-gray-700">Existing Attachments</label>
                            @foreach ($existingFiles as $media)
                                <div class="d-flex align-items-center justify-content-between bg-white border rounded-lg p-2 mb-2" style="border-radius: 10px !important;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file text-muted mr-2"></i>
                                        <div>
                                            <small class="font-weight-bold text-gray-700 d-block">{{ $media->file_name }}</small>
                                            <small class="text-muted">{{ round($media->size / 1024) }} KB</small>
                                        </div>
                                    </div>
                                    <button wire:click.prevent="removeFile({{ $media->id }})" type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                        <i class="fas fa-trash-alt mr-1"></i> Remove
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

                {{-- Submit --}}
                <div class="border-top pt-3">
                    <div class="d-flex flex-wrap align-items-center" style="gap: 10px;">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold shadow-sm">
                            <i class="fas {{ $updateItem ? 'fa-save' : 'fa-paper-plane' }} mr-2"></i>
                            {{ $updateItem ? 'Update' : 'Save' }}
                        </button>
                        @if ($updateItem)
                            <button wire:click.prevent="cancel" type="button" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                        @endif
                        <div wire:loading class="ml-2">
                            <span class="spinner-border spinner-border-sm text-primary"></span>
                            <span class="text-primary small ml-1">Processing...</span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- RECORDS TABLE --}}
    <div class="card shadow mb-4 border-0" style="border-radius: 16px; overflow: hidden;">
        <div class="card-header py-3 d-flex align-items-center justify-content-between"
             style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); border: none;">
            <h5 class="mb-0 text-white font-weight-bold">
                <i class="fas fa-list-alt mr-2"></i> {{ $showArchived ? 'Archived' : 'Active' }} Records
            </h5>
            <span class="badge badge-light px-3 py-2 font-weight-bold" style="border-radius: 50px;">
                {{ $announcements->total() }} total
            </span>
        </div>

        <div class="card-body pb-0">
            {{-- Filters --}}
            <div class="row mb-3">
                <div class="col-lg-3 col-md-6 mb-2">
                    <input type="text" class="form-control form-control-sm" style="border-radius: 8px;" wire:model.debounce.300ms="search" placeholder="Search by title...">
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <select class="form-control form-control-sm" style="border-radius: 8px;" wire:model="filterType">
                        <option value="">All Types</option>
                        <option value="memo">Memos</option>
                        <option value="announcement">Announcements</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <select class="form-control form-control-sm" style="border-radius: 8px;" wire:model="filterPriority">
                        <option value="">All Priorities</option>
                        <option value="high">High</option>
                        <option value="normal">Normal</option>
                        <option value="low">Low</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <select class="form-control form-control-sm" style="border-radius: 8px;" wire:model="filterVisibility">
                        <option value="">All Audiences</option>
                        <option value="all">All Employees</option>
                        <option value="department">Departments</option>
                        <option value="specific">Specific Users</option>
                    </select>
                </div>
                <div class="col-lg-2 col-md-3 mb-2">
                    <select class="form-control form-control-sm" style="border-radius: 8px;" wire:model="filterStatus">
                        <option value="">All Statuses</option>
                        @foreach ($statuses as $st)
                            <option value="{{ $st->id }}">{{ $st->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead style="background: #f8f9fc;">
                    <tr>
                        <th class="border-0 pl-4"><small class="text-uppercase font-weight-bold text-muted">Title</small></th>
                        <th class="border-0" style="width: 100px;"><small class="text-uppercase font-weight-bold text-muted">Type</small></th>
                        <th class="border-0" style="width: 90px;"><small class="text-uppercase font-weight-bold text-muted">Priority</small></th>
                        <th class="border-0" style="width: 110px;"><small class="text-uppercase font-weight-bold text-muted">Date</small></th>
                        <th class="border-0" style="width: 100px;"><small class="text-uppercase font-weight-bold text-muted">Audience</small></th>
                        <th class="border-0" style="width: 90px;"><small class="text-uppercase font-weight-bold text-muted">Status</small></th>
                        <th class="border-0 text-center" style="width: 60px;"><small class="text-uppercase font-weight-bold text-muted">Read</small></th>
                        <th class="border-0 text-right pr-4" style="width: 200px;"><small class="text-uppercase font-weight-bold text-muted">Actions</small></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($announcements as $item)
                        <tr style="vertical-align: middle;">
                            <td class="pl-4">
                                <span class="font-weight-bold text-gray-800 d-block">{{ $item->title }}</span>
                                <small class="text-muted">By {{ $item->creator->name ?? 'Unknown' }}</small>
                            </td>
                            <td>
                                <span class="badge badge-{{ $item->type_badge }} px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                    {{ ucfirst($item->type) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $item->priority_badge }} px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                    {{ ucfirst($item->priority) }}
                                </span>
                            </td>
                            <td>
                                <small class="font-weight-bold text-gray-700">{{ $item->publish_date->format('d M Y') }}</small>
                                @if ($item->expiry_date)
                                    <br><small class="text-muted">Exp: {{ $item->expiry_date->format('d M Y') }}</small>
                                @endif
                            </td>
                            <td>
                                @if ($item->visibility === 'all')
                                    <span class="badge badge-success px-2 py-1" style="border-radius: 6px; font-size: .7rem;">
                                        <i class="fas fa-globe-americas mr-1"></i> All
                                    </span>
                                @elseif ($item->visibility === 'department')
                                    @php $deptCount = count($item->visible_to['department_ids'] ?? []); @endphp
                                    <span class="badge badge-info px-2 py-1" style="border-radius: 6px; font-size: .7rem;" title="{{ $deptCount }} department(s)">
                                        <i class="fas fa-building mr-1"></i> {{ $deptCount }} {{ Str::plural('dept', $deptCount) }}
                                    </span>
                                @elseif ($item->visibility === 'specific')
                                    @php $userCount = count($item->visible_to['user_ids'] ?? []); @endphp
                                    <span class="badge badge-warning px-2 py-1" style="border-radius: 6px; font-size: .7rem;" title="{{ $userCount }} employee(s)">
                                        <i class="fas fa-user-check mr-1"></i> {{ $userCount }} {{ Str::plural('user', $userCount) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusColors = ['active' => 'success', 'pending' => 'warning', 'inactive' => 'secondary'];
                                    $color = $statusColors[$item->status->slug ?? ''] ?? 'secondary';
                                @endphp
                                <span class="badge badge-{{ $color }} px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                    {{ $item->status->name ?? '-' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-light border px-2 py-1" style="border-radius: 6px; font-size: .75rem;">
                                    {{ $item->reads_count }}
                                </span>
                            </td>
                            <td class="text-right pr-4">
                                <div class="d-flex justify-content-end" style="gap: 6px;">
                                    <button wire:click="edit({{ $item->id }})" class="btn btn-sm btn-outline-primary rounded-pill px-3" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if (!$item->is_archived)
                                        <button wire:click="archive({{ $item->id }})" class="btn btn-sm btn-outline-warning rounded-pill px-3" title="Archive">
                                            <i class="fas fa-archive"></i>
                                        </button>
                                    @else
                                        <button wire:click="unarchive({{ $item->id }})" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Restore">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    @endif
                                    <button onclick="deleteAnnouncement({{ $item->id }})" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-bullhorn text-muted mb-3" style="font-size: 2.5rem; opacity: .3;"></i>
                                <p class="text-muted mb-0 font-weight-bold">No {{ $showArchived ? 'archived' : '' }} announcements found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($announcements->hasPages())
            <div class="p-3 border-top">{{ $announcements->links() }}</div>
        @endif
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('trix-file-accept', function(e) { e.preventDefault(); });

        document.addEventListener('trix-change', function(e) {
            var input = e.target.inputElement;
            if (input && input.id === 'announcementContent') {
                @this.set('content', input.value, true);
            }
        });

        window.addEventListener('load-trix-content', function(e) {
            function loadContent() {
                var editor = document.querySelector('trix-editor[input="announcementContent"]');
                if (editor && editor.editor) {
                    editor.editor.loadHTML(e.detail.content || '');
                } else {
                    setTimeout(loadContent, 100);
                }
            }
            setTimeout(loadContent, 50);
        });

        function deleteAnnouncement(id) {
            if (confirm("Are you sure you want to delete this announcement?")) {
                window.livewire.emit('deleteAnnouncement', id);
            }
        }
    </script>
</div>
