<div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-map-marked-alt mr-2"></i>Translation Projects Map
        </h1>
        <a href="{{ route('admin.page.item.projects') }}" class="btn btn-sm btn-outline-primary">
            <i class="fas fa-list mr-1"></i> View All Projects
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProjects }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-project-diagram fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Mapped Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $mappedProjects }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-pin fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Unmapped Projects</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $unmappedProjects }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow-sm h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Map Pins</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLocations }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-pin fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Map --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-globe-africa mr-1"></i> Project Locations
                    </h6>
                    <small class="text-muted">Click markers for details</small>
                </div>
                <div class="card-body p-0" wire:ignore>
                    <div id="admin-projects-map" style="height: 550px; width: 100%; border-radius: 0 0 0.35rem 0.35rem;"></div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4 mb-4">
            {{-- Selected Project Detail --}}
            @if($selectedProject)
                <div class="card shadow-sm mb-3 border-left-primary">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Project Details</h6>
                        <button wire:click="clearSelection" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-bold mb-2">{{ $selectedProject->title }}</h5>
                        <div class="mb-2">
                            <span class="badge badge-{{ $selectedProject->status && $selectedProject->status->name == 'Active' ? 'success' : 'secondary' }}">
                                {{ $selectedProject->status->name ?? 'Unknown' }}
                            </span>
                            @if($selectedProject->myCategory)
                                <span class="badge badge-info">{{ $selectedProject->myCategory->name }}</span>
                            @endif
                        </div>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i> {{ $selectedProject->location }}
                        </p>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-user mr-1"></i> {{ $selectedProject->author }}
                            &bull;
                            <i class="fas fa-calendar mr-1"></i> {{ $selectedProject->post_date }}
                        </p>
                        <p class="small mb-3">{!! Str::limit(strip_tags($selectedProject->short_description), 200) !!}</p>
                        <div class="small text-muted mb-2">
                            <i class="fas fa-crosshairs mr-1"></i>
                            Lat: {{ $selectedProject->latitude }}, Lng: {{ $selectedProject->longitude }}
                        </div>
                        @if($selectedProject->locations && $selectedProject->locations->count() > 0)
                            <div class="mb-2">
                                <small class="font-weight-bold d-block mb-1"><i class="fas fa-map-pin mr-1"></i> Locations ({{ $selectedProject->locations->count() }})</small>
                                @foreach($selectedProject->locations as $loc)
                                    <div class="d-flex align-items-center small text-muted mb-1">
                                        <i class="fas fa-circle mr-1" style="font-size:6px;color:#c33205;"></i>
                                        {{ $loc->name ?: 'Unnamed' }} <span class="ml-1">({{ number_format($loc->latitude, 4) }}, {{ number_format($loc->longitude, 4) }})</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <a href="{{ route('admin.page.item.projects.details', $selectedProject->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye mr-1"></i> View Full Details
                        </a>
                    </div>
                </div>
            @endif

            {{-- Category Breakdown --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie mr-1"></i> Projects by Category
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($categoryStats as $stat)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $stat->myCategory->name ?? 'Uncategorized' }}</span>
                                <span class="badge badge-primary badge-pill">{{ $stat->total }}</span>
                            </div>
                        @empty
                            <div class="list-group-item text-muted text-center">
                                No mapped projects yet
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Legend --}}
            <div class="card shadow-sm">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-1"></i> Map Legend
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <svg width="20" height="26" viewBox="0 0 32 42" style="margin-right:8px;"><path d="M16 0C7.2 0 0 7.2 0 16c0 12 16 26 16 26s16-14 16-26C32 7.2 24.8 0 16 0z" fill="#28a745"/><circle cx="16" cy="14" r="5" fill="white"/></svg>
                        <small>Active Project</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <svg width="20" height="26" viewBox="0 0 32 42" style="margin-right:8px;"><path d="M16 0C7.2 0 0 7.2 0 16c0 12 16 26 16 26s16-14 16-26C32 7.2 24.8 0 16 0z" fill="#6c757d"/><circle cx="16" cy="14" r="5" fill="white"/></svg>
                        <small>Inactive / Other Status</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <span style="display:inline-block;width:20px;height:20px;background:#007bff;border-radius:50%;margin-right:8px;text-align:center;color:white;font-size:11px;line-height:20px;font-weight:bold;">3</span>
                        <small>Cluster (multiple locations)</small>
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
        .project-popup { min-width: 200px; }
        .project-popup h6 { margin: 0 0 5px; font-weight: 700; color: #333; }
        .project-popup .badge { font-size: 0.7rem; }
        .project-popup p { margin: 4px 0; font-size: 0.8rem; color: #666; }
        .leaflet-popup-content-wrapper { border-radius: 8px; }
        .custom-map-pin { position: relative; display: flex; align-items: center; justify-content: center; }
        .custom-map-pin .pin-icon {
            width: 32px; height: 42px;
            filter: drop-shadow(0 3px 4px rgba(0,0,0,0.35));
        }
        .custom-map-pin .pin-dot {
            position: absolute; top: 7px; left: 50%; transform: translateX(-50%);
            width: 14px; height: 14px; border-radius: 50%;
            border: 2px solid white;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize map centered on Zambia
            const map = L.map('admin-projects-map').setView([-13.1339, 27.8493], 6);

            // --- Tile Layers ---
            const streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
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

            // Marker cluster group
            const markers = L.markerClusterGroup({
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: true,
                zoomToBoundsOnClick: true,
                maxClusterRadius: 50
            });

            // Marker data from server (flat list of all locations)
            const mapMarkers = @json($mapMarkers);

            mapMarkers.forEach(function (item) {
                if (!item.latitude || !item.longitude) return;

                const isActive = item.is_active;
                const pinColor = isActive ? '#28a745' : '#6c757d';
                const dotColor = isActive ? '#1e7e34' : '#545b62';

                const icon = L.divIcon({
                    className: 'custom-map-pin',
                    html: `<svg class="pin-icon" viewBox="0 0 32 42" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16 0C7.2 0 0 7.2 0 16c0 12 16 26 16 26s16-14 16-26C32 7.2 24.8 0 16 0z" fill="${pinColor}"/>
                        <circle cx="16" cy="14" r="7" fill="white" opacity="0.9"/>
                        <circle cx="16" cy="14" r="4" fill="${dotColor}"/>
                    </svg>`,
                    iconSize: [32, 42],
                    iconAnchor: [16, 42],
                    popupAnchor: [0, -38]
                });

                const popupContent = `
                    <div class="project-popup">
                        <h6>${item.title}</h6>
                        <span class="badge badge-${isActive ? 'success' : 'secondary'}">${item.status_name}</span>
                        <span class="badge badge-info">${item.category_name}</span>
                        <p><i class="fas fa-map-marker-alt"></i> ${item.location || 'No location'}</p>
                        <p><i class="fas fa-user"></i> ${item.author || 'Unknown'} &bull; ${item.post_date || ''}</p>
                        <p>${(item.short_description || '').substring(0, 100)}...</p>
                        <button onclick="@this.call('selectProject', ${item.project_id})" class="btn btn-sm btn-primary mt-1" style="font-size:0.75rem;">
                            <i class="fas fa-eye"></i> View Details
                        </button>
                    </div>
                `;

                const marker = L.marker([item.latitude, item.longitude], { icon: icon })
                    .bindPopup(popupContent);

                markers.addLayer(marker);
            });

            map.addLayer(markers);

            // Fit bounds if there are markers
            if (mapMarkers.length > 0) {
                const validItems = mapMarkers.filter(m => m.latitude && m.longitude);
                if (validItems.length > 0) {
                    const bounds = L.latLngBounds(validItems.map(m => [m.latitude, m.longitude]));
                    map.fitBounds(bounds, { padding: [30, 30] });
                }
            }
        });
    </script>
</div>
