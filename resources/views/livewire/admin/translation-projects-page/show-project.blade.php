<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h4 mb-1 text-dark">Project Details</h1>
            <p class="text-muted mb-0">Review and update this translation project and its media assets.</p>
        </div>
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

        <div class="col-md-4 mb-3">
            @if ($project->getFirstMedia('project_title_images'))
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Title Image</h5>
                    </div>
                    <div class="card-body">
                        <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}"
                            class="img-fluid rounded"
                            style="width:100%; max-height:300px; object-fit:cover;"
                            alt="{{ $project->title }}">
                    </div>
                </div>
            @endif

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Additional Project Images</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($project->getMedia('project_images') as $image)
                            <div class="col-md-6 mb-2">
                                <img src="{{ $image->getUrl() }}"
                                     class="img-thumbnail"
                                     style="width:100%; height:120px; object-fit:cover;"
                                     alt="{{ $image->name }}">
                            </div>
                        @empty
                            <div class="col-12 text-muted">No additional images.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Additional Project Files</h5>
                </div>
                <div class="card-body">
                    @forelse ($project->getMedia('project_files') as $file)
                        <div class="mb-2">
                            <a href="{{ $file->getUrl() }}" target="_blank">{{ $file->name }}</a>
                        </div>
                    @empty
                        <div class="text-muted">No additional files.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-3">
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $project->title }}</h5>
                    <span class="badge badge-light">{{ $project->status->name ?? '-' }}</span>
                </div>
                <div class="card-body">
                    <p><strong>Author:</strong> {{ $project->author }}</p>
                    <p><strong>Post Date:</strong> {{ $project->post_date }}</p>
                    <p><strong>Category:</strong> {{ optional($categories->firstWhere('id', $project->category_id))->name ?? '-' }}</p>
                    <p><strong>Location:</strong> {{ $project->location }}</p>
                    <p><strong>Location Map:</strong> {{ $project->location_map }}</p>

                    {{-- Project Locations (multi-location) --}}
                    @if($project->locations && $project->locations->count() > 0)
                        <div class="mb-3">
                            <strong><i class="fas fa-map-marker-alt text-danger mr-1"></i> Project Locations ({{ $project->locations->count() }})</strong>
                            <div class="table-responsive mt-2">
                                <table class="table table-sm table-bordered mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Latitude</th>
                                            <th>Longitude</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($project->locations as $i => $loc)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $loc->name ?: 'Unnamed' }}</td>
                                                <td>{{ $loc->latitude }}</td>
                                                <td>{{ $loc->longitude }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="detailLocationsMap" class="mt-2 border rounded" style="height: 280px;"></div>
                        </div>
                    @endif
                    <p><strong>Display Order:</strong> {{ $project->display_order ?? 0 }}</p>
                    <hr>
                    <p class="mb-1"><strong>Short Description</strong></p>
                    <p>{{ $project->short_description }}</p>
                    <p class="mb-1"><strong>Details</strong></p>
                    <div>{!! $project->details !!}</div>
                </div>
                <div class="card-footer d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.page.item.projects') }}" class="btn btn-secondary">Back to Projects List</a>
                    <button wire:click="edit({{ $project->id }})" class="btn btn-primary">Edit</button>
                    <button onclick="deleteProjectItem({{ $project->id }})" class="btn btn-danger">Delete</button>
                </div>
            </div>

            @if ($updateProjectsItem)
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Project Item</h5>
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Close Editor</button>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="update" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="projectTitle">Title</label>
                                    <input id="projectTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter title">
                                    @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="projectAuthor">Author</label>
                                    <input id="projectAuthor" type="text" class="form-control" wire:model.defer="author" placeholder="Enter author">
                                    @error('author') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="projectShortDescription">Short Description</label>
                                    <textarea id="projectShortDescription" rows="3" class="form-control" wire:model.defer="short_description" placeholder="Enter short description"></textarea>
                                    @error('short_description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="font-weight-bold" for="projectDetails">Project Details</label>
                                    <textarea id="projectDetails" rows="6" class="form-control" wire:model.defer="details" placeholder="Enter project details"></textarea>
                                    @error('details') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold" for="projectPostDate">Post Date</label>
                                    <input id="projectPostDate" type="date" class="form-control" wire:model.defer="post_date">
                                    @error('post_date') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold" for="projectStatus">Status</label>
                                    <select id="projectStatus" class="form-control" wire:model.defer="status_id">
                                        <option value="">-- Choose --</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold" for="projectCategory">Category</label>
                                    <select id="projectCategory" class="form-control" wire:model.defer="category_id">
                                        <option value="">-- Choose --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="projectLocation">Location</label>
                                    <input id="projectLocation" type="text" class="form-control" wire:model.defer="location" placeholder="Enter location">
                                    @error('location') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="projectLocationMap">Location Map</label>
                                    <input id="projectLocationMap" type="text" class="form-control" wire:model.defer="location_map" placeholder="Enter map URL or text">
                                    @error('location_map') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="font-weight-bold" for="projectOrder">Display Order</label>
                                    <input id="projectOrder" type="number" min="0" class="form-control" wire:model.defer="display_order">
                                    @error('display_order') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="font-weight-bold" for="projectTitleImage">Replace Title Image (optional)</label>
                                    <input id="projectTitleImage" type="file" class="form-control" wire:model="title_image">
                                    @error('title_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="projectImages">Add More Project Images</label>
                                    <input id="projectImages" type="file" class="form-control" wire:model="project_image" multiple>
                                    @error('project_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="font-weight-bold" for="projectFiles">Add More Project Files</label>
                                    <input id="projectFiles" type="file" class="form-control" wire:model="project_file" multiple>
                                    @error('project_file') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Remove Existing Project Images</p>
                                    <div class="row">
                                        @forelse ($project->getMedia('project_images') as $item)
                                            <div class="col-md-4 mb-3">
                                                <img src="{{ $item->getUrl() }}" class="img-fluid rounded mb-2" style="height: 120px; width: 100%; object-fit: cover;" alt="{{ $item->name }}">
                                                <button wire:click.prevent="removeImage({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                            </div>
                                        @empty
                                            <div class="col-12 text-muted">No images to remove.</div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Remove Existing Project Files</p>
                                    @forelse ($project->getMedia('project_files') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <a href="{{ $item->getUrl() }}" target="_blank">{{ $item->name }}</a>
                                            <button wire:click.prevent="removeFile({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No files to remove.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function deleteProjectItem(id) {
            if (confirm("Are you sure you want to delete this project?")) {
                window.livewire.emit('deleteProjects', id);
            }
        }
    </script>

    {{-- Leaflet for detail page locations mini-map --}}
    @if($project->locations && $project->locations->count() > 0)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var mapEl = document.getElementById('detailLocationsMap');
                if (!mapEl) return;

                var locations = @json($project->locations->map(function ($loc) {
                    return ['name' => $loc->name ?: 'Location', 'lat' => $loc->latitude, 'lng' => $loc->longitude];
                }));

                if (locations.length === 0) return;

                var map = L.map('detailLocationsMap').setView([locations[0].lat, locations[0].lng], 8);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap', maxZoom: 19
                }).addTo(map);

                var bounds = [];
                locations.forEach(function (loc) {
                    var marker = L.marker([loc.lat, loc.lng]).addTo(map);
                    marker.bindPopup('<strong>' + loc.name + '</strong><br>Lat: ' + loc.lat + ', Lng: ' + loc.lng);
                    bounds.push([loc.lat, loc.lng]);
                });

                if (bounds.length > 1) {
                    map.fitBounds(bounds, { padding: [30, 30] });
                }
            });
        </script>
    @endif
</div>
