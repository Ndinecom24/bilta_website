<div>
    <style>
        .section-header {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d2d2d;
            border-bottom: 2px solid #eee;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
        }

        .card-light {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .project-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 0.5rem;
        }

        .project-meta {
            font-size: 0.9rem;
            color: #888;
            margin-bottom: 1rem;
        }

        .project-details {
            color: #555;
            line-height: 1.7;
        }

        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
        }

        .media-item {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.06);
            background-color: #fafafa;
            transition: transform 0.2s ease;
        }

        .media-item:hover {
            transform: scale(1.02);
        }

        .media-item img,
        .media-item iframe {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .media-info {
            padding: 0.75rem 1rem;
        }

        .media-info h4 {
            margin: 0 0 0.25rem;
            font-size: 1rem;
            font-weight: 600;
            color: #222;
        }

        .media-info p {
            font-size: 0.875rem;
            color: #666;
        }

        .preview-link,
        .btn-outline-primary {
            margin-top: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.875rem;
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            background-color: transparent;
            border: 1px solid #007bff;
            color: #007bff;
            text-decoration: none;
            transition: all 0.2s;
        }

        .preview-link:hover,
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }
    </style>

    <section class="section-bg py-5">
        <div class="container">
            <div class="section-header">Project Details</div>

            <div class="row">
                <!-- Categories -->

                <aside class="col-lg-3 mb-4" data-aos="fade-up">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Filter by Category</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($categories as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ route('projects', $item->myCategory->id ?? '0') }}"
                                            class="text-decoration-none">
                                            {{ $item->myCategory->name ?? '-' }}
                                        </a>
                                        <span class="badge bg-primary rounded-pill">{{ $item->total ?? '-' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </aside>

                <!-- Main Details -->
                <div class="col-lg-9">
                    <div class="card-light">
                        @if ($project->getFirstMedia('project_title_images'))
                            <img src="{{ $project->getFirstMedia('project_title_images')->getUrl() }}"
                                class="img-fluid rounded mb-3" loading="lazy">
                        @endif
                        <h2 class="project-title">{{ $project->title ?? '-' }}</h2>
                        <div class="project-meta">
                            Post Date: {{ $project->post_date ?? '-' }} | Author: {{ $project->author ?? '-' }}
                        </div>
                        <div class="project-details">{!! $project->details ?? '' !!}</div>
                    </div>

                    <!-- Project Images -->
                    @if ($project->getMedia('project_images')->count())
                        <div class="section-header mt-5">Project Images</div>
                        <div class="media-grid">
                            <div class="row">
                                @foreach ($project->getMedia('project_images') as $gallery_item)
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
                    @endif

                    <!-- Project Files -->
                    @if ($project->getMedia('project_files')->count())
                        <div class="section-header mt-5">Project Files</div>
                        <div class="media-grid">
                            <div class="row">
                            @foreach ($project->getMedia('project_files') as $project_file)
                            <div class="col-lg-6 col-sm-12">
                                <div class="media-item">
                                    @if ($project_file->mime_type === 'application/pdf' || $project_file->getExtensionAttribute() === 'pdf')
                                        <iframe src="{{ $project_file->getUrl() }}" frameborder="0"></iframe>
                                    @else
                                        <img src="{{ $project_file->getUrl() }}" alt="{{ $project_file->name }}"
                                            loading="lazy">
                                    @endif
                                    <div class="media-info">
                                        <h4>{{ $project_file->name }}</h4>
                                        <p>{{ $project_file->description ?? '' }}</p>
                                        <a href="{{ $project_file->getUrl() }}" class="btn-outline-primary"
                                            target="_blank">Open File</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
