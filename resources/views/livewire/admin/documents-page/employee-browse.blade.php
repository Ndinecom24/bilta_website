<div>

    {{-- PAGE HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-folder-open text-primary mr-2"></i>Documents
            </h1>
            <p class="mb-0 text-muted small">Browse, upload and manage documents. Create folders and control who can access them.</p>
        </div>
    </div>

    {{-- ALERTS --}}
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

    <div class="row">
        {{-- LEFT SIDEBAR: Folder Tree --}}
        <div class="col-lg-3 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-light py-2 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 font-weight-bold text-gray-700"><i class="fas fa-sitemap mr-1"></i> Folders</h6>
                    <button wire:click="goToRoot" class="btn btn-sm btn-outline-primary rounded-pill px-2" title="Root">
                        <i class="fas fa-home"></i>
                    </button>
                </div>
                <div class="card-body p-2" style="max-height: 500px; overflow-y: auto;">
                    @if ($folderTree->count())
                        @foreach ($folderTree as $rootFolder)
                            @include('livewire.admin.documents-page.partials.folder-tree-item', ['folder' => $rootFolder, 'depth' => 0])
                        @endforeach
                    @else
                        <p class="text-muted small text-center mb-0 py-3">No folders yet</p>
                    @endif
                </div>
            </div>

            {{-- Visibility Legend --}}
            <div class="card shadow-sm border-0 mt-3" style="border-radius: 12px;">
                <div class="card-body p-3">
                    <h6 class="font-weight-bold text-gray-700 mb-2" style="font-size: .8rem;"><i class="fas fa-info-circle mr-1"></i> Visibility</h6>
                    <div class="small">
                        <div class="mb-1"><i class="fas fa-globe text-success mr-1"></i> Company-wide</div>
                        <div class="mb-1"><i class="fas fa-building text-info mr-1"></i> Departments only</div>
                        <div><i class="fas fa-lock text-warning mr-1"></i> Private (your files)</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-lg-9">

            {{-- Breadcrumbs --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-white shadow-sm py-2 px-3 mb-0" style="border-radius: 10px;">
                    <li class="breadcrumb-item">
                        <a href="#" wire:click.prevent="goToRoot" class="text-primary font-weight-bold">
                            <i class="fas fa-home mr-1"></i> Root
                        </a>
                    </li>
                    @foreach ($breadcrumbs as $crumb)
                        @if ($crumb['id'] == $currentFolderId)
                            <li class="breadcrumb-item active font-weight-bold">{{ $crumb['name'] }}</li>
                        @else
                            <li class="breadcrumb-item">
                                <a href="#" wire:click.prevent="navigateToFolder({{ $crumb['id'] }})" class="text-primary">{{ $crumb['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ol>
            </nav>

            {{-- Current folder info bar --}}
            @if ($currentFolder)
                <div class="d-flex align-items-center mb-3 px-2">
                    <i class="{{ $currentFolder->visibility_icon }} mr-2"></i>
                    <small class="text-muted">
                        {{ $currentFolder->visibility_label }}
                        @if ($currentFolder->creator)
                            &bull; Created by {{ $currentFolder->creator->name ?? 'Unknown' }}
                        @endif
                        @if ($folderPermission)
                            &bull; Your access: <span class="badge badge-{{ $folderPermission === 'manage' ? 'success' : ($folderPermission === 'edit' ? 'primary' : 'info') }} px-2" style="font-size: .7rem;">{{ ucfirst($folderPermission) }}</span>
                        @endif
                    </small>
                </div>
            @endif

            {{-- Search --}}
            <div class="mb-3">
                <div class="input-group" style="border-radius: 10px; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0" wire:model.debounce.300ms="search" placeholder="Search folders and documents...">
                </div>
            </div>

            {{-- Toolbar --}}
            <div class="d-flex flex-wrap mb-3" style="gap: 8px;">
                <button wire:click="toggleFolderForm" class="btn btn-sm btn-primary rounded-pill px-3">
                    <i class="fas fa-folder-plus mr-1"></i> New Folder
                </button>
                @if ($currentFolderId && ($folderPermission === 'edit' || $folderPermission === 'manage'))
                    <button wire:click="toggleUploadForm" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="fas fa-upload mr-1"></i> Upload Files
                    </button>
                @endif
            </div>

            {{-- New/Edit Folder Form --}}
            @if ($showFolderForm)
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
                    <div class="card-body p-3">
                        <h6 class="font-weight-bold text-gray-700 mb-3">
                            <i class="fas fa-folder mr-1"></i> {{ $editingFolderId ? 'Edit Folder' : 'Create Folder' }}
                        </h6>
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <input type="text" class="form-control form-control-sm" style="border-radius: 8px;" wire:model.defer="folderName" placeholder="Folder name">
                                @error('folderName') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-3 mb-2">
                                <input type="text" class="form-control form-control-sm" style="border-radius: 8px;" wire:model.defer="folderDescription" placeholder="Description (optional)">
                            </div>
                            <div class="col-md-3 mb-2">
                                <label class="small font-weight-bold mb-1">Visibility</label>
                                <select class="form-control form-control-sm" style="border-radius: 8px;" wire:model="folderVisibility">
                                    <option value="everyone">Company-wide</option>
                                    <option value="department">Departments Only</option>
                                    <option value="specific">Specific Employees</option>
                                    <option value="private">Private</option>
                                </select>
                                <small class="text-muted">Who can see this folder</small>
                            </div>
                            @if ($folderVisibility === 'department')
                                <div class="col-md-6 mb-2">
                                    <label class="small font-weight-bold mb-1">Allowed Departments</label>
                                    <select class="form-control form-control-sm" style="border-radius: 8px;" wire:model.defer="folderDepartmentIds" multiple size="4">
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select departments that can access this folder.</small>
                                    @error('folderDepartmentIds') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                </div>
                            @endif
                            @if ($folderVisibility === 'specific')
                                <div class="col-md-6 mb-2">
                                    <label class="small font-weight-bold mb-1">Allowed Employees</label>
                                    <select class="form-control form-control-sm" style="border-radius: 8px;" wire:model.defer="folderUserIds" multiple size="4">
                                        @foreach($users as $u)
                                            <option value="{{ $u->id }}">{{ $u->name }} @if($u->departmentRelation) ({{ $u->departmentRelation->name }}) @endif</option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Select specific employees who can access this folder.</small>
                                    @error('folderUserIds') <small class="text-danger d-block">{{ $message }}</small> @enderror
                                </div>
                            @endif
                            <div class="col-md-2 mb-2">
                                <button wire:click="{{ $editingFolderId ? 'updateFolder' : 'createFolder' }}" class="btn btn-sm btn-primary w-100" style="border-radius: 8px;">
                                    {{ $editingFolderId ? 'Update' : 'Create' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Upload Form --}}
            @if ($showUploadForm && $currentFolderId)
                <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px;">
                    <div class="card-body p-3">
                        <h6 class="font-weight-bold text-gray-700 mb-3">
                            <i class="fas fa-upload mr-1"></i> Upload Files
                        </h6>
                        <div class="custom-file-upload position-relative border rounded-lg p-3 text-center bg-light mb-2" style="border-radius: 10px !important; border-style: dashed !important; cursor: pointer;">
                            <input type="file" class="position-absolute w-100 h-100" style="top:0;left:0;opacity:0;cursor:pointer;" wire:model="uploadFiles" multiple>
                            <div>
                                <i class="fas fa-cloud-upload-alt text-success mb-2" style="font-size: 1.5rem;"></i>
                                <p class="mb-0 small text-muted">Click or drag files here</p>
                                <small class="text-muted">Max 50 MB per file &bull; All common file types</small>
                            </div>
                            <div wire:loading wire:target="uploadFiles" class="mt-2">
                                <div class="spinner-border spinner-border-sm text-primary"></div>
                                <small class="text-primary ml-1">Uploading...</small>
                            </div>
                        </div>
                        @error('uploadFiles.*') <small class="text-danger d-block mb-2">{{ $message }}</small> @enderror

                        <div class="row">
                            <div class="col-md-8 mb-2">
                                <input type="text" class="form-control form-control-sm" style="border-radius: 8px;" wire:model.defer="fileDescription" placeholder="File description (optional)">
                            </div>
                            <div class="col-md-4 mb-2">
                                <button wire:click="uploadDocuments" class="btn btn-sm btn-success w-100" style="border-radius: 8px;">
                                    <i class="fas fa-check mr-1"></i> Save Files
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Subfolders --}}
            @if ($folders->count() && !$search)
                <div class="row mb-3">
                    @foreach ($folders as $folder)
                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 12px; cursor: pointer; transition: transform .15s;"
                                 wire:click="navigateToFolder({{ $folder->id }})"
                                 onmouseover="this.style.transform='translateY(-3px)'"
                                 onmouseout="this.style.transform='translateY(0)'">
                                <div class="card-body py-3 px-2">
                                    <div class="position-relative d-inline-block">
                                        <i class="fas fa-folder text-warning mb-2" style="font-size: 2rem;"></i>
                                        <i class="{{ $folder->visibility_icon }} position-absolute" style="font-size: .6rem; top: -2px; right: -10px;"></i>
                                    </div>
                                    <p class="mb-0 small font-weight-bold text-gray-700 text-truncate">{{ $folder->name }}</p>
                                    <small class="text-muted">{{ $folder->documents()->count() }} files</small>
                                </div>
                                @if ($folder->canManage(auth()->user()))
                                    <div class="card-footer bg-transparent border-0 p-1">
                                        <button wire:click.stop="editFolder({{ $folder->id }})" class="btn btn-sm btn-link text-primary p-1" title="Edit Folder">
                                            <i class="fas fa-edit"></i> <small>Edit</small>
                                        </button>
                                        <button wire:click.stop="openShareModal({{ $folder->id }})" class="btn btn-sm btn-link text-info p-1" title="Change Access / Visibility">
                                            <i class="fas fa-user-shield"></i> <small>Access</small>
                                        </button>
                                        <button onclick="event.stopPropagation(); deleteFolder({{ $folder->id }})" class="btn btn-sm btn-link text-danger p-1" title="Delete Folder">
                                            <i class="fas fa-trash-alt"></i> <small>Delete</small>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Search results folders --}}
            @if ($search && $folders->count())
                <h6 class="font-weight-bold text-gray-700 mb-2"><i class="fas fa-folder mr-1"></i> Matching Folders</h6>
                <div class="row mb-3">
                    @foreach ($folders as $folder)
                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 12px; cursor: pointer;"
                                 wire:click="navigateToFolder({{ $folder->id }})">
                                <div class="card-body py-3 px-2">
                                    <i class="fas fa-folder text-warning mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0 small font-weight-bold text-gray-700 text-truncate">{{ $folder->name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Documents Table --}}
            @if ($currentFolderId || $search)
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-light py-2 d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 font-weight-bold text-gray-700"><i class="fas fa-file mr-1"></i> Files</h6>
                        <small class="text-muted">{{ $documents->total() }} file(s)</small>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm mb-0">
                            <thead style="background: #f8f9fc;">
                                <tr>
                                    <th class="border-0 pl-3" style="width: 40px;"></th>
                                    <th class="border-0" wire:click="sortByColumn('name')" style="cursor: pointer;">
                                        <small class="text-uppercase font-weight-bold text-muted">
                                            Name
                                            @if ($sortBy === 'name') <i class="fas fa-sort-{{ $sortDir === 'asc' ? 'up' : 'down' }} ml-1"></i> @endif
                                        </small>
                                    </th>
                                    <th class="border-0" style="width: 80px;" wire:click="sortByColumn('file_size')" style="cursor: pointer;">
                                        <small class="text-uppercase font-weight-bold text-muted">Size</small>
                                    </th>
                                    <th class="border-0" style="width: 80px;">
                                        <small class="text-uppercase font-weight-bold text-muted">Type</small>
                                    </th>
                                    <th class="border-0" style="width: 100px;">
                                        <small class="text-uppercase font-weight-bold text-muted">Uploaded By</small>
                                    </th>
                                    <th class="border-0" style="width: 100px;" wire:click="sortByColumn('created_at')" style="cursor: pointer;">
                                        <small class="text-uppercase font-weight-bold text-muted">Date</small>
                                    </th>
                                    <th class="border-0 text-right pr-3" style="width: 160px;">
                                        <small class="text-uppercase font-weight-bold text-muted">Actions</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $doc)
                                    @php
                                        $docPerm = $doc->getPermissionFor(auth()->user());
                                    @endphp
                                    <tr style="vertical-align: middle;">
                                        <td class="pl-3"><i class="{{ $doc->icon_class }}" style="font-size: 1.2rem;"></i></td>
                                        <td>
                                            @if ($renamingDocumentId === $doc->id)
                                                <div class="d-flex" style="gap: 5px;">
                                                    <input type="text" class="form-control form-control-sm" style="border-radius: 6px;" wire:model.defer="newDocumentName" wire:keydown.enter="saveRename">
                                                    <button wire:click="saveRename" class="btn btn-sm btn-primary px-2"><i class="fas fa-check"></i></button>
                                                    <button wire:click="cancelRename" class="btn btn-sm btn-secondary px-2"><i class="fas fa-times"></i></button>
                                                </div>
                                            @else
                                                <span class="font-weight-bold text-gray-800">{{ $doc->name }}</span>
                                                <small class="text-muted d-block">{{ $doc->original_name }}</small>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $doc->formatted_size }}</small></td>
                                        <td><span class="badge badge-light border px-2" style="border-radius: 4px; font-size: .7rem;">{{ strtoupper($doc->extension) }}</span></td>
                                        <td><small class="text-muted">{{ $doc->uploader->name ?? 'Unknown' }}</small></td>
                                        <td><small class="text-muted">{{ $doc->created_at->format('d M Y') }}</small></td>
                                        <td class="text-right pr-3">
                                            <div class="d-flex justify-content-end" style="gap: 4px;">
                                                <button wire:click="downloadDocument({{ $doc->id }})" class="btn btn-sm btn-outline-success px-2" title="Download">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                @if ($docPerm === 'edit' || $docPerm === 'manage')
                                                    <button wire:click="startRename({{ $doc->id }})" class="btn btn-sm btn-outline-primary px-2" title="Rename">
                                                        <i class="fas fa-pen"></i>
                                                    </button>
                                                @endif
                                                @if ($docPerm === 'manage')
                                                    <button onclick="deleteDocument({{ $doc->id }})" class="btn btn-sm btn-outline-danger px-2" title="Delete">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="fas fa-file text-muted mb-2" style="font-size: 2rem; opacity: .3;"></i>
                                            <p class="text-muted mb-0 small">No files in this folder</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($documents->hasPages())
                        <div class="p-3 border-top">{{ $documents->links() }}</div>
                    @endif
                </div>
            @elseif (!$search && !$currentFolderId)
                <div class="text-center py-5">
                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3rem; opacity: .3;"></i>
                    <p class="text-muted font-weight-bold">Select a folder to view its contents</p>
                    <small class="text-muted">Use the folder tree on the left or click any folder above.</small>
                </div>
            @endif
        </div>
    </div>

    {{-- SHARE MODAL --}}
    @if ($showShareModal && $sharingFolder)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0,0,0,.5);">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content border-0 shadow" style="border-radius: 14px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title font-weight-bold">
                            <i class="fas fa-share-alt text-primary mr-2"></i>Share Folder: {{ $sharingFolder->name }}
                        </h5>
                        <button type="button" class="close" wire:click="closeShareModal">&times;</button>
                    </div>
                    <div class="modal-body">
                        {{-- Current visibility --}}
                        <div class="alert alert-light border mb-3">
                            <i class="{{ $sharingFolder->visibility_icon }} mr-1"></i>
                            <strong>Visibility:</strong> {{ $sharingFolder->visibility_label }}
                            <small class="text-muted d-block mt-1">
                                @if ($sharingFolder->visibility === 'everyone')
                                    All authenticated users can view this folder. Use sharing below to grant edit/manage access.
                                @elseif ($sharingFolder->visibility === 'department')
                                    Only shared departments and users can access this folder.
                                @else
                                    This is a private folder. Share with specific departments or users below.
                                @endif
                            </small>
                        </div>

                        @if (session()->has('shareSuccess'))
                            <div class="alert alert-success py-2 mb-3">
                                <i class="fas fa-check-circle mr-1"></i> {{ session('shareSuccess') }}
                            </div>
                        @endif

                        {{-- Add share form --}}
                        <div class="card border mb-3" style="border-radius: 10px;">
                            <div class="card-body p-3">
                                <h6 class="font-weight-bold text-gray-700 mb-3"><i class="fas fa-plus-circle mr-1"></i> Grant Access</h6>
                                <div class="row">
                                    <div class="col-md-3 mb-2">
                                        <select class="form-control form-control-sm" wire:model="shareTargetType" style="border-radius: 8px;">
                                            <option value="department">Department</option>
                                            <option value="user">Individual</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        @if ($shareTargetType === 'department')
                                            <select class="form-control form-control-sm" wire:model.defer="shareTargetId" style="border-radius: 8px;">
                                                <option value="">Select department...</option>
                                                @foreach ($departments as $dept)
                                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <select class="form-control form-control-sm" wire:model.defer="shareTargetId" style="border-radius: 8px;">
                                                <option value="">Select user...</option>
                                                @foreach ($users as $u)
                                                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @error('shareTargetId') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <select class="form-control form-control-sm" wire:model.defer="sharePermission" style="border-radius: 8px;">
                                            <option value="view">View Only</option>
                                            <option value="edit">Can Edit</option>
                                            <option value="manage">Full Control</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <button wire:click="addShareEntry" class="btn btn-sm btn-primary w-100" style="border-radius: 8px;">
                                            <i class="fas fa-plus mr-1"></i> Add
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Current shares --}}
                        <h6 class="font-weight-bold text-gray-700 mb-2"><i class="fas fa-users mr-1"></i> Current Access</h6>
                        @php
                            $entries = $sharingFolder->accessEntries ?? collect();
                        @endphp
                        @if ($entries->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0" style="border-radius: 8px; overflow: hidden;">
                                    <thead style="background: #f8f9fc;">
                                        <tr>
                                            <th class="border-0"><small class="text-uppercase text-muted font-weight-bold">Type</small></th>
                                            <th class="border-0"><small class="text-uppercase text-muted font-weight-bold">Name</small></th>
                                            <th class="border-0"><small class="text-uppercase text-muted font-weight-bold">Permission</small></th>
                                            <th class="border-0 text-right"><small class="text-uppercase text-muted font-weight-bold">Action</small></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($entries as $entry)
                                            <tr>
                                                <td>
                                                    @if ($entry->target_type === 'department')
                                                        <i class="fas fa-building text-info mr-1"></i> Department
                                                    @else
                                                        <i class="fas fa-user text-primary mr-1"></i> User
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($entry->target_type === 'department')
                                                        {{ \App\Models\Bilta\Department::find($entry->target_id)->name ?? 'Unknown' }}
                                                    @else
                                                        @php $targetUser = \App\Models\User::find($entry->target_id); @endphp
                                                        {{ $targetUser ? $targetUser->name : 'Unknown' }}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $entry->permission_badge }}">{{ $entry->permission_label }}</span>
                                                </td>
                                                <td class="text-right">
                                                    <button wire:click="removeShareEntry({{ $entry->id }})" class="btn btn-sm btn-outline-danger px-2">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-3 text-muted">
                                <i class="fas fa-user-lock mb-2" style="font-size: 1.5rem; opacity: .4;"></i>
                                <p class="mb-0 small">No specific access entries. {{ $sharingFolder->visibility === 'everyone' ? 'All users can view.' : 'Only the creator can access.' }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" wire:click="closeShareModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- SCRIPTS --}}
    <script>
        function deleteFolder(id) {
            if (confirm("Delete this folder and ALL its contents? This cannot be undone.")) {
                window.livewire.emit('deleteFolder', id);
            }
        }
        function deleteDocument(id) {
            if (confirm("Are you sure you want to delete this file?")) {
                window.livewire.emit('deleteDocument', id);
            }
        }
    </script>
</div>
