<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Service Details</h1>
        <a href="{{ route('admin.company.services') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Services
        </a>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">
            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        {{-- Service Detail Card --}}
        <div class="col-md-8 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        @if ($isEditing)
                            Edit Service
                        @else
                            {{ $service->title }}
                        @endif
                    </h5>

                    @if (!$isEditing)
                        <div>
                            <button wire:click="edit" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit me-1"></i> Edit
                            </button>
                            <button onclick="deleteService()" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash me-1"></i> Delete
                            </button>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    @if ($isEditing)
                        {{-- Edit Form --}}
                        <form wire:submit.prevent="update">
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul class="mb-0 pl-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row">
                                <div class="col-lg-4 col-md-12 mb-3">
                                    <label class="font-weight-bold" for="serviceTitle">Service Title</label>
                                    <input id="serviceTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter service title">
                                    @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-lg-8 col-md-12 mb-3">
                                    <label class="font-weight-bold" for="serviceDescription">Service Description</label>
                                    <textarea id="serviceDescription" rows="6" class="form-control" wire:model.defer="description" placeholder="Describe this service in clear visitor-friendly language"></textarea>
                                    @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="serviceImages">Add Images</label>
                                    <input id="serviceImages" type="file" class="form-control" wire:model="service_images" multiple accept="image/*">
                                    <small class="text-muted">Max 3MB per image. You can select multiple.</small>
                                    @error('service_images.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="serviceBrochures">Add Brochures / Files</label>
                                    <input id="serviceBrochures" type="file" class="form-control" wire:model="service_brochures" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                                    <small class="text-muted">PDF, Word, Excel, PowerPoint. Max 10MB per file.</small>
                                    @error('service_brochures.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                {{-- Remove Existing Images --}}
                                <div class="col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing Images</p>
                                    <div class="row">
                                        @forelse ($service->getMedia('service_images') as $item)
                                            <div class="col-md-3 mb-3">
                                                <img src="{{ $item->getUrl() }}" class="img-fluid rounded mb-2" style="height: 120px; width: 100%; object-fit: cover;" alt="{{ $item->name }}">
                                                <button wire:click.prevent="removeImage({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger w-100">
                                                    <i class="fas fa-trash me-1"></i> Remove
                                                </button>
                                            </div>
                                        @empty
                                            <div class="col-12 text-muted">No images uploaded yet.</div>
                                        @endforelse
                                    </div>
                                </div>

                                {{-- Remove Existing Brochures --}}
                                <div class="col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing Brochures / Files</p>
                                    @forelse ($service->getMedia('service_brochures') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <div>
                                                <i class="fas fa-file-alt me-2 text-primary"></i>
                                                <a href="{{ $item->getUrl() }}" target="_blank">{{ $item->name }}</a>
                                                <small class="text-muted ms-2">({{ round($item->size / 1024) }} KB)</small>
                                            </div>
                                            <button wire:click.prevent="removeBrochure({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No brochures or files uploaded yet.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Service
                                </button>
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    @else
                        {{-- View Mode --}}
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold text-muted d-block mb-1">Title</label>
                                <p class="mb-0 h5">{{ $service->title }}</p>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold text-muted d-block mb-1">Description</label>
                                <div class="p-3 bg-light rounded">
                                    {!! nl2br(e($service->description)) !!}
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-muted d-block mb-1">Created</label>
                                <p class="mb-0">{{ $service->created_at ? $service->created_at->format('M d, Y h:i A') : 'N/A' }}</p>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold text-muted d-block mb-1">Last Updated</label>
                                <p class="mb-0">{{ $service->updated_at ? $service->updated_at->format('M d, Y h:i A') : 'N/A' }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Media Sidebar --}}
        <div class="col-md-4 mb-3">
            {{-- Images Card --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-images me-2"></i> Service Images</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($service->getMedia('service_images') as $image)
                            <div class="col-6 mb-2">
                                <img src="{{ $image->getUrl() }}"
                                     class="img-thumbnail"
                                     style="width:100%; height:120px; object-fit:cover;"
                                     alt="{{ $image->name }}">
                            </div>
                        @empty
                            <div class="col-12 text-muted text-center py-3">
                                <i class="fas fa-image fa-2x mb-2 d-block opacity-50"></i>
                                No images uploaded yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Brochures Card --}}
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file-pdf me-2"></i> Brochures & Files</h5>
                </div>
                <div class="card-body">
                    @forelse ($service->getMedia('service_brochures') as $file)
                        <div class="d-flex align-items-center border rounded p-2 mb-2">
                            @php
                                $ext = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                $icon = match(strtolower($ext)) {
                                    'pdf' => 'fa-file-pdf text-danger',
                                    'doc', 'docx' => 'fa-file-word text-primary',
                                    'xls', 'xlsx' => 'fa-file-excel text-success',
                                    'ppt', 'pptx' => 'fa-file-powerpoint text-warning',
                                    default => 'fa-file-alt text-secondary',
                                };
                            @endphp
                            <i class="fas {{ $icon }} fa-lg me-2"></i>
                            <div class="flex-grow-1 overflow-hidden">
                                <a href="{{ $file->getUrl() }}" target="_blank" class="d-block text-truncate">{{ $file->name }}</a>
                                <small class="text-muted">{{ round($file->size / 1024) }} KB</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted text-center py-3">
                            <i class="fas fa-folder-open fa-2x mb-2 d-block opacity-50"></i>
                            No brochures or files uploaded yet.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteService() {
            if (confirm("Are you sure you want to delete this service? This action cannot be undone.")) {
                window.livewire.emit('deleteService');
            }
        }
    </script>
</div>
