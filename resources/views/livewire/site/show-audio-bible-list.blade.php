<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Audio Bible Library</h2>
            <p class="lead mb-0">{{ $title ?? 'Listen, study, and share Bible audio resources by project and language context.' }}</p>
        </section>

        <div class="row g-4">
            <aside class="col-lg-3">
                <div class="modern-sidebar">
                    <div class="sidebar-header">
                        <div class="sidebar-icon">
                            <i class="bi bi-headphones"></i>
                        </div>

                        <div>
                            <h5 class="sidebar-title mb-1">Audio Projects</h5>
                            <p class="sidebar-subtitle mb-0">Browse recordings by project</p>
                        </div>
                    </div>

                    <div class="category-list">
                        <a href="{{ route('audio.bible') }}" class="category-item {{ empty($project_id) || $project_id == '0' ? 'active' : '' }}">
                            <div class="category-content">
                                <div class="category-dot"></div>
                                <span class="category-name">All Projects</span>
                            </div>
                            <span class="category-count">{{ collect($categories)->sum('audio_count') }}</span>
                        </a>

                        @foreach ($categories as $item)
                            @php
                                $project = $item->project;
                                $projectId = $project->id ?? null;
                                $projectTitle = $project->title ?? null;
                            @endphp

                            @if ($projectId && $projectTitle)
                                <a href="{{ route('audio.bible', ['project' => $projectId]) }}"
                                    class="category-item {{ (string) $project_id === (string) $projectId ? 'active' : '' }}">
                                    <div class="category-content">
                                        <div class="category-dot"></div>
                                        <span class="category-name">{{ $projectTitle }}</span>
                                    </div>
                                    <span class="category-count">{{ $item->audio_count ?? '0' }}</span>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </aside>

            <div class="col-lg-9">
                <section class="news-section">
                    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                        <div>
                            <h4 class="mb-1">Available Recordings</h4>
                            <p class="text-muted mb-0 small">Stream or download scripture audio by project.</p>
                        </div>
                        <span class="site-pill mt-2 mt-sm-0">{{ $audioFiles->total() }} Tracks</span>
                    </div>

                    <div class="site-search-row">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search audio titles or descriptions...">
                        <button class="btn btn-outline-secondary" onclick="resetSearch()">Reset</button>
                        <span class="text-muted small align-self-center" id="resultCount"></span>
                    </div>

                    <div class="row g-4" id="audioList">
                        @forelse ($audioFiles as $item)
                            @foreach ($item->media as $media)
                                <div class="col-md-6 audio-card" data-title="{{ strtolower($item->title ?? '') }}" data-description="{{ strtolower($item->short_description ?? '') }}">
                                    <article class="news-card h-100 audio-news-card">
                                        <div class="news-card-body d-flex flex-column gap-2">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
                                                <span class="news-badge audio-badge">Audio Bible</span>
                                                <small class="text-muted">{{ $item->post_date ?? '-' }}</small>
                                            </div>

                                            <h5 class="news-title mb-1">{{ $item->title ?? 'Untitled' }}</h5>

                                            <p class="text-muted small mb-1">
                                                <i class="bi bi-folder2-open"></i> {{ $item->project->title ?? '-' }}
                                            </p>

                                            <p class="news-text mb-2">{{ \Illuminate\Support\Str::limit($item->description ?? '-', 150) }}</p>

                                            <audio controls class="w-100 mb-2"
                                                data-title="{{ $item->title ?? 'Untitled' }}"
                                                data-project="{{ $item->project->title ?? '-' }}">
                                                <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                                Your browser does not support the audio element.
                                            </audio>

                                            <div class="d-flex gap-2 mt-auto">
                                                <a href="{{ $media->getUrl() }}" class="btn btn-sm btn-outline-secondary" target="_blank">Open</a>
                                                <a href="{{ $media->getUrl() }}" class="btn btn-sm btn-outline-primary" download>Download</a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        @empty
                            <div class="col-12">
                                <div class="news-empty-state">
                                    <div class="empty-icon"><i class="bi bi-headphones"></i></div>
                                    <h4>No Audio Files Available</h4>
                                    <p>There are currently no recordings for this selection.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $audioFiles->links() }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<div id="audioMiniPlayer" class="audio-mini-player d-none" aria-live="polite">
    <div class="audio-mini-player__left">
        <div class="audio-mini-player__icon">
            <i class="bi bi-headphones"></i>
        </div>
        <div>
            <div class="audio-mini-player__label">Currently Playing</div>
            <div id="miniPlayerTitle" class="audio-mini-player__title">-</div>
            <div id="miniPlayerProject" class="audio-mini-player__meta">-</div>
        </div>
    </div>

    <div class="audio-mini-player__actions">
        <button id="miniTogglePlay" type="button" class="btn btn-sm btn-light" aria-label="Play or pause current audio">
            <i id="miniToggleIcon" class="bi bi-pause-fill"></i>
        </button>
        <button id="miniClosePlayer" type="button" class="btn btn-sm btn-outline-light" aria-label="Close mini player">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
</div>

