<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Our Services</h1>
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
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateOurServices ? 'Edit Service' : 'Add Service' }}</h5>

                    @if ($updateOurServices)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateOurServices ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="serviceTitle">Service Title</label>
                                <input id="serviceTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter service title">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-8 col-md-12 mb-3">
                                <label class="font-weight-bold" for="serviceDescription">Service Description</label>
                                <textarea id="serviceDescription" rows="4" class="form-control" wire:model.defer="description" placeholder="Describe this service in clear visitor-friendly language"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateOurServices ? 'Update Service' : 'Save Service' }}</button>
                            @if ($updateOurServices)
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
                    <h5 class="mb-0">Service Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 240px;">Title</th>
                                    <th>Description</th>
                                    <th style="width: 170px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($our_serviceses as $service)
                                    <tr>
                                        <td>{{ $service->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($service->description, 180) }}</td>
                                        <td>
                                            <button wire:click="edit({{ $service->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteOurServices({{ $service->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No service records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $our_serviceses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteOurServices(id) {
            if (confirm("Are you sure to delete this record?")) {
                window.livewire.emit('deleteOurServices', id);
            }
        }
    </script>

</div>
