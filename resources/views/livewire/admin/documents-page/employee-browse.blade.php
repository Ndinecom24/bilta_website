<div>

    {{-- PAGE HEADER --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 font-weight-bold">
                <i class="fas fa-folder-open text-primary mr-2"></i>Company Documents
            </h1>
            <p class="mb-0 text-muted small">Browse and download company documents.</p>
        </div>
    </div>

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

            {{-- Search --}}
            <div class="mb-3">
                <div class="input-group" style="border-radius: 10px; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-muted"></i></span>
                    </div>
                    <input type="text" class="form-control border-left-0" wire:model.debounce.300ms="search" placeholder="Search documents...">
                </div>
            </div>

            {{-- Subfolders --}}
            @if ($folders->count())
                <div class="row mb-3">
                    @foreach ($folders as $folder)
                        <div class="col-lg-3 col-md-4 col-6 mb-3">
                            <div class="card border-0 shadow-sm h-100 text-center" style="border-radius: 12px; cursor: pointer; transition: transform .15s;"
                                 wire:click="navigateToFolder({{ $folder->id }})"
                                 onmouseover="this.style.transform='translateY(-3px)'"
                                 onmouseout="this.style.transform='translateY(0)'">
                                <div class="card-body py-3 px-2">
                                    <i class="fas fa-folder text-warning mb-2" style="font-size: 2rem;"></i>
                                    <p class="mb-0 small font-weight-bold text-gray-700 text-truncate">{{ $folder->name }}</p>
                                    <small class="text-muted">{{ $folder->documents()->count() }} files</small>
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
                                    <th class="border-0" style="width: 80px;">
                                        <small class="text-uppercase font-weight-bold text-muted">Size</small>
                                    </th>
                                    <th class="border-0" style="width: 80px;">
                                        <small class="text-uppercase font-weight-bold text-muted">Type</small>
                                    </th>
                                    <th class="border-0" style="width: 110px;" wire:click="sortByColumn('created_at')" style="cursor: pointer;">
                                        <small class="text-uppercase font-weight-bold text-muted">Uploaded</small>
                                    </th>
                                    <th class="border-0 text-right pr-3" style="width: 100px;">
                                        <small class="text-uppercase font-weight-bold text-muted">Action</small>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($documents as $doc)
                                    <tr style="vertical-align: middle;">
                                        <td class="pl-3"><i class="{{ $doc->icon_class }}" style="font-size: 1.2rem;"></i></td>
                                        <td>
                                            <span class="font-weight-bold text-gray-800">{{ $doc->name }}</span>
                                            @if ($doc->description)
                                                <small class="text-muted d-block">{{ $doc->description }}</small>
                                            @endif
                                        </td>
                                        <td><small class="text-muted">{{ $doc->formatted_size }}</small></td>
                                        <td><span class="badge badge-light border px-2" style="border-radius: 4px; font-size: .7rem;">{{ strtoupper($doc->extension) }}</span></td>
                                        <td><small class="text-muted">{{ $doc->created_at->format('d M Y') }}</small></td>
                                        <td class="text-right pr-3">
                                            <button wire:click="downloadDocument({{ $doc->id }})" class="btn btn-sm btn-outline-success rounded-pill px-3" title="Download">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
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
</div>
