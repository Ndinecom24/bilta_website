<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Translation Projects</h2>
            <p class="lead mb-0">{{ $title ?? 'Browse active and completed work across language communities.' }}</p>
        </section>

        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="modern-sidebar">

                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>

                        <div>
                            <h5 class="sidebar-title mb-1">Project Categories</h5>
                            <p class="sidebar-subtitle mb-0">
                                Browse projects by category
                            </p>
                        </div>
                    </div>

                    <div class="category-list">
                        @foreach ($categories as $item)
                            @php
                                $categoryId = $item->myCategory->id ?? null;
                                $categoryName = $item->myCategory->name ?? null;
                            @endphp

                            @if ($categoryId && $categoryName)
                                <a href="{{ route('projects', $categoryId) }}" class="category-item">
                                    <div class="category-content">
                                        <div class="category-dot"></div>

                                        <span class="category-name">
                                            {{ $categoryName }}
                                        </span>
                                    </div>

                                    <span class="category-count">
                                        {{ $item->total ?? '0' }}
                                    </span>
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
            </aside>

            <div class="col-lg-9">
                <section class="news-section">
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                        <div>
                            <h4 class="mb-1">Featured Projects</h4>
                            <p class="text-muted mb-0 small">Active and completed translation work across communities.</p>
                        </div>
                        <span class="site-pill mt-2 mt-sm-0">{{ $projects->total() ?? count($projects) }} Items</span>
                    </div>

                    <div class="row g-4">
                        @forelse ($projects as $item)
                            @php
                                $image = $item->getFirstMedia('project_title_images')
                                    ? $item->getFirstMedia('project_title_images')->getUrl()
                                    : 'https://images.unsplash.com/photo-1550859492-d5da9d8e45f3?w=600&q=80';

                                $postedDate = !empty($item->post_date)
                                    ? \Illuminate\Support\Carbon::parse($item->post_date)->format('d M Y')
                                    : '-';
                            @endphp

                            <div class="col-md-6 col-xl-4">
                                <article class="news-card h-100">
                                    <div class="news-card-image">
                                        <img src="{{ $image }}"
                                            alt="{{ $item->title ?? 'Project image' }}"
                                            loading="lazy">

                                        <div class="news-overlay"></div>

                                        <span class="news-badge">
                                            Translation Project
                                        </span>
                                    </div>

                                    <div class="news-card-body d-flex flex-column">
                                        <div class="news-meta">
                                            <span>
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $postedDate }}
                                            </span>

                                            <span>
                                                <i class="fas fa-user"></i>
                                                {{ $item->author ?? 'Admin' }}
                                            </span>
                                        </div>

                                        <h4 class="news-title">
                                            {{ $item->title ?? 'Untitled' }}
                                        </h4>

                                        <p class="news-description">
                                            {{ Str::limit($item->short_description, 140, '...') ?? '-' }}
                                        </p>

                                        <div class="mt-auto">
                                            <a href="{{ route('projects.details', $item) }}" class="news-btn">
                                                View Project
                                                <i class="fas fa-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="news-empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-project-diagram"></i>
                                    </div>

                                    <h4>No Projects Available</h4>
                                    <p>There are currently no projects to display.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">{{ $projects->links() }}</div>
                </section>
            </div>
        </div>
    </div>
</div>
