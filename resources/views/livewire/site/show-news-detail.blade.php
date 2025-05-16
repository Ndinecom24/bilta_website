<div>
    <style>
        .news-item-info {
            text-align: left;
            font-style: normal;
        }

        .news-item-info h4 {
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .news-item-info span {
            display: block;
            margin-bottom: 10px;
            font-size: 14px;
            color: #555;
        }

        .news-item-info .news-details {
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            margin-bottom: 15px;
            font-style: normal;
        }

        .news-item-info .news-details p,
        .news-item-info .news-details ul {
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            margin-bottom: 15px;
            font-style: normal;
        }

        /* Media Grid styling */
        .media-grid .media-item {
            background: #f9f9f9;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 10px;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        .media-grid img {
            width: 100%;
            height: 250px;     /* fixed height to unify size */
            border-radius: 2px;
            object-fit: cover;
        }

        .section-header {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d2d2d;
            border-bottom: 2px solid #eee;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
        }
        

        .media-info {
            margin-top: 10px;
        }

        .media-info h4 {
            font-size: 18px;
            font-weight: 600;
            color: #2d2d2d;
        }

        .media-info p {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
        }

        .btn-outline-primary {
            font-size: 14px;
            padding: 5px 10px;
        }
    </style>

    <section id="news" class="news section-bg">
        <div class="container">

            <div class="section-title">
                <h2 data-aos="fade-up">News Details</h2>
                <span data-aos="fade-up">{{ $title ?? '-' }}</span>
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
                                        <span class="badge bg-primary rounded-pill">{{ $item1->total ?? '-' }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9 col-md-9 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="news-item" style="font-family: 'Arial', sans-serif; color: #333; line-height: 1.6;">
                        <div class="news-item-img">
                            @php
                                $image = $news->getFirstMedia('news_images')
                                    ? $news->getFirstMedia('news_images')->getUrl()
                                    : 'https://via.placeholder.com/300x200?text=News+Image';
                            @endphp
                            <img loading="lazy" src="{{ $image }}"
                                title="{{ $news->getFirstMedia('news_images')->name ?? 'Placeholder Image' }}"
                                alt="{{ $news->getFirstMedia('news_images')->name ?? 'Placeholder Image' }}"
                                class="img-fluid"
                                style="width: 100%; height: auto; object-fit: cover; border-radius: 5px;">
                        </div>

                        <div class="news-item-info"
                            style="padding: 15px; background-color: #f9f9f9; border-radius: 8px;">
                            <h4 style="font-size: 24px; font-weight: bold; color: #2d2d2d;">{{ $news->title ?? '-' }}
                            </h4>
                            <span style="font-size: 14px; color: #777;">Post Date: {{ $news->post_date ?? '-' }} |
                                Author:
                                {{ $news->author ?? '-' }}</span>
                            <div class="news-details" style="margin-top: 10px; font-size: 16px; color: #555;">
                                {!! $news->details ?? '' !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 ">
                </div>

                <div class="col-lg-9 col-md-9 d-flex align-items-stretch" data-aos="fade-up">
                <!-- Images Section following your provided pattern -->
                @if ($news->getMedia('news_images')->count())
                    <div class="col-lg-12 mt-5" data-aos="fade-up">
                        <div class="section-header">News Images</div>
                        <div class="media-grid">
                            <div class="row">
                                @foreach ($news->getMedia('news_images') as $gallery_item)
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="media-item">
                                            <img src="{{ $gallery_item->getUrl() }}" alt="{{ $gallery_item->name }}"
                                                loading="lazy">
                                            <div class="media-info">
                                                <h4>{{ $gallery_item->name }}</h4>
                                                <p>{{ $gallery_item->description ?? '' }}</p>
                                                <a href="{{ $gallery_item->getUrl() }}"
                                                    class="btn btn-sm btn-outline-primary portfolio-lightbox"
                                                    data-gallery="portfolioGallery" title="{{ $gallery_item->name }}">
                                                    <i class="bx bx-plus"></i> View Image
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                
            </div>

            </div>
        </div>
    </section>
</div>
