<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Our Services</h2>
            <p class="lead mb-0">{{ $title ?? 'Explore our ministry services.' }}</p>
        </section>

        <section class="page-section mb-4">
            <div class="row g-4">
                @forelse ($services as $service)
                    <div class="col-lg-4 col-md-6">
                        <article class="news-card h-100">
                            <div class="news-card-body d-flex flex-column">
                                <span class="news-badge" style="position: static; align-self: flex-start; margin-bottom: 14px;">
                                    Ministry Service
                                </span>

                                <h4 class="news-title">{{ $service->title ?? 'Service' }}</h4>

                                <p class="news-description mb-0">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($service->description ?? ''), 220) }}
                                </p>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="news-empty-state">
                            <div class="empty-icon"><i class="fas fa-hands-helping"></i></div>
                            <h4>No Services Available</h4>
                            <p>Services content has not been published yet.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <section class="page-section pt-4">
            <div class="news-empty-state text-center">
                <h4>Need More Information?</h4>
                <p>Reach out to us and we’ll guide you to the right service for you.</p>
                <a href="{{ route('site.home') }}#contact" class="btn btn-outline-theme mt-2">
                    Contact Us
                </a>
            </div>
        </section>
    </div>
</div>
