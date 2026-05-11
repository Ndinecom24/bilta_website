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
        color: #c9853d;
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
        border-color: #c9853d;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(201, 133, 61, 0.08);
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
        background: linear-gradient(135deg, #c9853d, #aa6d2e);
        color: #fff;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 10px 24px rgba(201, 133, 61, 0.22);
    }

    .gallery-reset-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 28px rgba(201, 133, 61, 0.32);
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
        background: linear-gradient(135deg, #c9853d, #a96a2b);
        border-color: transparent;
        color: #fff;
        box-shadow: 0 10px 24px rgba(201, 133, 61, 0.24);
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
        color: #c9853d;
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

<!-- JavaScript for Search and Count -->
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
            updateGalleryCount();
        });

        updateGalleryCount();
    });
</script>
