<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Project Details</h2>
            <p class="lead mb-0">Explore project outcomes, visuals, and supporting documents.</p>
        </section>

        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="modern-sidebar">

                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>

                        <div>
                            <h5 class="sidebar-title mb-1">Project Categories</h5>
                            <p class="sidebar-subtitle mb-0">
                                Browse projects by category
                            </p>
                        </div>
                    </div>

                    <div class="category-list">
                        @foreach ($categories as $item)
                            @php
                                $categoryId = $item->myCategory->id ?? null;
                                $categoryName = $item->myCategory->name ?? null;
                            @endphp

                            @if ($categoryId && $categoryName)
                                <a href="{{ route('projects', $categoryId) }}" class="category-item">
                                    <div class="category-content">
                                        <div class="category-dot"></div>

                                        <span class="category-name">
                                            {{ $categoryName }}
                                        </span>
                                    </div>

                                    <span class="category-count">
                                        {{ $item->total ?? '0' }}
                                    </span>
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
            </aside>

            <div class="col-lg-9">
                <section class="modern-project-detail mb-5">

                    @php
                        $heroImage = $project->getFirstMedia('project_title_images')
                            ? $project->getFirstMedia('project_title_images')->getUrl()
                            : asset('assets/img/placeholder.png');

                        $postedDate = !empty($project->post_date)
                            ? \Illuminate\Support\Carbon::parse($project->post_date)->format('d M Y')
                            : '-';
                    @endphp

                    <div class="project-hero-image">
                        <img loading="lazy"
                            src="{{ $heroImage }}"
                            alt="{{ $project->title ?? 'Project image' }}">

                        <div class="project-hero-overlay"></div>

                        <div class="project-hero-badge">
                            <i class="fas fa-project-diagram me-2"></i>
                            Translation Project
                        </div>
                    </div>

                    <div class="project-detail-body">
                        <div class="project-meta-row">
                            <div class="project-meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ $postedDate }}</span>
                            </div>

                            <div class="project-meta-divider"></div>

                            <div class="project-meta-item">
                                <i class="fas fa-user-edit"></i>
                                <span>{{ $project->author ?? 'Admin' }}</span>
                            </div>
                        </div>

                        <h1 class="project-detail-title">
                            {{ $project->title ?? '-' }}
                        </h1>

                        <div class="project-content-wrapper">
                            {!! $project->details ?? '' !!}
                        </div>
                    </div>
                </section>

                @if ($project->getMedia('project_images')->count())
                    <section class="modern-project-gallery-section mb-4">
                        <div class="project-gallery-header">
                            <div>
                                <span class="project-gallery-label">Media Gallery</span>
                                <h3 class="project-gallery-title">Project Images</h3>
                            </div>

                            <div class="project-gallery-count">
                                {{ $project->getMedia('project_images')->count() }} Photos
                            </div>
                        </div>

                        <div class="row g-4">
                            @foreach ($project->getMedia('project_images') as $gallery_item)
                                <div class="col-md-6 col-xl-4">
                                    <div class="project-gallery-card h-100">
                                        <div class="project-gallery-image-wrapper">
                                            <img src="{{ $gallery_item->getUrl() }}"
                                                alt="{{ $gallery_item->name }}"
                                                loading="lazy">

                                            <div class="project-gallery-overlay">
                                                <a href="{{ $gallery_item->getUrl() }}"
                                                    class="project-gallery-view-btn portfolio-lightbox"
                                                    data-gallery="portfolioGallery"
                                                    title="{{ $gallery_item->name }}">
                                                    <i class="fas fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="project-gallery-card-body">
                                            <h6 class="project-gallery-image-title">{{ $gallery_item->name }}</h6>

                                            @if ($gallery_item->description)
                                                <p class="project-gallery-image-description">{{ $gallery_item->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if ($project->getMedia('project_files')->count())
                    <section class="modern-project-files-section">
                        <div class="project-gallery-header">
                            <div>
                                <span class="project-gallery-label">Attachments</span>
                                <h3 class="project-gallery-title">Project Files</h3>
                            </div>

                            <div class="project-gallery-count">
                                {{ $project->getMedia('project_files')->count() }} Files
                            </div>
                        </div>

                        <div class="row g-4">
                            @foreach ($project->getMedia('project_files') as $project_file)
                                <div class="col-md-6">
                                    <div class="project-file-card h-100">
                                        @if ($project_file->mime_type === 'application/pdf' || $project_file->getExtensionAttribute() === 'pdf')
                                            <iframe src="{{ $project_file->getUrl() }}" style="width:100%; height:220px; border:0; border-radius: 16px 16px 0 0;"></iframe>
                                        @else
                                            <img src="{{ $project_file->getUrl() }}"
                                                alt="{{ $project_file->name }}"
                                                class="site-media-thumb"
                                                loading="lazy">
                                        @endif

                                        <div class="project-file-card-body">
                                            <h6 class="project-gallery-image-title">{{ $project_file->name }}</h6>
                                            <p class="project-gallery-image-description">{{ $project_file->description ?? '' }}</p>
                                            <a href="{{ $project_file->getUrl() }}" class="project-file-btn" target="_blank">Open File</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .modern-project-detail {
        background: #fff;
        border-radius: 30px;
        overflow: hidden;
        border: 1px solid #f1e4d7;
        box-shadow: 0 18px 45px rgba(44, 22, 8, 0.08);
    }

    .project-hero-image {
        position: relative;
        height: 460px;
        overflow: hidden;
    }

    .project-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .project-hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.72), rgba(0, 0, 0, 0.08));
    }

    .project-hero-badge {
        position: absolute;
        top: 28px;
        left: 28px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        color: #fff;
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .project-detail-body {
        padding: 40px;
    }

    .project-meta-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .project-meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #7c6f65;
        font-size: 0.92rem;
        font-weight: 500;
    }

    .project-meta-item i {
        color: #c9853d;
    }

    .project-meta-divider {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #d5b18a;
    }

    .project-detail-title {
        font-size: 2.3rem;
        font-weight: 800;
        line-height: 1.35;
        color: #2d1c10;
        margin-bottom: 30px;
    }

    .project-content-wrapper {
        color: #54463c;
        font-size: 1rem;
        line-height: 1.95;
    }

    .project-content-wrapper p {
        margin-bottom: 1.4rem;
    }

    .project-content-wrapper h1,
    .project-content-wrapper h2,
    .project-content-wrapper h3,
    .project-content-wrapper h4,
    .project-content-wrapper h5 {
        color: #2f1d10;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .project-content-wrapper img {
        max-width: 100%;
        border-radius: 18px;
        margin: 20px 0;
    }

    .project-gallery-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .project-gallery-label {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #c9853d;
        margin-bottom: 8px;
    }

    .project-gallery-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #2e1c10;
        margin: 0;
    }

    .project-gallery-count {
        background: linear-gradient(135deg, #f7eadb, #f4dfc8);
        color: #9c6327;
        padding: 12px 18px;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .project-gallery-card,
    .project-file-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #f0e4d7;
        transition: all 0.35s ease;
        box-shadow: 0 10px 28px rgba(44, 22, 8, 0.06);
    }

    .project-gallery-card:hover,
    .project-file-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(44, 22, 8, 0.12);
    }

    .project-gallery-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .project-gallery-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .project-gallery-card:hover .project-gallery-image-wrapper img {
        transform: scale(1.08);
    }

    .project-gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.42);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.35s ease;
    }

    .project-gallery-card:hover .project-gallery-overlay {
        opacity: 1;
    }

    .project-gallery-view-btn {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.92);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9f6629;
        font-size: 1.2rem;
        text-decoration: none;
        transform: scale(0.8);
        transition: all 0.3s ease;
    }

    .project-gallery-card:hover .project-gallery-view-btn {
        transform: scale(1);
    }

    .project-gallery-view-btn:hover {
        background: #fff;
        color: #c9853d;
    }

    .project-gallery-card-body,
    .project-file-card-body {
        padding: 22px;
    }

    .project-gallery-image-title {
        font-size: 1rem;
        font-weight: 700;
        color: #2e1d11;
        margin-bottom: 10px;
    }

    .project-gallery-image-description {
        font-size: 0.9rem;
        line-height: 1.7;
        color: #7a6b60;
        margin: 0;
    }

    .project-file-btn {
        display: inline-block;
        margin-top: 12px;
        background: #fff7ed;
        color: #9c6327;
        border: 1px solid #f3d8bd;
        border-radius: 12px;
        padding: 8px 14px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
    }

    .project-file-btn:hover {
        background: #fbe9d6;
        color: #8b551f;
    }

    @media (max-width: 768px) {
        .project-hero-image {
            height: 300px;
        }

        .project-detail-body {
            padding: 28px 22px;
        }

        .project-detail-title {
            font-size: 1.7rem;
        }

        .project-gallery-title {
            font-size: 1.45rem;
        }
    }
</style>
