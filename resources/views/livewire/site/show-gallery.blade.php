<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Gallery</h2>
            <p class="lead mb-0">A visual archive of translation work, community events, and milestone moments.</p>
        </section>

     <section class="modern-gallery-section">

    {{-- Header --}}
    <div class="gallery-topbar">

        <div>
            <span class="gallery-mini-title">
                Media Collection
            </span>

            <h2 class="gallery-main-title">
                Photo Gallery
            </h2>
        </div>

        <div class="gallery-stats">
            <div class="gallery-stat-card">
                <strong>{{ count($gallery_items) }}</strong>
                <span>Total Images</span>
            </div>
        </div>

    </div>

    {{-- Search + Actions --}}
    <div class="gallery-toolbar">

        <div class="gallery-search-box">
            <i class="fas fa-search"></i>

            <input type="text"
                id="gallerySearch"
                class="gallery-search-input"
                placeholder="Search gallery images...">
        </div>

        <div class="gallery-toolbar-actions">
            <button id="showAllGalleryBtn"
                class="gallery-reset-btn">

                <i class="fas fa-sync-alt me-2"></i>
                Show All
            </button>

            <div class="gallery-results-count"
                id="galleryResultsCount">

                Showing {{ count($gallery_items) }} results
            </div>
        </div>

    </div>

    {{-- Filters --}}
    <div class="gallery-filter-wrapper">
        <ul id="portfolio-flters" class="gallery-filter-list">

            <li class="filter-active"
                data-filter="*">

                All Images
            </li>

            @foreach ($categories as $category)
                @if ($category)
                    <li data-filter=".filter-{{ $category->id }}">
                        {{ $category->name }}
                    </li>
                @endif
            @endforeach

        </ul>
    </div>

    {{-- Gallery Grid --}}
    <div class="row g-4 portfolio-container"
        id="galleryContainer">

        @foreach ($gallery_items as $gallery_item)

            @php
                $categoryId = $gallery_item->item_category_id;
                $name = $gallery_item->name;
                $desc = $gallery_item->description ?? '';
                $imageUrl = $gallery_item->getFirstMedia('gallery_images')
                    ? $gallery_item->getFirstMedia('gallery_images')->getUrl()
                    : null;
            @endphp

            <div class="col-lg-4 col-md-6 portfolio-item filter-{{ $categoryId }}"
                data-title="{{ strtolower($name) }}"
                data-description="{{ strtolower($desc) }}">

                <div class="modern-gallery-card h-100">

                    <div class="gallery-image-box">

                        <img loading="lazy"
                            src="{{ $imageUrl ?? asset('assets/img/placeholder.png') }}"
                            alt="{{ $name }}">

                        <div class="gallery-image-overlay">

                            @if ($imageUrl)
                                <a href="{{ $imageUrl }}"
                                    data-gallery="portfolioGallery"
                                    class="gallery-preview-btn portfolio-lightbox"
                                    title="{{ $name }} - {{ $desc }}">

                                    <i class="fas fa-expand-alt"></i>
                                </a>
                            @endif

                        </div>

                    </div>

                    <div class="gallery-content">

                        <h5 class="gallery-item-title">
                            {{ $name }}
                        </h5>

                        <p class="gallery-item-description">
                            {{ Str::limit($desc, 90, '...') }}
                        </p>

                        @if ($imageUrl)
                            <a href="{{ $imageUrl }}"
                                data-gallery="portfolioGallery"
                                class="gallery-view-link portfolio-lightbox"
                                title="{{ $name }} - {{ $desc }}">

                                View Full Image
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</section>

