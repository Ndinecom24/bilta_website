<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero text-center mb-5">
            <h2 class="mb-2">
                <i class="fas fa-globe-africa" style="color: #c33205;"></i>
                Our Projects Map
            </h2>
            <p class="lead mb-0">Explore where translation work is making an impact across language communities.</p>
        </section>

        {{-- Filter Bar --}}
        <div class="row mb-4">
            <div class="col-md-6 col-lg-4 mx-auto">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-filter"></i></span>
                    <select wire:model="filterCategory" class="form-control" style="border-left: 0;">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="row mb-4 justify-content-center text-center">
            <div class="col-auto">
                <div class="d-inline-flex align-items-center px-3 py-2 bg-white rounded shadow-sm">
                    <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                    <span class="font-weight-bold mr-1">{{ $mapMarkers->count() }}</span>
                    <span class="text-muted small">Locations on map</span>
                </div>
            </div>
            <div class="col-auto">
                <div class="d-inline-flex align-items-center px-3 py-2 bg-white rounded shadow-sm">
                    <i class="fas fa-project-diagram text-primary mr-2"></i>
                    <span class="font-weight-bold mr-1">{{ $totalActive }}</span>
                    <span class="text-muted small">Total active projects</span>
                </div>
            </div>
        </div>

        {{-- Map --}}
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 12px;" wire:ignore>
                    <div id="public-projects-map" style="height: 500px; width: 100%;"></div>
                </div>
            </div>

            {{-- Project Detail Panel --}}
            <div class="col-lg-4 mb-4">
                @if($selectedProject)
                    <div class="card shadow-sm border-0 mb-3" style="border-radius: 12px; border-left: 4px solid #c33205 !important;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="font-weight-bold mb-0" style="color: #0a0a2e;">{{ $selectedProject->title }}</h5>
                                <button wire:click="clearSelection" class="btn btn-sm btn-light rounded-circle" style="width:28px;height:28px;padding:0;">
                                    <i class="fas fa-times" style="font-size:0.7rem;"></i>
                                </button>
                            </div>

                            <div class="mb-3">
                                @if($selectedProject->myCategory)
                                    <span class="badge" style="background:#e8f4fd;color:#0277bd;font-size:0.75rem;">
                                        {{ $selectedProject->myCategory->name }}
                                    </span>
                                @endif
                                <span class="badge" style="background:#e8f5e9;color:#2e7d32;font-size:0.75rem;">
                                    {{ $selectedProject->status->name ?? 'Active' }}
                                </span>
                            </div>

                            <div class="mb-3">
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-map-marker-alt mr-1" style="color:#c33205;"></i>
                                    {{ $selectedProject->location }}
                                </p>
                                @if($selectedProject->locations && $selectedProject->locations->count() > 0)
                                    <div class="mb-2">
                                        <small class="font-weight-bold d-block mb-1">Locations ({{ $selectedProject->locations->count() }}):</small>
                                        @foreach($selectedProject->locations as $loc)
                                            <div class="d-flex align-items-center small text-muted mb-1">
                                                <i class="fas fa-circle mr-1" style="font-size:5px;color:#c33205;"></i>
                                                {{ $loc->name ?: 'Location' }}
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <p class="text-muted small mb-1">
                                    <i class="fas fa-user mr-1"></i>
                                    {{ $selectedProject->author }}
                                </p>
                                <p class="text-muted small mb-0">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $selectedProject->post_date }}
                                </p>
                            </div>

                            <p class="small mb-3" style="color: #444;">
                                {!! Str::limit(strip_tags($selectedProject->short_description), 250) !!}
                            </p>

                            <a href="{{ route('projects.details', $selectedProject) }}" class="btn btn-sm w-100" style="background:#c33205;color:#fff;border-radius:8px;">
                                <i class="fas fa-eye mr-1"></i> View Full Project
                            </a>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm border-0" style="border-radius: 12px;">
                        <div class="card-body text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-hand-pointer fa-3x" style="color: #ddd;"></i>
                            </div>
                            <h6 class="text-muted">Click a marker on the map</h6>
                            <p class="text-muted small mb-0">Select a project to view its details here.</p>
                        </div>
                    </div>
                @endif

                {{-- Quick List --}}
                <div class="card shadow-sm border-0 mt-3" style="border-radius: 12px;">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="mb-0 font-weight-bold" style="color:#0a0a2e;">
                            <i class="fas fa-list mr-1" style="color:#c33205;"></i> All Mapped Projects
                        </h6>
                    </div>
                    <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                        @forelse($projects as $project)
                            <a href="javascript:void(0)" wire:click="selectProject({{ $project->id }})"
                               class="d-flex align-items-center px-3 py-2 border-bottom text-decoration-none" style="transition: background 0.2s;"
                               onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='transparent'">
                                <i class="fas fa-map-pin mr-2" style="color:#c33205; font-size: 0.8rem;"></i>
                                <div class="flex-grow-1">
                                    <span class="d-block small font-weight-bold" style="color:#333;">{{ $project->title }}</span>
                                    <span class="d-block small text-muted">{{ $project->location }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-4 text-muted small">
                                No projects to display on the map yet.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <style>
        .project-popup { min-width: 180px; }
        .project-popup h6 { margin: 0 0 5px; font-weight: 700; color: #0a0a2e; font-size: 0.9rem; }
        .project-popup .badge { font-size: 0.65rem; margin-right: 3px; }
        .project-popup p { margin: 3px 0; font-size: 0.78rem; color: #555; }
        .leaflet-popup-content-wrapper { border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .leaflet-popup-tip { box-shadow: none; }
        #public-projects-map { z-index: 1; }
        .custom-map-pin { position: relative; display: flex; align-items: center; justify-content: center; }
        .custom-map-pin .pin-icon {
            width: 32px; height: 42px;
            filter: drop-shadow(0 3px 4px rgba(0,0,0,0.35));
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initProjectsMap();
        });

        // Reinitialize map on Livewire updates
        document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', () => {
                setTimeout(() => {
                    if (document.getElementById('public-projects-map') && !document.getElementById('public-projects-map')._leaflet_id) {
                        initProjectsMap();
                    }
                }, 100);
            });
        });

        function initProjectsMap() {
            const mapEl = document.getElementById('public-projects-map');
            if (!mapEl || mapEl._leaflet_id) return;

            const map = L.map('public-projects-map').setView([-13.1339, 27.8493], 6);

            // --- Tile Layers ---
            const streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                maxZoom: 19,
            });

            const satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: '&copy; Esri &mdash; Esri, DeLorme, NAVTEQ',
                maxZoom: 18,
            });

            const terrain = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://opentopomap.org">OpenTopoMap</a> contributors',
                maxZoom: 17,
            });

            const dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://carto.com/">CARTO</a>',
                maxZoom: 19,
            });

            const hybrid = L.layerGroup([
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 18,
                }),
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    opacity: 0.35,
                })
            ]);

            // Add default layer
            streets.addTo(map);

            // Layer control
            const baseLayers = {
                '🗺️ Streets': streets,
                '🛰️ Satellite': satellite,
                '🛰️ Hybrid': hybrid,
                '⛰️ Terrain': terrain,
                '🌑 Dark': dark,
            };

            L.control.layers(baseLayers, null, { position: 'topright', collapsed: true }).addTo(map);

            const markers = L.markerClusterGroup({
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: true,
                zoomToBoundsOnClick: true,
                maxClusterRadius: 50
            });

            const mapMarkers = @json($mapMarkers);

            mapMarkers.forEach(function (item) {
                if (!item.latitude || !item.longitude) return;

                const icon = L.divIcon({
                    className: 'custom-map-pin',
                    html: `<svg class="pin-icon" viewBox="0 0 32 42" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 0C7.2 0 0 7.2 0 16c0 12 16 26 16 26s16-14 16-26C32 7.2 24.8 0 16 0z" fill="#c33205"/>
                        <circle cx="16" cy="14" r="7" fill="white" opacity="0.9"/>
                        <circle cx="16" cy="14" r="4" fill="#8b1e03"/>
                    </svg>`,
                    iconSize: [32, 42],
                    iconAnchor: [16, 42],
                    popupAnchor: [0, -38]
                });

                const categoryName = item.category_name || '';
                const popupContent = `
                    <div class="project-popup">
                        <h6>${item.title}</h6>
                        ${categoryName ? '<span class="badge" style="background:#e8f4fd;color:#0277bd;">' + categoryName + '</span>' : ''}
                        <p><i class="fas fa-map-marker-alt" style="color:#c33205;"></i> ${item.location || ''}</p>
                        <p>${(item.short_description || '').replace(/<[^>]*>/g, '').substring(0, 80)}...</p>
                    </div>
                `;

                const marker = L.marker([item.latitude, item.longitude], { icon: icon })
                    .bindPopup(popupContent);

                marker.on('click', function () {
                    @this.call('selectProject', item.project_id);
                });

                markers.addLayer(marker);
            });

            map.addLayer(markers);

            if (mapMarkers.length > 0) {
                const validItems = mapMarkers.filter(m => m.latitude && m.longitude);
                if (validItems.length > 0) {
                    const bounds = L.latLngBounds(validItems.map(m => [m.latitude, m.longitude]));
                    map.fitBounds(bounds, { padding: [40, 40] });
                }
            }
        }
    </script>
</div>
