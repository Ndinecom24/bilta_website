<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Translation Projects</h1>
        <a href="{{ route('admin.page.item.projects.map') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-map-marked-alt mr-1"></i> View Projects Map
        </a>
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
                    <h5 class="mb-0">{{ $updateProjectsItem ? 'Edit Project' : 'Add Project' }}</h5>

                    @if ($updateProjectsItem)
                        <button wire:click="cancel" type="button" class="btn btn-sm btn-outline-secondary">Create New</button>
                    @endif
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="{{ $updateProjectsItem ? 'update' : 'store' }}" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-8 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectTitle">Title</label>
                                <input id="projectTitle" type="text" class="form-control" wire:model.defer="title" placeholder="Enter project title">
                                @error('title') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectDate">Post Date</label>
                                <input id="projectDate" type="date" class="form-control" wire:model.defer="post_date">
                                @error('post_date') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectShortDescription">Short Description</label>
                                <textarea id="projectShortDescription" rows="3" class="form-control" wire:model.defer="short_description" placeholder="Write a short summary"></textarea>
                                @error('short_description') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectDetails">Details</label>
                                <input id="projectDetails" type="hidden" wire:model.defer="details">
                                <trix-editor input="projectDetails" class="bg-white" style="min-height: 350px;"></trix-editor>
                                <small class="text-muted d-block mt-1">Use the editor toolbar to format headings, lists, links, and emphasis.</small>
                                @error('details') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectAuthor">Author</label>
                                <input id="projectAuthor" type="text" class="form-control" wire:model.defer="author" placeholder="Author name">
                                @error('author') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectStatus">Status</label>
                                <select id="projectStatus" class="form-control" wire:model.defer="status_id">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                                @error('status_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectCategory">Category</label>
                                <select id="projectCategory" class="form-control" wire:model.defer="category_id">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-4 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectOrder">Order</label>
                                <input id="projectOrder" type="number" min="0" class="form-control" wire:model.defer="display_order" placeholder="0">
                                @error('display_order') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectLocation">Location</label>
                                <input id="projectLocation" type="text" class="form-control" wire:model.defer="location" placeholder="Project location">
                                @error('location') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectMap">Location Map URL</label>
                                <input id="projectMap" type="text" class="form-control" wire:model.defer="location_map" placeholder="Map or embed URL">
                                @error('location_map') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Project Locations Section --}}
                            <div class="col-lg-12 col-md-12 mb-3">
                                <div class="card border">
                                    <div class="card-header py-2 d-flex justify-content-between align-items-center bg-light">
                                        <span class="font-weight-bold"><i class="fas fa-map-marker-alt mr-1 text-danger"></i> Project Locations ({{ count($projectLocations) }})</span>
                                        <div>
                                            <button type="button" class="btn btn-outline-success btn-sm mr-1" wire:click="addLocation">
                                                <i class="fas fa-plus mr-1"></i> Add Manually
                                            </button>
                                            <button type="button" class="btn btn-outline-info btn-sm" onclick="toggleMapPicker()">
                                                <i class="fas fa-map mr-1"></i> Pick on Map
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body p-2">
                                        @forelse($projectLocations as $index => $loc)
                                            <div class="row align-items-center border rounded p-2 mb-2 mx-0 bg-white">
                                                <div class="col-md-4">
                                                    <input type="text" class="form-control form-control-sm" wire:model.defer="projectLocations.{{ $index }}.name" placeholder="Location name">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" step="any" class="form-control form-control-sm" wire:model.defer="projectLocations.{{ $index }}.latitude" placeholder="Latitude">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" step="any" class="form-control form-control-sm" wire:model.defer="projectLocations.{{ $index }}.longitude" placeholder="Longitude">
                                                </div>
                                                <div class="col-md-2 text-right">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" wire:click="removeLocation({{ $index }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-muted text-center py-3">
                                                <i class="fas fa-map-marker-alt fa-2x mb-2 d-block" style="opacity:0.3;"></i>
                                                No locations added yet. Click "Add Manually" or "Pick on Map" to add.
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>

                            {{-- Inline Map Picker Card --}}
                            <div class="col-lg-12 col-md-12 mb-3" id="mapPickerCard" style="display: none;">
                                <div class="card border-info">
                                    <div class="card-header bg-info text-white py-2 d-flex justify-content-between align-items-center">
                                        <span><i class="fas fa-map-marker-alt mr-1"></i> Pick Project Location</span>
                                        <button type="button" class="btn btn-sm btn-light" onclick="toggleMapPicker()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="px-3 pt-3 pb-2">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" id="mapPickerSearch" class="form-control" placeholder="Search location...">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-secondary" type="button" id="mapPickerSearchBtn">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="text" id="mapPickerLocationName" class="form-control form-control-sm" placeholder="Location name (optional)">
                                                </div>
                                                <div class="col-md-4 text-muted small mt-2 mt-md-0">
                                                    <i class="fas fa-info-circle mr-1"></i> Click the map to place a pin, then click "Add Location".
                                                </div>
                                            </div>
                                        </div>
                                        <div id="mapPickerContainer" style="height: 400px; width: 100%;"></div>
                                        <div class="px-3 py-2 bg-light border-top">
                                            <div class="row align-items-center">
                                                <div class="col-sm-3">
                                                    <small class="font-weight-bold">Lat:</small>
                                                    <span id="pickerLatDisplay" class="small text-primary">—</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <small class="font-weight-bold">Lng:</small>
                                                    <span id="pickerLngDisplay" class="small text-primary">—</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <small class="text-muted" id="pickerAddressDisplay"></small>
                                                </div>
                                                <div class="col-sm-3 text-right">
                                                    <button type="button" class="btn btn-success btn-sm" id="confirmMapPicker">
                                                        <i class="fas fa-plus mr-1"></i> Add This Location
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($updateProjectsItem && $project && $project->getFirstMedia('project_title_images'))
                                <div class="col-lg-12 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-1">Current Title Banner</p>
                                    <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}" style="max-height: 90px;" alt="Project title banner">
                                </div>
                            @endif

                            <div class="col-lg-12 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectTitleImage">Title Image <span class="text-muted font-weight-normal">(optional)</span></label>
                                <input id="projectTitleImage" type="file" class="form-control" wire:model="title_image" accept="image/*">
                                <small class="text-muted">Max 5 MB. Images are auto-compressed to save space.</small>
                                @error('title_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectImages">Project Images <span class="text-muted font-weight-normal">(optional)</span></label>
                                <input id="projectImages" type="file" class="form-control" wire:model="project_image" multiple accept="image/*">
                                <small class="text-muted">Max 5 MB per image. Images are auto-compressed.</small>
                                @error('project_image') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @error('project_image.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-lg-6 col-md-12 mb-3">
                                <label class="font-weight-bold" for="projectFiles">Project Files <span class="text-muted font-weight-normal">(optional)</span></label>
                                <input id="projectFiles" type="file" class="form-control" wire:model="project_file" multiple>
                                <small class="text-muted">Max 10 MB per file.</small>
                                @error('project_file') <span class="text-danger d-block">{{ $message }}</span> @enderror
                                @error('project_file.*') <span class="text-danger d-block">{{ $message }}</span> @enderror
                            </div>

                            @if ($updateProjectsItem && $project)
                                <div class="col-lg-6 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing Gallery Files</p>
                                    @forelse ($project->getMedia('project_images') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <span>{{ $item->name }}</span>
                                            <button wire:click.prevent="removeImage({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No project images.</div>
                                    @endforelse
                                </div>

                                <div class="col-lg-6 col-md-12 mb-3">
                                    <p class="font-weight-bold mb-2">Existing Attachment Files</p>
                                    @forelse ($project->getMedia('project_files') as $item)
                                        <div class="d-flex align-items-center justify-content-between border rounded p-2 mb-2">
                                            <span>{{ $item->name }}</span>
                                            <button wire:click.prevent="removeFile({{ $item->id }})" type="button" class="btn btn-sm btn-outline-danger">Remove</button>
                                        </div>
                                    @empty
                                        <div class="text-muted">No project files.</div>
                                    @endforelse
                                </div>
                            @endif
                        </div>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary">{{ $updateProjectsItem ? 'Update Project' : 'Save Project' }}</button>
                            @if ($updateProjectsItem)
                                <button wire:click.prevent="cancel" type="button" class="btn btn-outline-danger">Cancel Edit</button>
                            @endif
                            <div wire:loading class="text-info small">Saving...</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Project Records</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 90px;">Image</th>
                                    <th style="width: 240px;">Title</th>
                                    <th>Short Description</th>
                                    <th style="width: 140px;">Post Date</th>
                                    <th style="width: 140px;">Author</th>
                                    <th style="width: 120px;">Status</th>
                                    <th style="width: 160px;">Location</th>
                                    <th style="width: 90px;">Order</th>
                                    <th style="width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($translation_projects as $translation_project)
                                    <tr>
                                        <td>
                                            @if ($translation_project->getFirstMedia('project_title_images'))
                                                <img src="{{ $translation_project->getFirstMedia('project_title_images')->getUrl() }}" style="height: 52px; width: 72px; object-fit: cover;" alt="Project banner">
                                            @endif
                                        </td>
                                        <td>{{ $translation_project->title }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit(strip_tags($translation_project->short_description), 120) }}</td>
                                        <td>{{ $translation_project->post_date }}</td>
                                        <td>{{ $translation_project->author }}</td>
                                        <td>{{ $translation_project->status->name ?? '-' }}</td>
                                        <td>{{ $translation_project->location ?? '-' }}</td>
                                        <td>{{ $translation_project->display_order ?? 0 }}</td>
                                        <td>
                                            <button wire:click="edit({{ $translation_project->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteOurProjectsItem({{ $translation_project->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No project records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $translation_projects->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('trix-file-accept', function (event) {
            event.preventDefault();
        });

        // Sync Trix editor content to Livewire on every change
        document.addEventListener('trix-change', function (event) {
            var input = event.target.inputElement;
            if (input && input.id === 'projectDetails') {
                // Update the hidden input value
                input.value = event.target.innerHTML;
                // Sync to Livewire without triggering a re-render (deferred)
                var component = Livewire.find(
                    event.target.closest('[wire\\:id]').getAttribute('wire:id')
                );
                if (component) {
                    component.set('details', event.target.innerHTML, true);
                }
            }
        });

        // Load content into Trix editor (for edit mode and reset)
        // We store the pending content and apply it after Livewire finishes DOM updates
        var pendingTrixContent = null;

        window.addEventListener('load-trix-content', function (event) {
            var fieldId = event.detail.field || 'projectDetails';
            var content = event.detail.content || '';
            pendingTrixContent = { field: fieldId, content: content };

            // Try immediately (works for reset/cancel where DOM doesn't change much)
            applyTrixContent();
        });

        function applyTrixContent() {
            if (!pendingTrixContent) return;

            var fieldId = pendingTrixContent.field;
            var content = pendingTrixContent.content;
            var attempts = 0;
            var maxAttempts = 20;

            function tryLoad() {
                var editor = document.querySelector('trix-editor[input="' + fieldId + '"]');
                if (editor && editor.editor) {
                    editor.editor.loadHTML(content);
                    pendingTrixContent = null;
                } else if (attempts < maxAttempts) {
                    attempts++;
                    setTimeout(tryLoad, 100);
                }
            }
            tryLoad();
        }

        // After Livewire processes a message and updates the DOM, apply pending content
        document.addEventListener('DOMContentLoaded', function() {
            if (window.Livewire) {
                Livewire.hook('message.processed', function() {
                    if (pendingTrixContent) {
                        // Give the DOM a moment to fully settle after morph
                        setTimeout(applyTrixContent, 150);
                    }
                });
            }
        });

        function deleteOurProjectsItem(id) {
            if (confirm("Are you sure to delete this project record?")) {
                window.livewire.emit('deleteProjects', id);
            }
        }
    </script>

    {{-- Leaflet for Map Picker --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #mapPickerContainer { z-index: 1; }
        .picker-crosshair { cursor: crosshair !important; }
        .map-picker-pin {
            width: 20px; height: 20px;
            background: #cd5b13;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 2px 8px rgba(205,91,19,0.5);
        }
    </style>

    <script>
        (function() {
            let pickerMap = null;
            let pickerMarker = null;
            let pickedLat = null;
            let pickedLng = null;

            // Reset map state so it gets recreated on next open
            function destroyPickerMap() {
                if (pickerMap) {
                    try { pickerMap.remove(); } catch(e) {}
                    pickerMap = null;
                }
                pickerMarker = null;
                pickedLat = null;
                pickedLng = null;
            }

            // When Livewire re-renders (e.g. after clicking Edit), destroy the old map
            document.addEventListener('DOMContentLoaded', function() {
                if (window.Livewire) {
                    Livewire.hook('message.processed', function() {
                        destroyPickerMap();
                    });
                }
            });

            // Toggle map picker visibility
            window.toggleMapPicker = function() {
                var card = document.getElementById('mapPickerCard');
                var isHidden = card.style.display === 'none';

                if (isHidden) {
                    card.style.display = 'block';
                    // Small delay to let the DOM render, then init/resize map
                    setTimeout(function() {
                        initPickerMap();
                    }, 250);
                } else {
                    card.style.display = 'none';
                }
            };

            function initPickerMap() {
                // If the container element changed (Livewire re-render), destroy old map
                var container = document.getElementById('mapPickerContainer');
                if (pickerMap && pickerMap.getContainer() !== container) {
                    destroyPickerMap();
                }

                if (pickerMap) {
                    pickerMap.invalidateSize();
                    return;
                }

                const startLat = -13.1339;
                const startLng = 27.8493;
                const startZoom = 6;

                pickerMap = L.map('mapPickerContainer').setView([startLat, startLng], startZoom);

                // Tile layers
                const streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap',
                    maxZoom: 19,
                });

                const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '&copy; Esri',
                    maxZoom: 18,
                });

                const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenTopoMap',
                    maxZoom: 17,
                });

                streets.addTo(pickerMap);

                L.control.layers({
                    'Streets': streets,
                    'Satellite': satellite,
                    'Terrain': terrain
                }, null, { position: 'topright' }).addTo(pickerMap);



                // Click handler
                pickerMap.on('click', function(e) {
                    placePickerMarker(e.latlng.lat, e.latlng.lng);
                });

                // Crosshair cursor
                document.getElementById('mapPickerContainer').classList.add('picker-crosshair');
            }

            function placePickerMarker(lat, lng) {
                pickedLat = Math.round(lat * 10000000) / 10000000;
                pickedLng = Math.round(lng * 10000000) / 10000000;

                if (pickerMarker) {
                    pickerMarker.setLatLng([lat, lng]);
                } else {
                    const icon = L.divIcon({
                        className: 'custom-picker-marker',
                        html: '<div class="map-picker-pin"></div>',
                        iconSize: [20, 20],
                        iconAnchor: [10, 10]
                    });
                    pickerMarker = L.marker([lat, lng], { icon: icon, draggable: true }).addTo(pickerMap);

                    pickerMarker.on('dragend', function(e) {
                        const pos = e.target.getLatLng();
                        placePickerMarker(pos.lat, pos.lng);
                    });
                }

                document.getElementById('pickerLatDisplay').textContent = pickedLat;
                document.getElementById('pickerLngDisplay').textContent = pickedLng;

                // Reverse geocode for address hint
                fetch('https://nominatim.openstreetmap.org/reverse?format=json&lat=' + pickedLat + '&lon=' + pickedLng + '&zoom=10')
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        if (data && data.display_name) {
                            document.getElementById('pickerAddressDisplay').textContent = data.display_name.substring(0, 50) + '...';
                        }
                    }).catch(function() {});
            }

            // Search location
            document.addEventListener('DOMContentLoaded', function() {
                var searchBtn = document.getElementById('mapPickerSearchBtn');
                var searchInput = document.getElementById('mapPickerSearch');

                function doSearch() {
                    var query = searchInput.value.trim();
                    if (!query || !pickerMap) return;

                    fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + encodeURIComponent(query) + '&limit=1')
                        .then(function(r) { return r.json(); })
                        .then(function(results) {
                            if (results.length > 0) {
                                var lat = parseFloat(results[0].lat);
                                var lng = parseFloat(results[0].lon);
                                pickerMap.setView([lat, lng], 12);
                                placePickerMarker(lat, lng);
                            } else {
                                alert('Location not found. Try a different search term.');
                            }
                        }).catch(function() { alert('Search failed. Please try again.'); });
                }

                if (searchBtn) searchBtn.addEventListener('click', doSearch);
                if (searchInput) searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') { e.preventDefault(); doSearch(); }
                });
            });

            // Confirm button — adds the picked location via Livewire
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('confirmMapPicker').addEventListener('click', function() {
                    if (pickedLat !== null && pickedLng !== null) {
                        var nameInput = document.getElementById('mapPickerLocationName');
                        var locationName = (nameInput && nameInput.value.trim()) ? nameInput.value.trim() : 'Location';

                        // Call Livewire method to add a new location row
                        @this.call('addLocationFromMap', locationName, pickedLat, pickedLng);

                        // Reset picker state for next pick
                        if (nameInput) nameInput.value = '';
                        document.getElementById('pickerLatDisplay').textContent = '—';
                        document.getElementById('pickerLngDisplay').textContent = '—';
                        document.getElementById('pickerAddressDisplay').textContent = '';
                        if (pickerMarker) {
                            pickerMap.removeLayer(pickerMarker);
                            pickerMarker = null;
                        }
                        pickedLat = null;
                        pickedLng = null;
                    } else {
                        alert('Please click on the map to select a location first.');
                    }
                });
            });
        })();
    </script>
</div>
