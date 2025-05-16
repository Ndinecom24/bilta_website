<section id="projects" class="projects section-bg py-5">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 data-aos="fade-up">Our Projects</h2>
            <p data-aos="fade-up">{{ $title ?? 'Browse our latest work and initiatives.' }}</p>
        </div>

        <div class="row">
            <!-- Sidebar: Categories -->
            <aside class="col-lg-3 mb-4" data-aos="fade-up">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Filter by Category</h5>
                        <ul class="list-group list-group-flush">
                            @foreach ($categories as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('projects', $item->myCategory->id ?? '0') }}" class="text-decoration-none">
                                        {{ $item->myCategory->name ?? '-' }}
                                    </a>
                                    <span class="badge bg-primary rounded-pill">{{ $item->total ?? '-' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Main Content: Projects -->
            <div class="col-lg-9">
                <div class="row g-4">
                    @forelse ($projects as $item)
                        <div class="col-md-6" data-aos="fade-up">
                            <div class="card h-100 shadow-sm border-0">
                                @if ($item->getFirstMedia('project_title_images'))
                                    <img 
                                        src="{{ $item->getFirstMedia('project_title_images')->getUrl() }}"
                                        alt="{{ $item->getFirstMedia('project_title_images')->name }}"
                                        class="card-img-top"
                                        style="height: 220px; object-fit: cover;"
                                        loading="lazy"
                                    >
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $item->title ?? 'Untitled' }}</h5>
                                    <div class="mb-2 text-muted small">
                                        <i class="bi bi-calendar3"></i> {{ $item->post_date ?? '-' }} &nbsp;
                                        <i class="bi bi-person-circle"></i> {{ $item->author ?? '-' }}
                                    </div>
                                    <p class="card-text small">{{ $item->short_description ?? '-' }}</p>
                                    <p class="card-text text-truncate small">{{ Str::limit($item->details, 150, '...') }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('projects.details', $item) }}" class="btn btn-sm btn-outline-primary">Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                No projects available at the moment.
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination (if needed) --}}
                <div class="mt-4">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
