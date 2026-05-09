<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Video Items</h1>
            <p class="text-muted mb-0">Maintain video content used across public pages.</p>
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

        <div class="col-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateVideos ? 'Edit Video Item' : 'Add Video Item' }}</h5>
                    @if ($updateVideos)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateVideos ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="videoLink">Video Link</label>
                                <input id="videoLink" type="url" class="form-control" wire:model.defer="video_link" placeholder="Enter URL">
                                @error('video_link') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="videoName">Name</label>
                                <input id="videoName" type="text" class="form-control" wire:model.defer="name" placeholder="Enter name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="videoType">Type</label>
                                <select id="videoType" class="form-control" wire:model.defer="type">
                                    <option value="">-- Choose --</option>
                                    <option value="Videos">Videos</option>
                                </select>
                                @error('type') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="videoDescription">Description</label>
                                <textarea id="videoDescription" rows="3" class="form-control" wire:model.defer="description" placeholder="Enter description"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="videoCategory">Category</label>
                                <select id="videoCategory" class="form-control" wire:model.defer="item_category_id">
                                    <option value="">-- Choose --</option>
                                    @foreach($item_categories as $item_category)
                                        <option value="{{ $item_category->id }}">{{ $item_category->name }}</option>
                                    @endforeach
                                </select>
                                @error('item_category_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="videoStatus">Status</label>
                                <select id="videoStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Choose --</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateVideos ? 'Update Video Item' : 'Save Video Item' }}</button>
                            @if ($updateVideos)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Video Library</h5>
                    <span class="badge badge-light">{{ count($video_items) }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Video Link</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($video_items) > 0)
                                    @foreach ($video_items as $video)
                                        <tr>
                                            <td class="text-truncate" style="max-width: 220px;">{{ $video->video_link }}</td>
                                            <td>{{ $video->name }}</td>
                                            <td class="text-muted">{{ $video->description }}</td>
                                            <td>{{ $video->category->name ?? '-' }}</td>
                                            <td>{{ $video->status->name ?? '' }}</td>
                                            <td class="text-right">
                                                <button wire:click="edit({{ $video->id }})" class="btn btn-outline-primary btn-sm">Edit</button>
                                                <button onclick="deleteVideoItem({{ $video->id }})" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No Video Item Found.</td>
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
        function deleteVideoItem(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteVideoItem', id);
        }
    </script>

</div>
