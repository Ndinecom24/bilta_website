<div>
    <style>
        .section-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1rem;
            position: relative;
            padding-bottom: 10px;
            /* Add padding to make space for the line */
        }

        .section-header::after {
            content: '';
            display: block;
            width: calc(100% - 10%);
            /* Width of the line, leaving 200px space on the right */
            height: 1px;
            background-color: rgba(71, 50, 12, 0.133);
            /* Color of the line */
            position: absolute;
            bottom: 0;
            left: 0;
        }

        /* Title */
.project-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.5em;
    font-weight: bold;
    color: #333;
}

/* Meta information */
.project-meta {
    font-family: 'Source Sans Pro', sans-serif;
    color: gray;
    font-size: 0.9em;
}

/* Short Description */
.project-short-description {
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 600;
    font-size: 1.1em;
    color: #333;
}

/* Details */
.project-details {
    font-family: 'Source Sans Pro', sans-serif;
    font-size: 1em;
    color: #555;
}

    </style>
    <section id="projects" class="projects section-bg">
        <div class="container">

            <!-- Project Details -->
            <div class="section-title">
                <h2 data-aos="fade-up">Project Details</h2>
                <span data-aos="fade-up">{{ $title ?? '' }}</span>
            </div>

            <div class="row">

                <!-- Project Categories -->
                <div class="col-lg-3 col-md-3 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="card card-body">
                        <h4>Projects Categories</h4>
                        @foreach ($categories as $item)
                            <ul>
                                <li><a href="{{ route('projects', $item->myCategory->id ?? '0') }}">
                                        {{ $item->myCategory->name ?? '-' }} ( {{ $item->total ?? '-' }} )
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>

                <!-- Project Main Details -->
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
                            <h4 class="project-title">{{ $project->title ?? '-' }}</h4>
                            <span class="project-meta"> Post Date : {{ $project->post_date ?? '-' }} | Author :
                                {{ $project->author ?? '-' }} </span>
                            <p class="project-short-description"> {{ $project->short_description ?? '-' }}</p>
                            <div class="project-details"> {{ $project->details ?? '' }}</div>
                        </div>
                        
                    </div>
                </div>

                <!-- Project Images Header -->

                <div class="col-lg-12 offset-lg-3 mt-lg-4">
                    <h3 class="text-right section-header">Project Images</h3>
                </div>

                <!-- Project Images -->
                <div class="col-lg-9 offset-lg-3 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="row portfolio">
                        @foreach ($project->getMedia('project_images') as $gallery_item)
                            <div
                                class="col-lg-4 col-md-6 portfolio-item filter-{{ $gallery_item->item_category_id ?? '' }}">
                                <img src="{{ $gallery_item->getUrl() }}" width="100%" class="img-fluid"
                                    alt="">
                                <div class="portfolio-info">
                                    <h4>{{ $gallery_item->name }}</h4>
                                    <p>{{ $gallery_item->description ?? '-' }}</p>
                                    <a href="{{ $gallery_item->getUrl() }}" data-gallery="portfolioGallery"
                                        class="portfolio-lightbox preview-link"
                                        title="{{ $gallery_item->name }} <br> {{ $gallery_item->description }}">
                                        <i class="bx bx-plus"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Project Files Header -->
                <div class="col-lg-12 offset-lg-3 mt-lg-4">
                    <h3 class="text-right section-header">Project Files</h3>
                </div>

                <!-- Project Files -->
                <div class="col-lg-9 offset-lg-3 d-flex align-items-stretch" data-aos="fade-up">
                    <div class="row portfolio">
                        @foreach ($project->getMedia('project_files') as $project_file)
                            <div
                                class="col-lg-4 col-md-6 portfolio-item filter-{{ $project_file->item_category_id ?? '' }}">
                                @if ($project_file->mime_type === 'application/pdf' || $project_file->getExtensionAttribute() === 'pdf')
                                    <iframe src="{{ $project_file->getUrl() }}" height="300px"
                                        frameborder="0"></iframe>
                                    <div class="portfolio-info">
                                        <h4>{{ $project_file->name }}</h4>
                                        <p>{{ $project_file->description ?? '-' }}</p>
                                        <a href="{{ $project_file->getUrl() }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            Open File
                                            <i class="bx bx-right-arrow-alt"></i> <!-- Arrow icon -->
                                        </a>
                                    </div>
                                @else
                                    <img src="{{ $project_file->getUrl() }}" width="100%" class="img-fluid"
                                        alt="">
                                    <div class="portfolio-info">
                                        <h4>{{ $project_file->name }}</h4>
                                        <p>{{ $project_file->description ?? '-' }}</p>
                                        <a href="{{ $project_file->getUrl() }}" data-gallery="portfolioGallery"
                                            class="portfolio-lightbox preview-link"
                                            title="{{ $project_file->name }} <br> {{ $project_file->description }}">
                                            <i class="bx bx-plus"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </section>
</div>
