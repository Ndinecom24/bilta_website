<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">News & Updates</h2>
            <p class="lead mb-0">{{ $title ?? 'Read latest stories, announcements, and milestones from BiLTA.' }}</p>
        </section>

        <div class="row g-4">
         <aside class="col-lg-3">
    <div class="modern-sidebar">

        <div class="sidebar-header">
            <div class="sidebar-icon">
                <i class="fas fa-layer-group"></i>
            </div>

            <div>
                <h5 class="sidebar-title mb-1">News Categories</h5>
                <p class="sidebar-subtitle mb-0">
                    Browse articles by category
                </p>
            </div>
        </div>

        <div class="category-list">
            @foreach ($categories as $item1)
                <a href="{{ route('news', $item1->category->id ?? '0') }}"
                    class="category-item">

                    <div class="category-content">
                        <div class="category-dot"></div>

                        <span class="category-name">
                            {{ $item1->category->name ?? '-' }}
                        </span>
                    </div>

                    <span class="category-count">
                        {{ $item1->total ?? '0' }}
                    </span>
                </a>
            @endforeach
        </div>

    </div>
</aside>

          <div class="col-lg-9">
    <section class="news-section">
        <div class="row g-4">
            @forelse ($news as $item)
                @php
                    $image = $item->getFirstMedia('news_images')
                        ? $item->getFirstMedia('news_images')->getUrl()
                        : 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=600&q=80';
                @endphp

                <div class="col-md-6 col-xl-4">
                    <article class="news-card h-100">
                        <div class="news-card-image">
                            <img src="{{ $image }}"
                                alt="{{ $item->title ?? 'News Image' }}"
                                loading="lazy">

                            <div class="news-overlay"></div>

                            <span class="news-badge">
                                News Update
                            </span>
                        </div>

                        <div class="news-card-body d-flex flex-column">
                            <div class="news-meta">
                                <span>
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($item->post_date)->format('d M Y') }}
                                </span>

                                <span>
                                    <i class="fas fa-user"></i>
                                    {{ $item->author ?? 'Admin' }}
                                </span>
                            </div>

                            <h4 class="news-title">
                                {{ $item->title ?? '-' }}
                            </h4>

                            <p class="news-description">
                                {{ Str::limit($item->short_description, 140, '...') ?? '-' }}
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('news.details', ['news' => $item, 'name' => $item->title]) }}"
                                    class="news-btn">
                                    Read Full Story
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
                            <i class="fas fa-newspaper"></i>
                        </div>

                        <h4>No News Available</h4>
                        <p>There are currently no news items to display.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>
</div>


            
        </div>
    </div>
</div>
