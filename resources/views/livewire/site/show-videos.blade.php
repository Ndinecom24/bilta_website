<div>
    <!-- ======= Videos Section ======= -->
    <section id="videos" class="videos py-5">
        <div class="container">
            <!-- Section Header -->
            <div class="section-title text-center mb-5">
                <h2 data-aos="fade-up">Videos</h2>
                <p data-aos="fade-up">
                    Dive into a captivating collection of videos that showcase our organization's commitment to the
                    translation and dissemination of literary works, including the Bible, across diverse languages and cultures.
                </p>
            </div>

            <!-- Search & Control Row -->
            <div class="row mb-4 justify-content-center">
                <div class="col-md-6">
                    <input type="text" id="videoSearch" class="form-control" placeholder="Search videos...">
                </div>
                <div class="col-md-3 mt-2 mt-md-0 text-md-start text-center">
                    <button id="showAllBtn" class="btn btn-outline-secondary">Show All</button>
                    <span id="resultsCount" class="ms-2 text-muted">Showing {{ count($video_items) }} results</span>
                </div>
            </div>

            <!-- Video Grid -->
            <div class="row" id="videoContainer">
                @foreach ($video_items as $video)
                    @php
                        preg_match("/(?:youtube\.com\/(?:[^\/]+\/.+|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/", $video->video_link, $matches);
                        $videoId = $matches[1] ?? null;
                    @endphp

                    @if ($videoId)
                        <div class="col-lg-6 col-md-12 mb-4 video-card"
                             data-title="{{ strtolower($video->name) }}"
                             data-description="{{ strtolower($video->description) }}">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $videoId }}"
                                        title="{{ $video->name }}"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $video->name }}</h5>
                                    <p class="card-text text-muted">{{ $video->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
</div>

<!-- JS: Search, Count, Reset -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("videoSearch");
        const showAllBtn = document.getElementById("showAllBtn");
        const resultsCount = document.getElementById("resultsCount");
        const cards = document.querySelectorAll(".video-card");

        function updateResultsCount() {
            const visibleCount = [...cards].filter(card => card.style.display !== "none").length;
            resultsCount.textContent = `Showing ${visibleCount} result${visibleCount !== 1 ? 's' : ''}`;
        }

        searchInput.addEventListener("keyup", function () {
            const searchValue = this.value.toLowerCase();
            cards.forEach(card => {
                const title = card.dataset.title;
                const description = card.dataset.description;
                if (title.includes(searchValue) || description.includes(searchValue)) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }
            });
            updateResultsCount();
        });

        showAllBtn.addEventListener("click", function () {
            searchInput.value = "";
            cards.forEach(card => card.style.display = "");
            updateResultsCount();
        });

        // Initial count
        updateResultsCount();
    });
</script>
