<div>

    <style>
 .news-item {
    font-family: 'Arial', sans-serif;
    color: #333;
    line-height: 1.6;
}

.news-item-info {
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 8px;
}

.news-item-info h4 {
    font-size: 24px;
    font-weight: bold;
    color: #2d2d2d;
}

.news-item-info span {
    font-size: 14px;
    color: #777;
}

.news-details {
    margin-top: 10px;
    font-size: 16px;
    color: #555;
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
                    <div class="news-item" style="font-family: 'Arial', sans-serif; color: #333; line-height: 1.6;">
                
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
                
                        <div class="news-item-info" style="padding: 15px; background-color: #f9f9f9; border-radius: 8px;">
                            <h4 style="font-size: 24px; font-weight: bold; color: #2d2d2d;">{{ $news->title ?? '-' }}</h4>
                            <span style="font-size: 14px; color: #777;">Post Date: {{ $news->post_date ?? '-' }} | Author: {{ $news->author ?? '-' }}</span>
                            <div class="news-details" style="margin-top: 10px; font-size: 16px; color: #555;">{!! $news->details ?? '' !!}</div>
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
