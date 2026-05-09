<div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Home Intro</h1>
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
                    <h5 class="mb-0">{{ $updateHomeIntro ? 'Edit Home Intro' : 'Add Home Intro' }}</h5>

                    @if ($updateHomeIntro)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateHomeIntro ? 'update' : 'store' }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="homeIntroName">Title/Name</label>
                                <input id="homeIntroName" type="text" class="form-control" wire:model.defer="name" placeholder="Enter intro title">
                                @error('name') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="homeIntroImage">Intro Image <small class="text-muted">(max 3MB)</small></label>
                                <input id="homeIntroImage" type="file" class="form-control" wire:model="intro_image" accept="image/*">
                                @error('intro_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="homeIntroShort">Short Description</label>
                                <textarea id="homeIntroShort" rows="4" class="form-control" wire:model.defer="short_description" placeholder="Enter short homepage introduction"></textarea>
                                @error('short_description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="font-weight-bold" for="homeIntroLong">Long Description</label>
                                <textarea id="homeIntroLong" rows="6" class="form-control" wire:model.defer="long_description" placeholder="Enter detailed homepage introduction"></textarea>
                                @error('long_description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="submit" class="btn btn-primary">{{ $updateHomeIntro ? 'Update Intro' : 'Save Intro' }}</button>
                            @if ($updateHomeIntro)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Current Home Intro Record</h5>

                    @if (isset($home_intro->id))
                        <div>
                            <button wire:click="edit({{ $home_intro->id }})" class="btn btn-primary btn-sm">Edit</button>
                            <button onclick="deleteHomeIntro({{ $home_intro->id }})" class="btn btn-danger btn-sm">Delete</button>
                        </div>
                    @endif
                </div>

                <div class="card-body">
                    @if (isset($home_intro->id))
                        <div class="row">
                            <div class="col-lg-3 col-md-4 mb-3">
                                @if($home_intro->getFirstMedia('home_intro_images'))
                                    <img
                                        src="{{ $home_intro->getFirstMedia('home_intro_images')->getUrl() }}"
                                        alt="{{ $home_intro->name ?? 'Home Intro' }}"
                                        class="img-fluid rounded border"
                                        style="max-height: 180px; object-fit: cover; width: 100%;">
                                @else
                                    <div class="border rounded p-3 text-muted text-center">No image uploaded</div>
                                @endif
                            </div>

                            <div class="col-lg-9 col-md-8">
                                <table class="table table-hover mb-0">
                                    <tbody>
                                        <tr><th style="width:180px;">Name</th><td>{{ $home_intro->name ?? '-' }}</td></tr>
                                        <tr><th>Short Description</th><td>{{ $home_intro->short_description ?? '-' }}</td></tr>
                                        <tr><th>Long Description</th><td>{{ $home_intro->long_description ?? '-' }}</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <p class="mb-0 text-muted">No Home Intro record found yet. Use the form above to add one.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Mission Section Slider Images</h5>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="uploadMissionSliderImages" enctype="multipart/form-data" class="mb-3">
                        <div class="form-group mb-2">
                            <label class="font-weight-bold" for="missionSliderImages">Upload Slider Images <small class="text-muted">(multiple, max 4MB each)</small></label>
                            <input id="missionSliderImages" type="file" class="form-control" wire:model="slider_images" accept="image/*" multiple>
                            @error('slider_images') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            @error('slider_images.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Upload Slider Images</button>
                    </form>

                    @if (isset($home_intro->id) && $home_intro->getMedia('mission_slider_images')->count())
                        <div class="row">
                            @foreach ($home_intro->getMedia('mission_slider_images') as $media)
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                    <div class="border rounded p-2 h-100">
                                        <img src="{{ $media->getUrl() }}"
                                            alt="Mission slider image"
                                            class="img-fluid rounded mb-2"
                                            style="height:140px; width:100%; object-fit:cover;">

                                        <button type="button"
                                            class="btn btn-outline-danger btn-sm btn-block"
                                            wire:click="removeMissionSliderImage({{ $media->id }})">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted mb-0">No mission slider images uploaded yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteHomeIntro(id) {
            if (confirm("Are you sure to delete this record?")) {
                window.livewire.emit('deleteHomeIntro', id);
            }
        }
    </script>

</div>