<style>
    .modern-gallery-section {
        position: relative;
    }

    /* Top Area */

    .gallery-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }

    .gallery-mini-title {
        display: inline-block;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #cd5b13;
        margin-bottom: 8px;
    }

    .gallery-main-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #2d1c10;
        margin: 0;
    }

    .gallery-stat-card {
        background: linear-gradient(135deg, #f7ead9, #f4dfc5);
        border-radius: 22px;
        padding: 18px 24px;
        min-width: 150px;
        text-align: center;
        box-shadow: 0 10px 24px rgba(44, 22, 8, 0.06);
    }

    .gallery-stat-card strong {
        display: block;
        font-size: 1.7rem;
        color: #9f6528;
        line-height: 1;
        margin-bottom: 6px;
    }

    .gallery-stat-card span {
        font-size: 0.88rem;
        color: #7b6859;
        font-weight: 600;
    }

    /* Toolbar */

    .gallery-toolbar {
        background: #fff;
        border-radius: 24px;
        padding: 20px;
        border: 1px solid #f1e3d4;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-bottom: 30px;
        box-shadow: 0 12px 30px rgba(44, 22, 8, 0.05);
    }

    .gallery-search-box {
        flex: 1;
        min-width: 260px;
        position: relative;
    }

    .gallery-search-box i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #b98447;
    }

    .gallery-search-input {
        width: 100%;
        height: 56px;
        border-radius: 18px;
        border: 1px solid #ead8c3;
        background: #fcfaf8;
        padding: 0 20px 0 50px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .gallery-search-input:focus {
        outline: none;
        border-color: #cd5b13;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(205, 91, 19, 0.10);
    }

    .gallery-toolbar-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .gallery-reset-btn {
        height: 52px;
        padding: 0 22px;
        border: none;
        border-radius: 16px;
        background: #cd5b13;
        color: #fff;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(205, 91, 19, 0.22);
    }

    .gallery-reset-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(205, 91, 19, 0.28);
    }

    .gallery-results-count {
        font-size: 0.9rem;
        color: #7a6d62;
        font-weight: 600;
    }

    /* Filters */

    .gallery-filter-wrapper {
        margin-bottom: 32px;
    }

    .gallery-filter-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .gallery-filter-list li {
        padding: 12px 22px;
        border-radius: 50px;
        background: #fff;
        border: 1px solid #eadac8;
        color: #705f51;
        font-size: 0.92rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .gallery-filter-list li:hover,
    .gallery-filter-list li.filter-active {
        background: #cd5b13;
        border-color: transparent;
        color: #fff;
        box-shadow: 0 4px 12px rgba(205, 91, 19, 0.22);
    }

    /* Cards */

    .modern-gallery-card {
        background: #fff;
        border-radius: 26px;
        overflow: hidden;
        border: 1px solid #f0e2d2;
        transition: all 0.35s ease;
        box-shadow: 0 12px 30px rgba(44, 22, 8, 0.06);
    }

    .modern-gallery-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(44, 22, 8, 0.14);
    }

    .gallery-image-box {
        position: relative;
        overflow: hidden;
        height: 280px;
    }

    .gallery-image-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .modern-gallery-card:hover .gallery-image-box img {
        transform: scale(1.08);
    }

    .gallery-image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.58),
                rgba(0, 0, 0, 0.08));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.35s ease;
    }

    .modern-gallery-card:hover .gallery-image-overlay {
        opacity: 1;
    }

    .gallery-preview-btn {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.94);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a56b2f;
        font-size: 1.25rem;
        text-decoration: none;
        transform: scale(0.8);
        transition: all 0.3s ease;
    }

    .modern-gallery-card:hover .gallery-preview-btn {
        transform: scale(1);
    }

    .gallery-preview-btn:hover {
        background: #fff;
        color: #cd5b13;
    }

    .gallery-content {
        padding: 24px;
    }

    .gallery-item-title {
        font-size: 1.08rem;
        font-weight: 700;
        color: #2e1c10;
        margin-bottom: 12px;
    }

    .gallery-item-description {
        color: #76695e;
        line-height: 1.7;
        font-size: 0.92rem;
        margin-bottom: 20px;
    }

    .gallery-view-link {
        display: inline-flex;
        align-items: center;
        color: #b37433;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .gallery-view-link:hover {
        color: #8d5720;
    }

    @media (max-width: 768px) {
        .gallery-main-title {
            font-size: 1.7rem;
        }

        .gallery-toolbar {
            padding: 16px;
        }

        .gallery-image-box {
            height: 240px;
        }

        .gallery-content {
            padding: 20px;
        }
    }
</style>
    </div>
</div>

<!-- Lightbox Modal -->
<div id="galleryLightbox" class="gallery-lightbox" style="display:none;">
    <div class="lightbox-backdrop"></div>
    <button class="lightbox-close" title="Close">Close</button>
    <button class="lightbox-nav lightbox-prev" title="Previous">Prev</button>
    <button class="lightbox-nav lightbox-next" title="Next">Next</button>
    <div class="lightbox-content">
        <img id="lightboxImage" src="" alt="">
        <div class="lightbox-caption" id="lightboxCaption"></div>
        <div class="lightbox-counter" id="lightboxCounter"></div>
    </div>
</div>

