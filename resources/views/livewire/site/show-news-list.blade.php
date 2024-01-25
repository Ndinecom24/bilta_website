<div>

    <body>

        <section id="news" class="news section-bg">
            <div class="container">

                <div class="section-title">
                    <h2 data-aos="fade-up">News</h2>
                     <span data-aos="fade-up">{{ $title ?? "-" }}</span>
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

                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="row">
                            @foreach ($news as $item)
                                <div class="col-lg-6 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                                    <div class="news-item">

                                        <div class="news-item-img">
                                            @if ($item->getFirstMedia('news_images') != null)
                                                <img src="{{ $item->getFirstMedia('news_images')->getUrl() }}"
                                                    title="{{ $item->getFirstMedia('news_images')->name }}"
                                                    class="img-fluid" alt="">
                                            @endif
                                        </div>

                                        <div class="news-item-info">
                                            <h4>{{ $item->title ?? '-' }}</h4>
                                            <span> Post Date : {{ $item->post_date ?? '-' }} | Author :
                                                {{ $item->author ?? '-' }} </span>
                                            <p> {{ $item->short_description ?? '-' }}</p>

                                            <div class="news-item-btn">
                                                <a href="{{ route('news.details', $item) }}"
                                                    class=" btn btn-sm btn-outline-secondary">More..</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
</div>

</section>
<!-- End News Section -->


</body>

</div>
