<div class="site-shell py-5" id="testimony-section">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Testimonies</h2>
            <p class="lead mb-0">Stories of encouragement and transformation from communities we serve.</p>
        </section>

        <section class="page-section">
            <div class="site-search-row mb-4">
                <input type="text" id="testimonySearch" class="form-control" placeholder="Search testimonies...">
            </div>

            <div class="row g-4" id="testimonyContainer">
                @foreach ($testimonies as $testimony)
                    @php
                        $image = $testimony->image ? asset('storage/' . $testimony->image) : 'https://api.dicebear.com/9.x/thumbs/svg?seed=Maria';
                        $name = $testimony->name ?? '--';
                        $title = $testimony->title ?? '--';
                        $desc = $testimony->description ?? '';
                    @endphp

                    <div class="col-md-6 testimony-item" data-name="{{ strtolower($name) }}" data-title="{{ strtolower($title) }}" data-description="{{ strtolower($desc) }}">
                        <div class="site-card h-100 p-3">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $image }}" alt="{{ $name }}" class="rounded" style="width: 72px; height: 72px; object-fit: cover;">
                                <div class="ms-3">
                                    <h6 class="mb-0">{{ $name }}</h6>
                                    <small class="text-muted">{{ $title }}</small>
                                </div>
                            </div>
                            <p class="small mb-0"><i class="bx bxs-quote-alt-left me-1"></i>{{ $desc }}<i class="bx bxs-quote-alt-right ms-1"></i></p>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center text-muted mt-4 d-none" id="noResultsMsg"><em>No testimonies match your search.</em></div>
        </section>
    </div>
</div>

<!-- JavaScript: Search Functionality -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("testimonySearch");
        const items = document.querySelectorAll(".testimony-item");
        const noResultsMsg = document.getElementById("noResultsMsg");

        searchInput.addEventListener("input", function () {
            const term = this.value.toLowerCase();
            let matchCount = 0;

            items.forEach(item => {
                const name = item.dataset.name;
                const title = item.dataset.title;
                const desc = item.dataset.description;

                const isVisible = name.includes(term) || title.includes(term) || desc.includes(term);
                item.style.display = isVisible ? "" : "none";

                if (isVisible) matchCount++;
            });

            noResultsMsg.classList.toggle("d-none", matchCount > 0);
        });
    });
</script>
