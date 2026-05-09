<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">About Us</h1>
            <p class="text-muted mb-0">Maintain mission, vision, and organization profile content used across the site.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 p-2">

            @if(session()->has('success'))
                <div class="alert alert-success" role="alert">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">{{ $updateAboutUs ? 'Edit About Us' : 'Add About Us' }}</h5>

                    @if ($updateAboutUs)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">
                            Create New
                        </button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateAboutUs ? 'update' : 'store' }}">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="aboutMission">Mission</label>
                                <textarea id="aboutMission" rows="4" class="form-control" wire:model.defer="mission" placeholder="Enter mission statement"></textarea>
                                <small class="text-muted">Clear and action-oriented mission summary.</small>
                                @error('mission') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="aboutVision">Vision</label>
                                <textarea id="aboutVision" rows="4" class="form-control" wire:model.defer="vision" placeholder="Enter vision statement"></textarea>
                                <small class="text-muted">Long-term impact and future direction.</small>
                                @error('vision') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="aboutObjective">Objective</label>
                                <textarea id="aboutObjective" rows="4" class="form-control" wire:model.defer="objective" placeholder="Enter key objective"></textarea>
                                <small class="text-muted">Primary measurable objective for the organization.</small>
                                @error('objective') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="aboutDescription">Description</label>
                                <textarea id="aboutDescription" rows="4" class="form-control" wire:model.defer="description" placeholder="Enter general description"></textarea>
                                <small class="text-muted">A concise overview shown across site sections.</small>
                                @error('description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="aboutWhatIs">What is BiLTA</label>
                                <textarea id="aboutWhatIs" rows="5" class="form-control" wire:model.defer="what_is" placeholder="Explain what BiLTA is"></textarea>
                                <small class="text-muted">Use this for the primary identity/definition paragraph.</small>
                                @error('what_is') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="aboutWhoWeAre">Who we are</label>
                                <textarea id="aboutWhoWeAre" rows="5" class="form-control" wire:model.defer="who_we_are" placeholder="Describe who you are as an organization"></textarea>
                                <small class="text-muted">Use plain, reader-friendly language for public visitors.</small>
                                @error('who_we_are') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap align-items-center">
                            <button type="submit" class="btn btn-primary">
                                {{ $updateAboutUs ? 'Update Details' : 'Save Details' }}
                            </button>

                            @if ($updateAboutUs)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger ml-2">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Company About Us Records</h5>
                    <span class="badge badge-light">{{ $about_uses->total() }} Items</span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Vision</th>
                                    <th>Mission</th>
                                    <th>Objective</th>
                                    <th>Description</th>
                                    <th>What is</th>
                                    <th>Who we are</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($about_uses as $about_us)
                                    <tr>
                                        <td>{{ \Illuminate\Support\Str::limit($about_us->vision, 80) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($about_us->mission, 80) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($about_us->objective, 80) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($about_us->description, 80) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($about_us->what_is, 80) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($about_us->who_we_are, 80) }}</td>
                                        <td class="text-right">
                                            <button wire:click="edit({{ $about_us->id }})" class="btn btn-outline-primary btn-sm">Edit</button>
                                            <button onclick="deleteAboutUs({{ $about_us->id }})" class="btn btn-outline-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No About Us records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $about_uses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteAboutUs(id) {
            if (confirm("Are you sure to delete this record?")) {
                window.livewire.emit('deleteAboutUs', id);
            }
        }
    </script>

</div>
