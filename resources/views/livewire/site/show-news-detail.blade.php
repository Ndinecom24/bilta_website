<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">News Details</h2>
            <p class="lead mb-0">{{ $title ?? 'Explore the full story and related media.' }}</p>
        </section>

        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="modern-sidebar">

                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <i class="fas fa-layer-group"></i>
                        </div>

                        <div>
                            <h5 class="sidebar-title mb-1">News Categories</h5>
                            <p class="sidebar-subtitle mb-0">
                                Browse articles by category
                            </p>
                        </div>
                    </div>

                    <div class="category-list">
                        @foreach ($categories as $item1)
                            @php
                                $categoryId = $item1->category->id ?? null;
                                $categoryName = $item1->category->name ?? null;
                            @endphp

                            @if ($categoryId && $categoryName)
                                <a href="{{ route('news', $categoryId) }}" class="category-item">
                                    <div class="category-content">
                                        <div class="category-dot"></div>

                                        <span class="category-name">
                                            {{ $categoryName }}
                                        </span>
                                    </div>

                                    <span class="category-count">
                                        {{ $item1->total ?? '0' }}
                                    </span>
                                </a>
                            @endif
                        @endforeach
                    </div>

                </div>
            </aside>

          <div class="col-lg-9">

    {{-- Main News Article --}}
    <section class="modern-news-detail mb-5">

        @php
            $image = $news->getFirstMedia('news_images')
                ? $news->getFirstMedia('news_images')->getUrl()
                : asset('assets/img/placeholder.png');
        @endphp

        <div class="news-hero-image">
            <img loading="lazy"
                src="{{ $image }}"
                alt="{{ $news->title ?? 'News image' }}">

            <div class="hero-overlay"></div>

            <div class="hero-badge">
                <i class="fas fa-newspaper me-2"></i>
                Latest Update
            </div>
        </div>

        <div class="news-detail-body">

            <div class="news-meta-row">
                <div class="meta-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $news->post_date ?? '-' }}</span>
                </div>

                <div class="meta-divider"></div>

                <div class="meta-item">
                    <i class="fas fa-user-edit"></i>
                    <span>{{ $news->author ?? 'Admin' }}</span>
                </div>
            </div>

            <h1 class="news-detail-title">
                {{ $news->title ?? '-' }}
            </h1>

            <div class="news-content-wrapper">
                {!! $news->details ?? '' !!}
            </div>

        </div>
    </section>

    {{-- Gallery Section --}}
    @if ($news->getMedia('news_images')->count())
        <section class="modern-gallery-section">

            <div class="gallery-header">
                <div>
                    <span class="gallery-label">Media Gallery</span>
                    <h3 class="gallery-title">More Images</h3>
                </div>

                <div class="gallery-count">
                    {{ $news->getMedia('news_images')->count() }} Photos
                </div>
            </div>

            <div class="row g-4">

                @foreach ($news->getMedia('news_images') as $gallery_item)
                    <div class="col-md-6 col-xl-4">

                        <div class="gallery-card h-100">

                            <div class="gallery-image-wrapper">
                                <img src="{{ $gallery_item->getUrl() }}"
                                    alt="{{ $gallery_item->name }}"
                                    loading="lazy">

                                <div class="gallery-overlay">
                                    <a href="{{ $gallery_item->getUrl() }}"
                                        class="gallery-view-btn portfolio-lightbox"
                                        data-gallery="portfolioGallery"
                                        title="{{ $gallery_item->name }}">

                                        <i class="fas fa-expand"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="gallery-card-body">
                                <h6 class="gallery-image-title">
                                    {{ $gallery_item->name }}
                                </h6>

                                @if ($gallery_item->description)
                                    <p class="gallery-image-description">
                                        {{ $gallery_item->description }}
                                    </p>
                                @endif
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </section>
    @endif

</div>

