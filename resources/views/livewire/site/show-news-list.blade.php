<div>

    <style>
        .news-image-wrapper {
            height: 200px;
            overflow: hidden;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .news-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .news-image-wrapper:hover .news-image {
            transform: scale(1.05);
        }

        .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }
    </style>


    <body>

        <section id="news" class="py-5 bg-light">
            <div class="container">
                <div class="section-title text-center mb-5">
                    <h2 data-aos="fade-up" class="fw-bold">News</h2>
                    <p data-aos="fade-up" class="text-muted">{{ $title ?? '-' }}</p>
                </div>

                <div class="row">
                    <!-- Categories Sidebar -->
                    <div class="col-lg-3 mb-4">
                        <div class="bg-white p-4 shadow-sm rounded">
                            <h5 class="mb-3 fw-semibold">News Categories</h5>
                            <ul class="list-unstyled">
                                @foreach ($categories as $item1)
                                    <li class="mb-2">
                                        <a href="{{ route('news', $item1->category->id ?? '0') }}"
                                            class="text-decoration-none text-dark d-flex justify-content-between align-items-center">
                                            {{ $item1->category->name ?? '-' }}
                                            <span
                                                class="badge bg-primary rounded-pill">{{ $item1->total ?? '-' }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- News List -->
                    <div class="col-lg-9">
                        <div class="row g-4">
                            @foreach ($news as $item)
                                @php
                                    $image = $item->getFirstMedia('news_images')
                                        ? $item->getFirstMedia('news_images')->getUrl()
                                        : 'https://via.placeholder.com/300x200?text=News+Image';
                                @endphp

                                <div class="col-md-6">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="news-image-wrapper">
                                            <img src="{{ $image }}" class="card-img-top news-image"
                                                alt="{{ $item->title ?? 'News Image' }}"
                                                title="{{ $item->getFirstMedia('news_images')->name ?? 'Image' }}"
                                                loading="lazy">
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fw-semibold">{{ $item->title ?? '-' }}</h5>
                                            <small class="text-muted mb-2">
                                                Posted: {{ $item->post_date ?? '-' }} | Author:
                                                {{ $item->author ?? '-' }}
                                            </small>
                                            <p class="card-text text-muted flex-grow-1">
                                                {{ Str::limit($item->short_description, 200, '...') ?? '-' }}
                                            </p>
                                            <a href="{{ route('news.details', ['news' => $item, 'name' => $item->title]) }}"
                                                class="btn btn-sm btn-outline-primary mt-auto">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- End News Section -->


    </body>

</div>
