<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Audio Items</h1>
            <p class="text-muted mb-0">Manage audio clips attached to project stories.</p>
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
                    <h5 class="mb-0">{{ $updateAudios ? 'Edit Audio Item' : 'Add Audio Item' }}</h5>
                    @if ($updateAudios)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateAudios ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="audioFileInput">{{ $updateAudios ? 'Change Audio File (optional)' : 'Audio File' }}</label>
                                @if ($updateAudios)
                                    <input id="audioFileInput" type="file" class="form-control" accept="audio/*" wire:model.defer="new_file_url">
                                    @error('new_file_url') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @else
                                    <input id="audioFileInput" type="file" class="form-control" accept="audio/*" wire:model.defer="file_url">
                                    @error('file_url') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @endif
                                <div wire:loading wire:target="file_url,new_file_url" class="mt-2 text-info small">Uploading file...</div>
                            </div>

                            @if ($updateAudios && $audio_item && $audio_item->getFirstMediaUrl('audio_files'))
                                <div class="col-lg-12 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Current Audio</p>
                                    <audio controls style="max-width: 280px;">
                                        <source src="{{ $audio_item->getFirstMediaUrl('audio_files') }}" type="audio/mpeg">
                                        Your browser does not support the audio element.
                                    </audio>
                                </div>
                            @endif

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="audioTitle">Title</label>
                                <input id="audioTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter title">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="audioProject">Project</label>
                                <select id="audioProject" class="form-control" wire:model.defer="project_id">
                                    <option value="">-- Choose --</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->title }}</option>
                                    @endforeach
                                </select>
                                @error('project_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="audioDescription">Description</label>
                                <textarea id="audioDescription" rows="3" class="form-control" wire:model.defer="description" placeholder="Enter description"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="audioStatus">Status</label>
                                <select id="audioStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Choose --</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary">{{ $updateAudios ? 'Update Audio Item' : 'Save Audio Item' }}</button>
                            @if ($updateAudios)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                            <div wire:loading wire:target="store,update" class="text-info small">Saving...</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Audio Library</h5>
                    <span class="badge badge-light">{{ count($audio_items) }} Items</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Preview</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($audio_items) > 0)
                                    @foreach ($audio_items as $audio)
                                        <tr>
                                            <td>
                                                @if ($audio->getFirstMediaUrl('audio_files'))
                                                    <audio controls style="max-width: 220px;">
                                                        <source src="{{ $audio->getFirstMediaUrl('audio_files') }}" type="audio/mpeg">
                                                        Your browser does not support the audio element.
                                                    </audio>
                                                @else
                                                    <span class="text-muted">No audio file available.</span>
                                                @endif
                                            </td>
                                            <td>{{ $audio->title }}</td>
                                            <td class="text-muted">{{ $audio->description }}</td>
                                            <td>{{ $audio->project->title ?? '-' }}</td>
                                            <td>{{ $audio->status->name ?? '' }}</td>
                                            <td class="text-right">
                                                <button wire:click="edit({{ $audio->id }})" class="btn btn-outline-primary btn-sm">Edit</button>
                                                <button onclick="deleteAudioItem({{ $audio->id }})" class="btn btn-outline-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No Audio Item Found.</td>
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
        function deleteAudioItem(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteAudioItem', id);
        }
    </script>

</div>