<style>
    .modern-news-detail {
        background: #fff;
        border-radius: 30px;
        overflow: hidden;
        border: 1px solid #f1e4d7;
        box-shadow: 0 18px 45px rgba(44, 22, 8, 0.08);
    }

    .news-hero-image {
        position: relative;
        height: 480px;
        overflow: hidden;
    }

    .news-hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.72),
                rgba(0, 0, 0, 0.08));
    }

    .hero-badge {
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

    .news-detail-body {
        padding: 40px;
    }

    .news-meta-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #7c6f65;
        font-size: 0.92rem;
        font-weight: 500;
    }

    .meta-item i {
        color: #c33205;
    }

    .meta-divider {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #d5b18a;
    }

    .news-detail-title {
        font-size: 2.3rem;
        font-weight: 800;
        line-height: 1.35;
        color: #2d1c10;
        margin-bottom: 30px;
    }

    .news-content-wrapper {
        color: #54463c;
        font-size: 1rem;
        line-height: 1.95;
    }

    .news-content-wrapper p {
        margin-bottom: 1.4rem;
    }

    .news-content-wrapper h1,
    .news-content-wrapper h2,
    .news-content-wrapper h3,
    .news-content-wrapper h4,
    .news-content-wrapper h5 {
        color: #2f1d10;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .news-content-wrapper img {
        max-width: 100%;
        border-radius: 18px;
        margin: 20px 0;
    }

    /* Gallery */

    .modern-gallery-section {
        margin-top: 20px;
    }

    .gallery-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .gallery-label {
        display: inline-block;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #c33205;
        margin-bottom: 8px;
    }

    .gallery-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #2e1c10;
        margin: 0;
    }

    .gallery-count {
        background: linear-gradient(135deg, #f7eadb, #f4dfc8);
        color: #9c6327;
        padding: 12px 18px;
        border-radius: 16px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .gallery-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #f0e4d7;
        transition: all 0.35s ease;
        box-shadow: 0 10px 28px rgba(44, 22, 8, 0.06);
    }

    .gallery-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(44, 22, 8, 0.12);
    }

    .gallery-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 250px;
    }

    .gallery-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .gallery-card:hover .gallery-image-wrapper img {
        transform: scale(1.08);
    }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.42);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.35s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-view-btn {
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

    .gallery-card:hover .gallery-view-btn {
        transform: scale(1);
    }

    .gallery-view-btn:hover {
        background: #fff;
        color: #c33205;
    }

    .gallery-card-body {
        padding: 22px;
    }

    .gallery-image-title {
        font-size: 1rem;
        font-weight: 700;
        color: #2e1d11;
        margin-bottom: 10px;
    }

    .gallery-image-description {
        font-size: 0.9rem;
        line-height: 1.7;
        color: #7a6b60;
        margin: 0;
    }

    @media (max-width: 768px) {
        .news-hero-image {
            height: 300px;
        }

        .news-detail-body {
            padding: 28px 22px;
        }

        .news-detail-title {
            font-size: 1.7rem;
        }

        .gallery-title {
            font-size: 1.45rem;
        }
    }
</style>

<!-- Lightbox Modal -->
<div id="newsLightbox" class="news-lightbox" style="display:none;">
    <div class="news-lightbox-backdrop"></div>
    <button class="news-lightbox-close" title="Close">Close</button>
    <button class="news-lightbox-nav news-lightbox-prev" title="Previous">Prev</button>
    <button class="news-lightbox-nav news-lightbox-next" title="Next">Next</button>
    <div class="news-lightbox-content">
        <img id="newsLightboxImage" src="" alt="">
        <div class="news-lightbox-caption" id="newsLightboxCaption"></div>
        <div class="news-lightbox-counter" id="newsLightboxCounter"></div>
    </div>
</div>

<style>
    .news-lightbox {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .news-lightbox-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.92);
        backdrop-filter: blur(8px);
    }

    .news-lightbox-close {
        position: absolute;
        top: 20px;
        right: 24px;
        z-index: 10;
        padding: 10px 20px;
        border: none;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .news-lightbox-close:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    .news-lightbox-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        padding: 12px 22px;
        border: none;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .news-lightbox-nav:hover {
        background: rgba(205, 91, 19, 0.7);
        transform: translateY(-50%) scale(1.05);
    }

    .news-lightbox-prev { left: 20px; }
    .news-lightbox-next { right: 20px; }

    .news-lightbox-content {
        position: relative;
        z-index: 5;
        max-width: 90vw;
        max-height: 85vh;
        text-align: center;
    }

    .news-lightbox-content img {
        max-width: 100%;
        max-height: 78vh;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        object-fit: contain;
        animation: newsLightboxFadeIn 0.3s ease;
    }

    @keyframes newsLightboxFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .news-lightbox-caption {
        color: #e2e8f0;
        font-size: 0.95rem;
        font-weight: 600;
        margin-top: 14px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .news-lightbox-counter {
        color: #94a3b8;
        font-size: 0.82rem;
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .news-lightbox-nav {
            padding: 10px 16px;
            font-size: 0.82rem;
        }
        .news-lightbox-prev { left: 10px; }
        .news-lightbox-next { right: 10px; }
        .news-lightbox-close { top: 12px; right: 12px; padding: 8px 16px; font-size: 0.82rem; }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const lightbox = document.getElementById('newsLightbox');
        const lightboxImg = document.getElementById('newsLightboxImage');
        const lightboxCaption = document.getElementById('newsLightboxCaption');
        const lightboxCounter = document.getElementById('newsLightboxCounter');
        let lightboxImages = [];
        let currentIndex = 0;

        function collectImages() {
            lightboxImages = [];
            document.querySelectorAll('.modern-gallery-section .portfolio-lightbox').forEach(function(link) {
                lightboxImages.push({
                    src: link.getAttribute('href'),
                    title: link.getAttribute('title') || ''
                });
            });
        }

        function showLightboxImage() {
            const img = lightboxImages[currentIndex];
            lightboxImg.src = img.src;
            lightboxImg.alt = img.title;
            lightboxCaption.textContent = img.title;
            lightboxCounter.textContent = (currentIndex + 1) + ' / ' + lightboxImages.length;
            lightboxImg.style.animation = 'none';
            lightboxImg.offsetHeight;
            lightboxImg.style.animation = '';
        }

        function openLightbox(index) {
            collectImages();
            if (lightboxImages.length === 0) return;
            currentIndex = index;
            showLightboxImage();
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.style.display = 'none';
            document.body.style.overflow = '';
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % lightboxImages.length;
            showLightboxImage();
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + lightboxImages.length) % lightboxImages.length;
            showLightboxImage();
        }

        // Attach click to all lightbox links
        document.querySelectorAll('.modern-gallery-section .portfolio-lightbox').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                collectImages();
                const clickedSrc = this.getAttribute('href');
                currentIndex = lightboxImages.findIndex(function(img) { return img.src === clickedSrc; });
                if (currentIndex < 0) currentIndex = 0;
                showLightboxImage();
                lightbox.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        // Controls
        document.querySelector('.news-lightbox-close').addEventListener('click', closeLightbox);
        document.querySelector('.news-lightbox-backdrop').addEventListener('click', closeLightbox);
        document.querySelector('.news-lightbox-next').addEventListener('click', nextImage);
        document.querySelector('.news-lightbox-prev').addEventListener('click', prevImage);

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (lightbox.style.display === 'none') return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });
    });
</script>

        </div>
    </div>
</div>
