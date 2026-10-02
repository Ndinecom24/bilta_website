<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Service Details</h2>
            <p class="lead mb-0">{{ $title ?? 'Learn more about this ministry service.' }}</p>
        </section>

        <div class="row g-4">
            {{-- Sidebar: Other Services --}}
            <aside class="col-lg-3">
                <div class="modern-sidebar">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <div>
                            <h5 class="sidebar-title mb-1">Our Services</h5>
                            <p class="sidebar-subtitle mb-0">Browse all services</p>
                        </div>
                    </div>

                    <div class="category-list">
                        @foreach ($otherServices as $otherService)
                            <a href="{{ route('services.details', $otherService->id) }}" class="category-item {{ $otherService->id == $service->id ? 'active' : '' }}">
                                <div class="category-content">
                                    <div class="category-dot"></div>
                                    <span class="category-name">{{ $otherService->title }}</span>
                                </div>
                            </a>
                        @endforeach

                        <a href="{{ route('services') }}" class="category-item mt-2">
                            <div class="category-content">
                                <div class="category-dot"></div>
                                <span class="category-name"><i class="fas fa-arrow-left me-1"></i> All Services</span>
                            </div>
                        </a>
                    </div>
                </div>
            </aside>

            {{-- Main Content --}}
            <div class="col-lg-9">
                <section class="modern-news-detail mb-5">

                    {{-- Hero Image (first uploaded image) --}}
                    @php
                        $heroImage = $service->getFirstMedia('service_images');
                    @endphp
                    @if ($heroImage)
                        <div class="news-hero-image">
                            <img loading="lazy"
                                src="{{ $heroImage->getUrl() }}"
                                alt="{{ $service->title }}"
                                style="width:100%; max-height:400px; object-fit:cover; border-radius:12px;">
                        </div>
                    @endif

                    <div class="news-detail-body">
                        <div class="news-meta-row mb-3">
                            <div class="meta-item">
                                <i class="fas fa-hands-helping me-2"></i>
                                <span>Ministry Service</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt me-2"></i>
                                <span>{{ $service->created_at ? $service->created_at->format('M d, Y') : '' }}</span>
                            </div>
                        </div>

                        <h3 class="news-detail-title mb-4">{{ $service->title }}</h3>

                        <div class="news-detail-content">
                            {!! nl2br(e($service->description)) !!}
                        </div>
                    </div>
                </section>

                {{-- Service Images Gallery --}}
                @php
                    $serviceImages = $service->getMedia('service_images');
                @endphp
                @if ($serviceImages->count() > 1)
                    <section class="page-section mb-4">
                        <h4 class="mb-3"><i class="fas fa-images me-2"></i> Gallery</h4>
                        <div class="row g-3">
                            @foreach ($serviceImages as $image)
                                <div class="col-md-4 col-6">
                                    <a href="{{ $image->getUrl() }}" target="_blank">
                                        <img loading="lazy"
                                            src="{{ $image->getUrl() }}"
                                            class="img-fluid rounded shadow-sm"
                                            style="width:100%; height:200px; object-fit:cover;"
                                            alt="{{ $image->name }}">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Brochures & Downloads --}}
                @php
                    $brochures = $service->getMedia('service_brochures');
                @endphp
                @if ($brochures->count() > 0)
                    <section class="page-section mb-4">
                        <h4 class="mb-3"><i class="fas fa-file-download me-2"></i> Brochures & Downloads</h4>
                        <div class="row g-3">
                            @foreach ($brochures as $file)
                                @php
                                    $ext = pathinfo($file->file_name, PATHINFO_EXTENSION);
                                    $icon = match(strtolower($ext)) {
                                        'pdf' => 'fa-file-pdf text-danger',
                                        'doc', 'docx' => 'fa-file-word text-primary',
                                        'xls', 'xlsx' => 'fa-file-excel text-success',
                                        'ppt', 'pptx' => 'fa-file-powerpoint text-warning',
                                        default => 'fa-file-alt text-secondary',
                                    };
                                @endphp
                                <div class="col-md-6">
                                    <a href="{{ $file->getUrl() }}" target="_blank" class="text-decoration-none">
                                        <div class="d-flex align-items-center border rounded p-3 bg-white shadow-sm h-100">
                                            <i class="fas {{ $icon }} fa-2x me-3"></i>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <span class="d-block fw-bold text-dark text-truncate">{{ $file->name }}</span>
                                                <small class="text-muted">{{ strtoupper($ext) }} &middot; {{ round($file->size / 1024) }} KB</small>
                                            </div>
                                            <i class="fas fa-download ms-2 text-muted"></i>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Related Services --}}
                @if ($otherServices->count() > 0)
                    <section class="page-section pt-4">
                        <h4 class="mb-3">Other Services</h4>
                        <div class="row g-3">
                            @foreach ($otherServices->take(3) as $related)
                                <div class="col-md-4">
                                    <article class="news-card h-100">
                                        <div class="news-card-body d-flex flex-column">
                                            <span class="news-badge" style="position: static; align-self: flex-start; margin-bottom: 14px;">
                                                Ministry Service
                                            </span>
                                            <h5 class="news-title">{{ $related->title }}</h5>
                                            <p class="news-description mb-3">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($related->description ?? ''), 100) }}
                                            </p>
                                            <a href="{{ route('services.details', $related->id) }}" class="btn btn-outline-theme btn-sm mt-auto">
                                                View Details
                                            </a>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- Contact CTA --}}
                <section class="page-section pt-4">
                    <div class="news-empty-state text-center">
                        <h4>Need More Information?</h4>
                        <p>Reach out to us and we'll guide you to the right service for you.</p>
                        <a href="{{ route('site.home') }}#contact" class="btn btn-outline-theme mt-2">
                            Contact Us
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
