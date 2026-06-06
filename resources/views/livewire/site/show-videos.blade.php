<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Video Library</h2>
            <p class="lead mb-0">Watch stories, updates, and translation-focused content from our mission field.</p>
        </section>

       <section class="modern-video-section">

    {{-- Section Header --}}
    <div class="video-section-header">

        <div>
            <span class="video-mini-title">
                Media Library
            </span>

            <h2 class="video-main-title">
                Video Gallery
            </h2>
        </div>

        <div class="video-stats-card">
            <strong>{{ count($video_items) }}</strong>
            <span>Videos Available</span>
        </div>

    </div>

    {{-- Search Toolbar --}}
    <div class="video-toolbar">

        <div class="video-search-wrapper">
            <i class="fas fa-search"></i>

            <input type="text"
                id="videoSearch"
                class="video-search-input"
                placeholder="Search videos by title or description...">
        </div>

        <div class="video-toolbar-right">

            <button id="showAllBtn"
                class="video-show-all-btn">

                <i class="fas fa-layer-group me-2"></i>
                Show All
            </button>

            <div class="video-results-count"
                id="resultsCount">

                Showing {{ count($video_items) }} results
            </div>

        </div>

    </div>

    {{-- Video Grid --}}
    <div class="row g-4"
        id="videoContainer">

        @foreach ($video_items as $video)

            @php
                preg_match(
                    "/(?:youtube\.com\/(?:[^\/]+\/.+|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/",
                    $video->video_link,
                    $matches,
                );

                $videoId = $matches[1] ?? null;
            @endphp

            @if ($videoId)

                <div class="col-lg-6 video-card"
                    data-title="{{ strtolower($video->name) }}"
                    data-description="{{ strtolower($video->description) }}">

                    <div class="modern-video-card h-100">

                        {{-- Video Frame --}}
                        <div class="video-frame-wrapper">

                            <div class="video-glow"></div>

                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                    title="{{ $video->name }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>

                        </div>

                        {{-- Content --}}
                        <div class="video-card-body">

                            <div class="video-badge">
                                <i class="fas fa-play-circle me-2"></i>
                                Featured Video
                            </div>

                            <h4 class="video-card-title">
                                {{ $video->name }}
                            </h4>

                            <p class="video-card-description">
                                {{ Str::limit($video->description, 140, '...') }}
                            </p>

                            <div class="video-card-footer">

                                <a href="{{ $video->video_link }}"
                                    target="_blank"
                                    class="watch-video-btn">

                                    Watch on YouTube
                                    <i class="fab fa-youtube ms-2"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endif

        @endforeach

    </div>

</section>

<style>
    .modern-video-section {
        position: relative;
    }

    /* Header */

    .video-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }

    .video-mini-title {
        display: inline-block;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #cd5b13;
        margin-bottom: 8px;
    }

    .video-main-title {
        font-size: 2.2rem;
        font-weight: 800;
        color: #2e1c10;
        margin: 0;
    }

    .video-stats-card {
        background: linear-gradient(135deg, #f7ebdb, #f3ddc3);
        border-radius: 24px;
        padding: 18px 24px;
        min-width: 180px;
        text-align: center;
        box-shadow: 0 12px 28px rgba(44, 22, 8, 0.06);
    }

    .video-stats-card strong {
        display: block;
        font-size: 1.8rem;
        color: #a56628;
        line-height: 1;
        margin-bottom: 6px;
    }

    .video-stats-card span {
        color: #7b695b;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Toolbar */

    .video-toolbar {
        background: #fff;
        border-radius: 24px;
        padding: 20px;
        border: 1px solid #f1e3d3;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-bottom: 35px;
        box-shadow: 0 12px 30px rgba(44, 22, 8, 0.05);
    }

    .video-search-wrapper {
        position: relative;
        flex: 1;
        min-width: 260px;
    }

    .video-search-wrapper i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #b47c40;
    }

    .video-search-input {
        width: 100%;
        height: 56px;
        border-radius: 18px;
        border: 1px solid #ead8c2;
        background: #fcfaf8;
        padding: 0 18px 0 50px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .video-search-input:focus {
        outline: none;
        border-color: #cd5b13;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(205, 91, 19, 0.10);
    }

    .video-toolbar-right {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .video-show-all-btn {
        height: 52px;
        border: none;
        border-radius: 16px;
        padding: 0 22px;
        background: #cd5b13;
        color: #fff;
        font-weight: 600;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(205, 91, 19, 0.22);
    }

    .video-show-all-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(205, 91, 19, 0.28);
    }

    .video-results-count {
        font-size: 0.92rem;
        color: #786b60;
        font-weight: 600;
    }

    /* Cards */

    .modern-video-card {
        background: #fff;
        border-radius: 28px;
        overflow: hidden;
        border: 1px solid #f0e2d3;
        transition: all 0.35s ease;
        box-shadow: 0 14px 34px rgba(44, 22, 8, 0.06);
    }

    .modern-video-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 48px rgba(44, 22, 8, 0.14);
    }

    .video-frame-wrapper {
        position: relative;
        overflow: hidden;
        background: #000;
    }

    .video-glow {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.45),
                rgba(0, 0, 0, 0));
        z-index: 1;
        pointer-events: none;
    }

    .video-frame-wrapper iframe {
        border: 0;
        width: 100%;
        height: 100%;
    }

    .video-card-body {
        padding: 28px;
    }

    .video-badge {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, #f7e8d7, #f3dcc0);
        color: #a66729;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.78rem;
        font-weight: 700;
        margin-bottom: 18px;
    }

    .video-card-title {
        font-size: 1.3rem;
        font-weight: 800;
        line-height: 1.45;
        color: #2f1d10;
        margin-bottom: 14px;
    }

    .video-card-description {
        color: #77695d;
        line-height: 1.8;
        font-size: 0.94rem;
        margin-bottom: 26px;
    }

    .video-card-footer {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .watch-video-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 13px 22px;
        border-radius: 16px;
        background: #cd5b13;
        color: #fff;
        font-size: 0.92rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(205, 91, 19, 0.22);
    }

    .watch-video-btn:hover {
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(205, 91, 19, 0.28);
    }

    /* Responsive */

    @media (max-width: 768px) {
        .video-main-title {
            font-size: 1.7rem;
        }

        .video-toolbar {
            padding: 16px;
        }

        .video-card-body {
            padding: 22px;
        }

        .video-card-title {
            font-size: 1.1rem;
        }
    }
</style>
    </div>
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
