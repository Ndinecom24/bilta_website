<div>

    <style>
        .news-item-info {
    text-align: left; /* Ensures the text is aligned to the left */
    font-style: normal; /* Removes any italic styling */
}

.news-item-info h4 {
    margin: 0 0 5px 0; /* Adds spacing below the title */
    font-weight: bold; /* Ensures the title is bold */
}

.news-item-info span {
    display: block; /* Ensures the span takes up its own line */
    margin-bottom: 10px; /* Adds spacing below the metadata */
    font-size: 14px; /* Adjusts font size for readability */
    color: #555; /* Optional: Subtle color for metadata */
}

.news-item-info .news-details {
    font-size: 16px; /* Adjusts font size for the details */
    line-height: 1.5; /* Improves readability with line spacing */
}

    </style>


    <section id="news" class="news section-bg">
        <div class="container">

            <div class="section-title">
                <h2 data-aos="fade-up">News Details</h2>
                <span data-aos="fade-up">{{ $title ?? '-' }}</span>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-3 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="card card-body">
                        <h4>News Categories</h4>
                        @foreach ($categories as $item)
                            <ul>
                                <li><a href="{{ route('news', $item->category->id ?? '0') }}">
                                        {{ $item->category->name ?? '-' }} ( {{ $item->total ?? '-' }}
                                        )
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-9 col-md-9 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="news-item">
                
                        <div class="news-item-img">
                            @php
                                $image = $news->getFirstMedia('news_images') 
                                        ? $news->getFirstMedia('news_images')->getUrl() 
                                        : 'https://via.placeholder.com/300x200?text=News+Image';
                            @endphp
                            <img 
                                loading="lazy" 
                                src="{{ $image }}" 
                                title="{{ $news->getFirstMedia('news_images')->name ?? 'Placeholder Image' }}" 
                                alt="{{ $news->getFirstMedia('news_images')->name ?? 'Placeholder Image' }}"
                                class="img-fluid" 
                                style="width: 100%; height: auto; object-fit: cover; border-radius: 5px;">
                        </div>
                
                        <div class="news-item-info">
                            <h4>{{ $news->title ?? '-' }}</h4>
                            <span>Post Date: {{ $news->post_date ?? '-' }} | Author: {{ $news->author ?? '-' }}</span>
                            <div class="news-details1">{!! $news->details ?? '' !!}</div>
                        </div>
                        
                    </div>
                </div>
                

                <div class="col-lg-3 col-md-3"> </div>

                <div class="col-lg-9 col-md-9 d-flex align-items-stretch  " data-aos="fade-up">
                    <div class="row  portfolio    ">
                        @foreach ($news->getMedia('news_images') as $gallery_item)
                            <div
                                class="col-lg-4 col-md-6 portfolio-item filter-{{ $gallery_item->item_category_id ?? '' }}">
                                <img   loading="lazy"  src="{{ $gallery_item->getUrl() }}" width="100%" class="img-fluid"
                                    alt="">
                                <div class=" portfolio-info">
                                    <h4>{{ $gallery_item->name }}</h4>
                                    <p>{{ $gallery_item->description ?? '-' }} </p>
                                    <a href="{{ $gallery_item->getUrl() }}" data-gallery="portfolioGallery"
                                        class="portfolio-lightbox preview-link"
                                        title="{{ $gallery_item->name }} <br> {{ $gallery_item->description }}"><i
                                            class="bx bx-plus"></i></a>
                                    {{--               <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>



            </div>

        </div>


</div>
</section>



</div>
