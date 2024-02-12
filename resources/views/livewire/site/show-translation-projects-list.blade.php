<div>

    <body>

        <section id="projects" class="projects section-bg">
            <div class="container">

                <div class="section-title">
                    <h2 data-aos="fade-up">Projects</h2>
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

                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <div class="row">
                            @foreach ($projects as $item)
                                <div class="col-lg-6 col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                                    <div class="projects-item">
                                        <div class="projects-item-img">
                                            @if ($item->getFirstMedia('project_title_images') != null)
                                                <img src="{{ $item->getFirstMedia('project_title_images')->getUrl() }}"
                                                    title="{{ $item->getFirstMedia('project_title_images')->name }}"
                                                    class="img-fluid" alt="">
                                            @endif
                                        </div>
                                        <div class="projects-item-info">
                                            <h4>{{ $item->title ?? '-' }}</h4>
                                            <span> Post Date : {{ $item->post_date ?? '-' }} | Author :
                                                {{ $item->author ?? '-' }} </span>
                                            <p> {{ $item->short_description ?? '-' }}</p>
                                            <div class="projects-item-btn">
                                                <a href="{{ route('projects.details', $item) }}"
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
<!-- End Projects Section -->


</body>

</div>