<style>
    .gallery-lightbox {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-backdrop {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.92);
        backdrop-filter: blur(8px);
    }

    .lightbox-close {
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

    .lightbox-close:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    .lightbox-nav {
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

    .lightbox-nav:hover {
        background: rgba(205, 91, 19, 0.7);
        transform: translateY(-50%) scale(1.05);
    }

    .lightbox-prev { left: 20px; }
    .lightbox-next { right: 20px; }

    .lightbox-content {
        position: relative;
        z-index: 5;
        max-width: 90vw;
        max-height: 85vh;
        text-align: center;
    }

    .lightbox-content img {
        max-width: 100%;
        max-height: 78vh;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        object-fit: contain;
        animation: lightboxFadeIn 0.3s ease;
    }

    @keyframes lightboxFadeIn {
        from { opacity: 0; transform: scale(0.95); }
        to { opacity: 1; transform: scale(1); }
    }

    .lightbox-caption {
        color: #e2e8f0;
        font-size: 0.95rem;
        font-weight: 600;
        margin-top: 14px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .lightbox-counter {
        color: #94a3b8;
        font-size: 0.82rem;
        margin-top: 6px;
    }

    @media (max-width: 768px) {
        .lightbox-nav {
            padding: 10px 16px;
            font-size: 0.82rem;
        }
        .lightbox-prev { left: 10px; }
        .lightbox-next { right: 10px; }
        .lightbox-close { top: 12px; right: 12px; padding: 8px 16px; font-size: 0.82rem; }
    }
</style>

<!-- JavaScript for Search, Filters, and Lightbox -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("gallerySearch");
        const showAllBtn = document.getElementById("showAllGalleryBtn");
        const resultsCount = document.getElementById("galleryResultsCount");
        const items = document.querySelectorAll("#galleryContainer .portfolio-item");

        function updateGalleryCount() {
            const visibleCount = [...items].filter(item => item.style.display !== "none").length;
            resultsCount.textContent = `Showing ${visibleCount} result${visibleCount !== 1 ? 's' : ''}`;
        }

        searchInput.addEventListener("input", function () {
            const term = this.value.toLowerCase();
            items.forEach(item => {
                const title = item.dataset.title;
                const description = item.dataset.description;
                if (title.includes(term) || description.includes(term)) {
                    item.style.display = "";
                } else {
                    item.style.display = "none";
                }
            });
            updateGalleryCount();
        });

        showAllBtn.addEventListener("click", function () {
            searchInput.value = "";
            items.forEach(item => item.style.display = "");
            // Reset active filter to "All"
            document.querySelectorAll("#portfolio-flters li").forEach(f => f.classList.remove("filter-active"));
            document.querySelector('#portfolio-flters li[data-filter="*"]').classList.add("filter-active");
            updateGalleryCount();
        });

        // Category filter clicks
        document.querySelectorAll("#portfolio-flters li").forEach(function (filterBtn) {
            filterBtn.addEventListener("click", function () {
                const filterValue = this.getAttribute("data-filter");

                // Update active state
                document.querySelectorAll("#portfolio-flters li").forEach(f => f.classList.remove("filter-active"));
                this.classList.add("filter-active");

                // Clear search
                searchInput.value = "";

                // Filter items
                items.forEach(function (item) {
                    if (filterValue === "*") {
                        item.style.display = "";
                    } else {
                        // filterValue is like ".filter-3", item has class "filter-3"
                        const filterClass = filterValue.replace(".", "");
                        if (item.classList.contains(filterClass)) {
                            item.style.display = "";
                        } else {
                            item.style.display = "none";
                        }
                    }
                });

                updateGalleryCount();
            });
        });

        updateGalleryCount();

        // ===== LIGHTBOX =====
        const lightbox = document.getElementById('galleryLightbox');
        const lightboxImg = document.getElementById('lightboxImage');
        const lightboxCaption = document.getElementById('lightboxCaption');
        const lightboxCounter = document.getElementById('lightboxCounter');
        let lightboxImages = [];
        let currentIndex = 0;

        function collectVisibleImages() {
            lightboxImages = [];
            document.querySelectorAll('#galleryContainer .portfolio-item').forEach(function(item) {
                if (item.style.display !== 'none') {
                    const link = item.querySelector('.portfolio-lightbox');
                    if (link) {
                        lightboxImages.push({
                            src: link.getAttribute('href'),
                            title: link.getAttribute('title') || ''
                        });
                    }
                }
            });
        }

        function openLightbox(index) {
            collectVisibleImages();
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

        function showLightboxImage() {
            const img = lightboxImages[currentIndex];
            lightboxImg.src = img.src;
            lightboxImg.alt = img.title;
            lightboxCaption.textContent = img.title;
            lightboxCounter.textContent = (currentIndex + 1) + ' / ' + lightboxImages.length;
            // Re-trigger animation
            lightboxImg.style.animation = 'none';
            lightboxImg.offsetHeight;
            lightboxImg.style.animation = '';
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
        document.querySelectorAll('#galleryContainer .portfolio-lightbox').forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                collectVisibleImages();
                const clickedSrc = this.getAttribute('href');
                currentIndex = lightboxImages.findIndex(function(img) { return img.src === clickedSrc; });
                if (currentIndex < 0) currentIndex = 0;
                showLightboxImage();
                lightbox.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        // Controls
        document.querySelector('.lightbox-close').addEventListener('click', closeLightbox);
        document.querySelector('.lightbox-backdrop').addEventListener('click', closeLightbox);
        document.querySelector('.lightbox-next').addEventListener('click', nextImage);
        document.querySelector('.lightbox-prev').addEventListener('click', prevImage);

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            if (lightbox.style.display === 'none') return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
        });
    });
</script>
