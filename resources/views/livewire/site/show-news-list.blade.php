<div>

    <style>
        .news-item-img img.news-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
    

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
                            @foreach ($categories as $item1)
                                <ul>
                                    <li><a href="{{ route('news', $item1->category->id ?? '0') }}">
                                            {{ $item1->category->name  ?? '-' }} ( {{ $item1->total ?? '-' }}
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
                                            @php
                                                $image = $item->getFirstMedia('news_images') 
                                                        ? $item->getFirstMedia('news_images')->getUrl() 
                                                        : 'https://via.placeholder.com/300x200?text=News+Image';
                                            @endphp
                                            <img 
                                                loading="lazy" 
                                                src="{{ $image }}" 
                                                title="{{ $item->getFirstMedia('news_images')->name ?? 'Placeholder Image' }}" 
                                                class="img-fluid news-image" 
                                                alt="{{ $item->getFirstMedia('news_images')->name ?? 'Placeholder Image' }}">
                                        </div>
                                        
                                        <div class="news-item-info">
                                            <h4>{{ $item->title ?? '-' }}</h4>
                                            <span> Post Date : {{ $item->post_date ?? '-' }} | Author :
                                                {{ $item->author ?? '-' }} </span>
                                            <p> {{ Str::limit($item->short_description, 200, '...') ?? '-' }}</p>
                    
                                            <div class="news-item-btn">
                                                <a href="{{ route('news.details',['news' =>$item, 'name'=>$item->title] ) }}"
                                                    class="btn btn-sm btn-outline-secondary">More..</a>
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
