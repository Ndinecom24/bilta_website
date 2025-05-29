<section id="audio-bible" class="section-bg py-5">
    <div class="container">
        <!-- Section Title -->
        <div class="section-title text-center mb-5">
            <h2 data-aos="fade-up">Audio Bible</h2>
            <p data-aos="fade-up">{{ $title ?? 'Listen to the Word of God in audio format.' }}</p>
        </div>

        <div class="row">
            <!-- Sidebar: Categories / Projects -->
            <aside class="col-lg-3 mb-4" data-aos="fade-up">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Filter by Projects</h5>
                        <ul class="list-group list-group-flush">

                            @foreach ($categories as $item)
                          
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('audio.bible', $item->project->id ?? '0') }}" class="text-decoration-none">
                                        {{ $item->project->title ?? '-' }}
                                    </a>
                                    <span class="badge bg-primary rounded-pill">{{ $item->audio_count ?? '0' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="col-lg-9">

                <!-- Search & Result Count -->
                <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <input type="text" id="searchInput" class="form-control w-75" placeholder="Search audio titles or descriptions...">
                    <button class="btn btn-secondary" onclick="resetSearch()">Show All</button>
                    <span class="text-muted small" id="resultCount"></span>
                </div>

                <!-- Audio Cards -->
                <div class="row g-4" id="audioList">
                    @php $totalAudios = 0; @endphp

                    @forelse ($audioFiles as $item)
                        @foreach ($item->media as $media)
                            @php $totalAudios++; @endphp
                            <div class="col-md-6 audio-card" data-title="{{ strtolower($item->title) }}" data-description="{{ strtolower($item->short_description) }}">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $item->title ?? 'Untitled' }}</h5>
                                        <p class="text-muted small">
                                            <i class="bi bi-folder2-open"></i> {{ $item->project->title ?? '-' }} &nbsp;
                                            <i class="bi bi-tags"></i> {{ $item->project->myCategory->name ?? '-' }}
                                        </p>
                                        <p class="card-text small">{{ $item->description ?? '-' }}</p>

                                        <audio controls class="w-100 my-2">
                                            <source src="{{ $media->getUrl() }}" type="{{ $media->mime_type }}">
                                            Your browser does not support the audio element.
                                        </audio>

                                        <div class="mt-auto">
                                            <a href="{{ $media->getUrl() }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <a href="{{ $media->getUrl() }}" class="btn btn-sm btn-outline-primary" download>
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                           
                        @endforeach
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center" role="alert">
                                No audio files available at the moment.
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination (optional) -->
                <div class="mt-4">
                    {{ $audioFiles->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🔍 JavaScript Search Script -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchInput = document.getElementById("searchInput");
        const audioCards = document.querySelectorAll(".audio-card");
        const resultCount = document.getElementById("resultCount");

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
    });
</script>
