<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero text-center mb-5">
            <h2 class="mb-2">
                <i class="fas fa-globe-africa me-2" style="opacity:0.7;"></i>
                Our Projects Map
            </h2>
            <p class="lead mb-0">Explore where translation work is making an impact across language communities.</p>
        </section>

        {{-- Filter & Stats Bar --}}
        <div class="map-toolbar mb-4">
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <div class="map-filter-box">
                        <i class="fas fa-filter"></i>
                        <select wire:model="filterCategory" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-3 justify-content-md-end">
                        <div class="map-stat-chip">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>{{ $mapMarkers->count() }}</strong>
                            <span>Locations</span>
                        </div>
                        <div class="map-stat-chip">
                            <i class="fas fa-project-diagram"></i>
                            <strong>{{ $totalActive }}</strong>
                            <span>Active Projects</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Map + Detail Panel --}}
        <div class="row g-4">
            <div class="col-lg-8 mb-4">
                <div class="map-card" wire:ignore>
                    <div id="public-projects-map"></div>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                @if($selectedProject)
                    <div class="map-detail-card">
                        <div class="map-detail-header">
                            <h5>{{ $selectedProject->title }}</h5>
                            <button wire:click="clearSelection" class="map-close-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <div class="map-detail-badges">
                            @if($selectedProject->myCategory)
                                <span class="map-badge map-badge-blue">
                                    {{ $selectedProject->myCategory->name }}
                                </span>
                            @endif
                            <span class="map-badge map-badge-green">
                                {{ $selectedProject->status->name ?? 'Active' }}
                            </span>
                        </div>

                        <div class="map-detail-meta">
                            <div class="map-meta-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $selectedProject->location }}</span>
                            </div>

                            @if($selectedProject->locations && $selectedProject->locations->count() > 0)
                                <div class="map-locations-list">
                                    <small class="fw-bold d-block mb-1">Locations ({{ $selectedProject->locations->count() }}):</small>
                                    @foreach($selectedProject->locations as $loc)
                                        <div class="map-location-item">
                                            <span class="map-location-dot"></span>
                                            {{ $loc->name ?: 'Location' }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <div class="map-meta-item">
                                <i class="fas fa-user"></i>
                                <span>{{ $selectedProject->author }}</span>
                            </div>
                            <div class="map-meta-item">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $selectedProject->post_date }}</span>
                            </div>
                        </div>

                        <p class="map-detail-desc">
                            {!! Str::limit(strip_tags($selectedProject->short_description), 250) !!}
                        </p>

                        <a href="{{ route('projects.details', $selectedProject) }}" class="news-btn w-100 justify-content-center">
                            <i class="fas fa-eye me-1"></i> View Full Project
                        </a>
                    </div>
                @else
                    <div class="map-detail-card map-detail-empty">
                        <div class="map-empty-icon">
                            <i class="fas fa-hand-pointer"></i>
                        </div>
                        <h6>Click a marker on the map</h6>
                        <p>Select a project to view its details here.</p>
                    </div>
                @endif

                {{-- Quick List --}}
                <div class="map-list-card mt-3">
                    <div class="map-list-header">
                        <h6>
                            <i class="fas fa-list me-2"></i> All Mapped Projects
                        </h6>
                    </div>
                    <div class="map-list-body">
                        @forelse($projects as $project)
                            <a href="javascript:void(0)" wire:click="selectProject({{ $project->id }})"
                               class="map-list-item">
                                <i class="fas fa-map-pin"></i>
                                <div>
                                    <span class="map-list-title">{{ $project->title }}</span>
                                    <span class="map-list-location">{{ $project->location }}</span>
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
        /* ---- Map Page Styles ---- */

        .map-toolbar {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 16px 20px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05);
        }

        .map-filter-box {
            position: relative;
        }

        .map-filter-box i {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.85rem;
            z-index: 1;
        }

        .map-filter-box .form-select {
            padding-left: 38px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            height: 44px;
            font-size: 0.9rem;
            color: #334155;
        }

        .map-filter-box .form-select:focus {
            border-color: #cd5b13;
            box-shadow: 0 0 0 3px rgba(205, 91, 19, 0.1);
        }

        .map-stat-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 0.85rem;
        }

        .map-stat-chip i {
            color: #cd5b13;
            font-size: 0.9rem;
        }

        .map-stat-chip strong {
            color: #0f172a;
            font-weight: 700;
        }

        .map-stat-chip span {
            color: #64748b;
        }

        /* Map container */
        .map-card {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
        }

        #public-projects-map {
            height: 540px;
            width: 100%;
            z-index: 1;
        }

        /* Detail panel */
        .map-detail-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
        }

        .map-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 14px;
        }

        .map-detail-header h5 {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            line-height: 1.35;
        }

        .map-close-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
            font-size: 0.7rem;
            transition: all 0.2s;
        }

        .map-close-btn:hover {
            background: #fee2e2;
            border-color: #fca5a5;
            color: #dc2626;
        }

        .map-detail-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 14px;
        }

        .map-badge {
            font-size: 0.73rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .map-badge-blue {
            background: #eff6ff;
            color: #1565c0;
        }

        .map-badge-green {
            background: #f0fdf4;
            color: #16a34a;
        }

        .map-detail-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 14px;
        }

        .map-meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.84rem;
            color: #64748b;
        }

        .map-meta-item i {
            color: #cd5b13;
            width: 14px;
            text-align: center;
            font-size: 0.78rem;
        }

        .map-locations-list {
            padding-left: 22px;
            margin-top: 2px;
        }

        .map-location-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.82rem;
            color: #64748b;
            margin-bottom: 3px;
        }

        .map-location-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: #cd5b13;
            flex-shrink: 0;
        }

        .map-detail-desc {
            font-size: 0.88rem;
            color: #475569;
            line-height: 1.65;
            margin-bottom: 16px;
        }

        /* Empty state */
        .map-detail-empty {
            text-align: center;
            padding: 48px 22px;
        }

        .map-empty-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #f1f5f9;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin: 0 auto 14px;
        }

        .map-detail-empty h6 {
            color: #64748b;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .map-detail-empty p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin: 0;
        }

        /* Quick list card */
        .map-list-card {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06);
        }

        .map-list-header {
            padding: 14px 18px;
            border-bottom: 1px solid #f1f5f9;
        }

        .map-list-header h6 {
            margin: 0;
            font-weight: 700;
            color: #0f172a;
            font-size: 0.9rem;
        }

        .map-list-header i {
            color: #cd5b13;
        }

        .map-list-body {
            max-height: 300px;
            overflow-y: auto;
        }

        .map-list-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            text-decoration: none;
            border-bottom: 1px solid #f8fafc;
            transition: all 0.15s;
        }

        .map-list-item:hover {
            background: #f0f5ff;
        }

        .map-list-item i {
            color: #cd5b13;
            font-size: 0.78rem;
            flex-shrink: 0;
        }

        .map-list-title {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #1e293b;
        }

        .map-list-location {
            display: block;
            font-size: 0.78rem;
            color: #94a3b8;
        }

        .map-list-item:hover .map-list-title {
            color: #cd5b13;
        }

        /* Leaflet popups */
        .project-popup { min-width: 180px; }
        .project-popup h6 { margin: 0 0 5px; font-weight: 700; color: #0f172a; font-size: 0.9rem; }
        .project-popup .badge { font-size: 0.65rem; margin-right: 3px; }
        .project-popup p { margin: 3px 0; font-size: 0.78rem; color: #555; }
        .leaflet-popup-content-wrapper { border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.12); }
        .leaflet-popup-tip { box-shadow: none; }
        .custom-map-pin { position: relative; display: flex; align-items: center; justify-content: center; }
        .custom-map-pin .pin-icon {
            width: 32px; height: 42px;
            filter: drop-shadow(0 3px 4px rgba(0,0,0,0.35));
        }

        @media (max-width: 768px) {
            #public-projects-map {
                height: 380px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            initProjectsMap();
        });

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
                        <path d="M16 0C7.2 0 0 7.2 0 16c0 12 16 26 16 26s16-14 16-26C32 7.2 24.8 0 16 0z" fill="#cd5b13"/>
                        <circle cx="16" cy="14" r="7" fill="white" opacity="0.9"/>
                        <circle cx="16" cy="14" r="4" fill="#a34810"/>
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
                        <p><i class="fas fa-map-marker-alt" style="color:#cd5b13;"></i> ${item.location || ''}</p>
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
