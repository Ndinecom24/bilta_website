<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Our Sponsors</h1>
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
                    <h5 class="mb-0">{{ $updateSponsor ? 'Edit Sponsor' : 'Add Sponsor' }}</h5>

                    @if ($updateSponsor)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateSponsor ? 'updateOurSponsor' : 'saveOurSponsor' }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="sponsorName">Name</label>
                                <input id="sponsorName" type="text" class="form-control" wire:model.defer="name" placeholder="Enter sponsor name">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="sponsorUrl">Website URL</label>
                                <input id="sponsorUrl" type="url" class="form-control" wire:model.defer="website_url" placeholder="https://example.org">
                                @error('website_url') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="sponsorStatus">Status</label>
                                <select id="sponsorStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="sponsorOrder">Order</label>
                                <input id="sponsorOrder" type="number" min="0" class="form-control" wire:model.defer="display_order" placeholder="0">
                                @error('display_order') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="sponsorDescription">Description</label>
                                <textarea id="sponsorDescription" rows="4" class="form-control" wire:model.defer="description" placeholder="Write a short sponsor profile"></textarea>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            @if ($updateSponsor && $oursponsor && $oursponsor->getFirstMedia('sponsor_image'))
                                <div class="col-lg-12 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-1">Current Sponsor Logo</p>
                                    <img src="{{ $oursponsor->getFirstMedia('sponsor_image')->getUrl() }}" style="max-height: 80px;" alt="Sponsor logo">
                                </div>
                            @endif

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="sponsorImage">{{ $updateSponsor ? 'Replace Image (optional)' : 'Sponsor Image' }}</label>
                                <input id="sponsorImage" type="file" class="form-control" wire:model="{{ $updateSponsor ? 'sponsor_image_update' : 'sponsor_image' }}">
                                @if ($updateSponsor)
                                    @error('sponsor_image_update') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @else
                                    @error('sponsor_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateSponsor ? 'Update Sponsor' : 'Save Sponsor' }}</button>
                            @if ($updateSponsor)
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
                    <h5 class="mb-0">Sponsor Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 220px;">Name</th>
                                    <th style="width: 230px;">Website</th>
                                    <th>Description</th>
                                    <th style="width: 90px;">Order</th>
                                    <th style="width: 150px;">Created</th>
                                    <th style="width: 160px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($oursponsors as $oursponser)
                                    <tr>
                                        <td>{{ $oursponser->name }}</td>
                                        <td>{{ $oursponser->website_url }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($oursponser->description, 180) }}</td>
                                        <td>{{ $oursponser->display_order ?? 0 }}</td>
                                        <td>{{ optional($oursponser->created_at)->format('d M Y') }}</td>
                                        <td>
                                            <button wire:click="edit({{ $oursponser->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteOurSponsor({{ $oursponser->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No sponsor records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $oursponsors->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteOurSponsor(id) {
            if (confirm("Are you sure to delete this sponsor?")) {
                window.livewire.emit('deleteOurSponsor', id);
            }
        }
    </script>
</div>
