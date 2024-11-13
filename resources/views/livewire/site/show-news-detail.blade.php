<div>



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
                                <li><a href="{{ route('news', $item->myCategory->id ?? '0') }}">
                                        {{ $item->myCategory->name ?? '-' }} ( {{ $item->total ?? '-' }}
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
                            @if ($news->getFirstMedia('news_images') != null)
                                <img src="{{ $news->getFirstMedia('news_images')->getUrl() }}"
                                    title="{{ $news->getFirstMedia('news_images')->name }}" class="img-fluid"
                                    alt="">
                            @endif
                        </div>

                        <div class="news-item-info">
                            <h4>{{ $news->title ?? '-' }}</h4>
                            <span> Post Date : {{ $news->post_date ?? '-' }} | Author :
                                {{ $news->author ?? '-' }} </span>
                                 {!! $news->details ?? '' !!}

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3"> </div>

                <div class="col-lg-9 col-md-9 d-flex align-items-stretch  " data-aos="fade-up">
                    <div class="row  portfolio    ">
                        @foreach ($news->getMedia('news_images') as $gallery_item)
                            <div
                                class="col-lg-4 col-md-6 portfolio-item filter-{{ $gallery_item->item_category_id ?? '' }}">
                                <img src="{{ $gallery_item->getUrl() }}" width="100%" class="img-fluid"
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
