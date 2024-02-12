<div>
    {{-- Because she competes with no one, no one can compete with her. --}}


    <section id="projects" class="projects section-bg">
        <div class="container">

            <div class="section-title">
                <h2 data-aos="fade-up">Project Details</h2>
                <span data-aos="fade-up">{{ $title ?? '-' }}</span>
            </div>

            <div class="row">

                <div class="col-lg-3 col-md-3 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="card card-body">
                        <h4>Projects Categories</h4>
                        @foreach ($categories as $item)
                            <ul>
                                <li><a href="{{ route('projects', $item->myCategory->id ?? '0') }}">
                                        {{ $item->myCategory->name ?? '-' }} ( {{ $item->total ?? '-' }}
                                        )
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>


                <div class="col-lg-9 col-md-9 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="projects-item">

                        <div class="projects-item-img">
                            @if ($project->getFirstMedia('project_title_images') != null)
                                <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}"
                                    title="{{ $project->getFirstMedia('project_title_images')->name }}"
                                    class="img-fluid" alt="">
                            @endif
                        </div>

                        <div class="projects-item-info">
                            <h4>{{ $project->title ?? '-' }}</h4>
                            <span> Post Date : {{ $project->post_date ?? '-' }} | Author :
                                {{ $project->author ?? '-' }} </span>
                            <p> {{ $project->short_description ?? '-' }}</p>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 text-right mt-lg-4"> <h3 class="card card-boy p-2" >Project Images</h3>  </div>

                <div class="col-lg-9 col-md-9 d-flex align-items-stretch  " data-aos="fade-up">

                    <div class="row  portfolio    ">
                        @foreach ($project->getMedia('project_images') as $gallery_item)
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



                <div class="col-lg-3 col-md-3 text-right mt-lg-4 "> <h3 class="card card-boy p-2">Project Files </h3>  </div>

                <div class="col-lg-9 col-md-9 d-flex align-items-stretch  " data-aos="fade-up">

                    <div class="row  portfolio    ">
                        @foreach ($project->getMedia('project_files') as $project_file)
                            <div
                                class="col-lg-4 col-md-6 portfolio-item filter-{{ $project_file->item_category_id ?? '' }}">
                                <img src="{{ $project_file->getUrl() }}" width="100%" class="img-fluid"
                                    alt="">
                                <div class=" portfolio-info">
                                    <h4>{{ $project_file->name }}</h4>
                                    <p>{{ $project_file->description ?? '-' }} </p>
                                    <a href="{{ $project_file->getUrl() }}" data-gallery="portfolioGallery"
                                        class="portfolio-lightbox preview-link"
                                        title="{{ $project_file->name }} <br> {{ $project_file->description }}"><i
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
