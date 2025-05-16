<div>
    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="portfolio py-5">
        <div class="container">
            <!-- Section Header -->
            <div class="section-title text-center mb-4">
                <h2 data-aos="fade-up">Gallery</h2>
                <p data-aos="fade-up">
                    Embark on a visual journey showcasing our incredible work in translating and promoting Bible and literary texts across cultures.
                </p>
            </div>

            <!-- Search and Actions -->
            <div class="row mb-4 justify-content-center">
                <div class="col-md-5">
                    <input type="text" id="gallerySearch" class="form-control" placeholder="Search images...">
                </div>
                <div class="col-md-3 mt-2 mt-md-0 text-md-start text-center">
                    <button id="showAllGalleryBtn" class="btn btn-outline-secondary">Show All</button>
                    <span id="galleryResultsCount" class="ms-2 text-muted">Showing {{ count($gallery_items) }} results</span>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="row justify-content-center mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 text-center">
                    <ul id="portfolio-flters" class="list-inline">
                        <li class="list-inline-item filter-active" data-filter="*">All</li>
                        @foreach ($categories as $category)
                            <li class="list-inline-item" data-filter=".filter-{{ $category->id }}">{{ $category->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="row portfolio-container" id="galleryContainer">
                @foreach ($gallery_items as $gallery_item)
                    @php
                        $categoryId = $gallery_item->item_category_id;
                        $name = $gallery_item->name;
                        $desc = $gallery_item->description ?? '';
                        $imageUrl = $gallery_item->getFirstMedia('gallery_images')->getUrl();
                    @endphp

                    <div class="col-lg-4 col-md-6 mb-4 portfolio-item filter-{{ $categoryId }}"
                         data-title="{{ strtolower($name) }}"
                         data-description="{{ strtolower($desc) }}">
                        <div class="card border-0 shadow-sm h-100 d-flex flex-column">
                            <img loading="lazy" src="{{ $imageUrl }}" class="card-img-top img-fluid" alt="{{ $name }}" style="object-fit: cover; height: 250px;">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="card-title mb-1">{{ $name }}</h6>
                                    <p class="card-text text-muted small mb-2">{{ $desc }}</p>
                                </div>
                                <a href="{{ $imageUrl }}" data-gallery="portfolioGallery"
                                   class="portfolio-lightbox btn btn-sm btn-outline-primary"
                                   title="{{ $name }} - {{ $desc }}">
                                    View Full Image
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
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
