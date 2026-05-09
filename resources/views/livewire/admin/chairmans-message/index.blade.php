<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chairman Message</h1>
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
                    <h5 class="mb-0">{{ $updateChairmansMessage ? 'Edit Chairman Message' : 'Add Chairman Message' }}</h5>

                    @if ($updateChairmansMessage)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateChairmansMessage ? 'updateChairmansMessage' : 'saveChairmansMessage' }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="chairmanName">Chairman Name</label>
                                <input id="chairmanName" type="text" class="form-control" wire:model.defer="name" placeholder="Enter name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="chairmanTitle">Title</label>
                                <input id="chairmanTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter title">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="chairmanStatus">Status</label>
                                <select id="chairmanStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Select Status --</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="chairmanMessage">Message</label>
                                <textarea id="chairmanMessage" rows="7" class="form-control" wire:model.defer="message" placeholder="Enter full chairman message"></textarea>
                                @error('message') <span class="text-danger d-block">{{ $message }}</span>@enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="chairmanImage">Photo</label>
                                <input id="chairmanImage" type="file" class="form-control" wire:model="{{ $updateChairmansMessage ? 'intro_image_update' : 'intro_image' }}" accept="image/*">
                                @if ($updateChairmansMessage)
                                    @error('intro_image_update') <span class="text-danger d-block">{{ $message }}</span>@enderror
                                @else
                                    @error('intro_image') <span class="text-danger d-block">{{ $message }}</span>@enderror
                                @endif
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <div class="font-weight-bold mb-2">Current Photo</div>
                                @if(isset($chairmansMsg) && $chairmansMsg && $chairmansMsg->getFirstMedia('chairman_photo'))
                                    <img
                                        src="{{ $chairmansMsg->getFirstMedia('chairman_photo')->getUrl() }}"
                                        alt="{{ $chairmansMsg->name ?? 'Chairman' }}"
                                        class="img-fluid rounded border"
                                        style="max-height: 150px; object-fit: cover;">
                                @else
                                    <div class="border rounded p-3 text-muted">No photo selected</div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateChairmansMessage ? 'Update Message' : 'Save Message' }}</button>
                            @if ($updateChairmansMessage)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Chairman Message Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:150px;">Photo</th>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th style="width:170px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($chairmansmessages as $cmessage)
                                    <tr>
                                        <td>
                                            @if($cmessage->getFirstMedia('chairman_photo'))
                                                <img src="{{ $cmessage->getFirstMedia('chairman_photo')->getUrl() }}" alt="{{ $cmessage->name }}" class="img-fluid rounded" style="max-height:60px; object-fit:cover;">
                                            @else
                                                <span class="text-muted">No photo</span>
                                            @endif
                                        </td>
                                        <td>{{ $cmessage->name }}</td>
                                        <td>{{ $cmessage->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($cmessage->message), 150) }}</td>
                                        <td>{{ optional($statuses->firstWhere('id', $cmessage->status_id))->name ?? '-' }}</td>
                                        <td>{{ $cmessage->created_at }}</td>
                                        <td>
                                            <button wire:click="edit({{ $cmessage->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteChairmansMessage({{ $cmessage->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No chairman message records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-2">
                            {{ $chairmansmessages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteChairmansMessage(id) {
            if (confirm("Are you sure to delete this chairmansmessage?")) {
                window.livewire.emit('deleteChairmansMessage', id);
            }
        }
    </script>
</div>