<!-- 🔍 JavaScript Search Script -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInput");
        const audioCards = document.querySelectorAll(".audio-card");
        const audioPlayers = document.querySelectorAll("#audioList audio");
        const resultCount = document.getElementById("resultCount");
        const miniPlayer = document.getElementById("audioMiniPlayer");
        const miniTitle = document.getElementById("miniPlayerTitle");
        const miniProject = document.getElementById("miniPlayerProject");
        const miniTogglePlay = document.getElementById("miniTogglePlay");
        const miniToggleIcon = document.getElementById("miniToggleIcon");
        const miniClosePlayer = document.getElementById("miniClosePlayer");

        let currentAudio = null;

        const updateCount = (visibleCount, totalCount) => {
            resultCount.textContent = `${visibleCount} of ${totalCount} results shown`;
        };

        const filterAudio = () => {
            const term = searchInput.value.toLowerCase();
            let visible = 0;

            audioCards.forEach(card => {
                const title = card.getAttribute("data-title");
                const description = card.getAttribute("data-description");
                const match = title.includes(term) || description.includes(term);

                card.style.display = match ? "block" : "none";
                if (match) visible++;
            });

            updateCount(visible, audioCards.length);
        };

        searchInput.addEventListener("input", filterAudio);
        updateCount(audioCards.length, audioCards.length); // Initial count

        window.resetSearch = () => {
            searchInput.value = '';
            audioCards.forEach(card => card.style.display = 'block');
            updateCount(audioCards.length, audioCards.length);
        };

        const setMiniPlayerState = (isPlaying) => {
            if (!miniToggleIcon) return;
            miniToggleIcon.classList.remove('bi-play-fill', 'bi-pause-fill');
            miniToggleIcon.classList.add(isPlaying ? 'bi-pause-fill' : 'bi-play-fill');
        };

        audioPlayers.forEach((player) => {
            player.addEventListener('play', () => {
                if (currentAudio && currentAudio !== player) {
                    currentAudio.pause();
                }

                currentAudio = player;
                miniTitle.textContent = player.dataset.title || 'Untitled';
                miniProject.textContent = player.dataset.project || '-';
                miniPlayer.classList.remove('d-none');
                miniPlayer.classList.add('audio-mini-player--visible');
                setMiniPlayerState(true);
            });

            player.addEventListener('pause', () => {
                if (currentAudio === player) {
                    setMiniPlayerState(false);
                }
            });

            player.addEventListener('ended', () => {
                if (currentAudio === player) {
                    setMiniPlayerState(false);
                }
            });
        });

        if (miniTogglePlay) {
            miniTogglePlay.addEventListener('click', () => {
                if (!currentAudio) return;

                if (currentAudio.paused) {
                    currentAudio.play();
                } else {
                    currentAudio.pause();
                }
            });
        }

        if (miniClosePlayer) {
            miniClosePlayer.addEventListener('click', () => {
                if (currentAudio) {
                    currentAudio.pause();
                }

                miniPlayer.classList.add('d-none');
                miniPlayer.classList.remove('audio-mini-player--visible');
            });
        }
    });
</script>

<style>
    .audio-news-card .news-card-body {
        padding: 20px;
    }

    .audio-badge {
        display: inline-flex;
        align-items: center;
        font-size: .72rem;
        font-weight: 700;
        padding: 4px 9px;
        border-radius: 999px;
        background: rgba(205, 91, 19, 0.12);
        color: #cd5b13;
    }

    .modern-sidebar .category-item.active {
        background: rgba(205, 91, 19, 0.15);
        border-color: rgba(205, 91, 19, 0.35);
    }

    .modern-sidebar .category-item.active .category-name,
    .modern-sidebar .category-item.active .category-count {
        color: #a34810;
        font-weight: 700;
    }

    .modern-sidebar .category-item.active .category-count {
        background: rgba(205, 91, 19, 0.22);
        color: #a34810;
    }

    .modern-sidebar .category-item.active .category-dot {
        background: #cd5b13;
    }

    .audio-news-card {
        border: 1px solid #e2e8f0;
        transition: .3s ease;
    }

    .audio-news-card:hover {
        border-color: rgba(205, 91, 19, 0.3);
        box-shadow: 0 12px 30px rgba(205, 91, 19, 0.08);
    }

    .audio-news-card .btn-outline-primary {
        border-color: #cd5b13;
        color: #cd5b13;
    }

    .audio-news-card .btn-outline-primary:hover {
        background: #cd5b13;
        border-color: #cd5b13;
        color: #fff;
    }

    .audio-mini-player {
        position: fixed;
        left: 50%;
        bottom: 16px;
        transform: translateX(-50%);
        width: min(960px, calc(100% - 24px));
        background: linear-gradient(to left, #f59e0b, #cd5b13);
        color: #ffffff;
        border: 1px solid rgba(205, 91, 19, 0.35);
        border-radius: 14px;
        padding: 12px 14px;
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.32);
        z-index: 1100;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .audio-mini-player__left {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .audio-mini-player__icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        flex-shrink: 0;
    }

    .audio-mini-player__label {
        font-size: .72rem;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: rgba(255, 255, 255, 0.7);
        font-weight: 700;
    }

    .audio-mini-player__title {
        font-size: .95rem;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 60vw;
    }

    .audio-mini-player__meta {
        font-size: .78rem;
        color: rgba(255, 255, 255, 0.7);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 60vw;
    }

    .audio-mini-player__actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .audio-mini-player__actions .btn-light {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: #ffffff;
    }

    .audio-mini-player__actions .btn-light:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    .audio-mini-player__actions .btn-outline-light {
        border-color: rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.7);
    }

    .audio-mini-player__actions .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.12);
        color: #fff;
    }

    /* Audio player accent */
    audio::-webkit-media-controls-play-button,
    audio::-webkit-media-controls-panel {
        background: #efefff;
    }

    @media (max-width: 768px) {
        .audio-mini-player {
            bottom: 10px;
            width: calc(100% - 14px);
            padding: 10px;
        }

        .audio-mini-player__title,
        .audio-mini-player__meta {
            max-width: 48vw;
        }
    }
</style>
