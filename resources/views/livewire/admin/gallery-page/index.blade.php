<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Gallery Items</h1>
            <p class="text-muted mb-0">Manage photo gallery entries and their metadata.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success" role="alert">{{ session()->get('success') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger" role="alert">{{ session()->get('error') }}</div>
            @endif
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateGallery ? 'Edit Gallery Item' : 'Add Gallery Item' }}</h5>

                    @if ($updateGallery)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">
                            Create New
                        </button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateGallery ? 'update' : 'store' }}">
                        <div class="row">
                            @if ($updateGallery)
                                <div class="col-lg-4 col-md-12 mb-3">
                                    <label class="font-weight-bold d-block" for="currentGalleryImagePreview">Current Image</label>
                                    @php
                                        $currentMedia = isset($gallery_item) ? $gallery_item->getFirstMedia('gallery_images') : null;
                                    @endphp
                                    <div id="currentGalleryImagePreview">
                                        @if ($currentMedia)
                                            <img src="{{ $currentMedia->getUrl() }}" alt="Current gallery preview" style="width:100%; height:150px; object-fit:cover; border-radius:8px;">
                                        @else
                                            <div class="text-muted">No image uploaded yet.</div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="{{ $updateGallery ? 'col-lg-8' : 'col-lg-12' }} col-md-12 mb-3">
                                <label class="font-weight-bold" for="galleryImageInput">{{ $updateGallery ? 'Replace Image' : 'Image' }}</label>
                                <input id="galleryImageInput" type="file" class="form-control" wire:model="gallery_image" accept="image/*">
                                <small class="text-muted">Accepted formats: images only.</small>
                                @error('gallery_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="galleryNameInput">Name</label>
                                <input id="galleryNameInput" type="text" class="form-control" wire:model.defer="name" placeholder="Enter Name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="galleryTypeInput">Type</label>
                                <select id="galleryTypeInput" class="form-control" wire:model.defer="type">
                                    <option value="">--Choose--</option>
                                    <option value="Images">Images</option>
                                </select>
                                @error('type') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="galleryDescriptionInput">Description</label>
                                <textarea id="galleryDescriptionInput" rows="4" class="form-control" wire:model.defer="description" placeholder="Enter Description"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="galleryCategoryInput">Category</label>
                                <select id="galleryCategoryInput" class="form-control" wire:model.defer="item_category_id">
                                    <option value="">--Choose--</option>
                                    @foreach($item_categories as $item_category)
                                        <option value="{{ $item_category->id }}">{{ $item_category->name }}</option>
                                    @endforeach
                                </select>
                                @error('item_category_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="galleryStatusInput">Status</label>
                                <select id="galleryStatusInput" class="form-control" wire:model.defer="status_id">
                                    <option value="">--Choose--</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center">
                            <button type="submit" class="btn btn-primary">
                                {{ $updateGallery ? 'Update Item' : 'Save Item' }}
                            </button>

                            @if ($updateGallery)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger ml-2">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Gallery Records</h5>
                    <span class="badge badge-light">{{ count($gallery_items) }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($gallery_items) > 0)
                                    @foreach ($gallery_items as $gallery_item)
                                        @php
                                            $galleryMedia = $gallery_item->getFirstMedia('gallery_images');
                                        @endphp
                                        <tr>
                                            <td>
                                                @if ($galleryMedia)
                                                    <img src="{{ $galleryMedia->getUrl() }}" style="width: 90px; height: 60px; object-fit: cover; border-radius: 8px;" title="{{ $galleryMedia->name }}" alt="{{ $gallery_item->name }}">
                                                @else
                                                    <span class="text-muted">No image</span>
                                                @endif
                                            </td>
                                            <td>{{ $gallery_item->name }}</td>
                                            <td class="text-muted">{{ $gallery_item->description }}</td>
                                            <td>{{ $gallery_item->category->name ?? '-' }}</td>
                                            <td>{{ $gallery_item->status->name ?? '' }}</td>
                                            <td class="text-right">
                                                <button wire:click="edit({{ $gallery_item->id }})" class="btn btn-outline-primary btn-sm">Edit</button>
                                                <button onclick="deleteGalleryItem({{ $gallery_item->id }})" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No Gallery Item Found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteGalleryItem(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteGalleryItem', id);
        }
    </script>

</div>
