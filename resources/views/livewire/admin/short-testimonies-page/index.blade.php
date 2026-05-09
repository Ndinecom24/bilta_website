<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Short Testimonials</h1>
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
                    <h5 class="mb-0">{{ $updateShortTestimony ? 'Edit Short Testimonial' : 'Add Short Testimonial' }}</h5>
                    @if ($updateShortTestimony)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateShortTestimony ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="shortTestimonyName">Name</label>
                                <input id="shortTestimonyName" type="text" class="form-control" wire:model.defer="name" placeholder="Enter name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="shortTestimonyStatus">Status</label>
                                <select id="shortTestimonyStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Select --</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="shortTestimonyTitle">Testifier Title</label>
                                <input id="shortTestimonyTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter title of testifier">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="shortTestimonyText">Testimonial</label>
                                <textarea id="shortTestimonyText" rows="4" class="form-control" wire:model.defer="testimonial" placeholder="Enter testimonial"></textarea>
                                @error('testimonial') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateShortTestimony ? 'Update Testimonial' : 'Save Testimonial' }}</button>
                            @if ($updateShortTestimony)
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
                    <h5 class="mb-0">Short Testimonials</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Title</th>
                                    <th>Testimonial</th>
                                    <th>Status</th>
                                    <th style="width: 170px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($testimonies) > 0)
                                    @foreach ($testimonies as $testimonial)
                                        <tr>
                                            <td>{{ $testimonial->name }}</td>
                                            <td>{{ $testimonial->title }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($testimonial->testimonial, 180) }}</td>
                                            <td>{{ $testimonial->status->name ?? '--' }}</td>
                                            <td>
                                                <button wire:click="edit({{ $testimonial->id }})" class="btn btn-primary btn-sm">Edit</button>
                                                <button onclick="deleteTestimonies({{ $testimonial->id }})" class="btn btn-danger btn-sm">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Testimonials Found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $testimonies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteTestimonies(id) {
            if (confirm("Are you sure to delete this record?"))
                window.livewire.emit('deleteShortTestimony', id);
        }
    </script>

</div>
