<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}

    <div>
        <!-- ======= Portfolio Section ======= -->
        <section id="Gallery" class="portfolio">
            <div class="container">
                <div class="section-title">
                    <h2 data-aos="fade-up">Gallery</h2>
                    <p data-aos="fade-up"> We invite you to embark on a visual journey showcasing our
                        organization's incredible <br> work in translating and promoting Bible and literary texts across
                        different cultures

                    <div class="row" data-aos="fade-up" data-aos-delay="100">
                        <div class="col-lg-12 col-sm-12  d-flex justify-content-center">
                            <ul id="portfolio-flters">
                                <li data-filter="*" class="filter-active">All</li>
                                @foreach ($categories as $category)
                                    <li data-filter=".filter-{{ $category->id ?? '' }}">{{ $category->name ?? '' }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="row portfolio portfolio-container ">
                        @foreach ($gallery_items as $gallery_item)
                            <div
                                class="col-lg-4 col-md-6 portfolio-item filter-{{ $gallery_item->item_category_id ?? '' }}">
                                <img src="{{ $gallery_item->getFirstMedia('gallery_images')->getUrl() }}" width="100%"
                                    class="img-fluid" alt="">
                                <div class="portfolio-info">
                                    <h4>{{ $gallery_item->name }}</h4>
                                    <p>{{ $gallery_item->description ?? '-' }} </p>
                                    <a href="{{ $gallery_item->getFirstMedia('gallery_images')->getUrl() }}"
                                        data-gallery="portfolioGallery" class="portfolio-lightbox preview-link"
                                        title="{{ $gallery_item->name }} <br> {{ $gallery_item->description }}"><i
                                            class="bx bx-plus"></i></a>
                                    {{--               <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a> --}}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </section><!-- End Portfolio Section -->

    </div>


</div>
