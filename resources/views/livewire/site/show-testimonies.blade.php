<div class="container py-5" id="testimony-section">
    <!-- Section Header -->
    <div class="text-center mb-5">
        <h2 data-aos="fade-up">Testimonies</h2>
        <p data-aos="fade-up">Stories of transformation, encouragement, and impact from across our community.</p>
    </div>

    <!-- Search Box -->
    <div class="row mb-4 justify-content-center">
        <div class="col-md-6">
            <input type="text" id="testimonySearch" class="form-control" placeholder="Search testimonies...">
        </div>
    </div>

    <!-- Testimonies Grid -->
    <div class="row" id="testimonyContainer">
        @foreach ($testimonies as $testimony)
        @php
            $image = $testimony->image 
                     ? asset('storage/' . $testimony->image) 
                     : 'https://api.dicebear.com/9.x/croodles-neutral/svg?seed=Easton';
    
            $name = $testimony->name ?? '--';
            $title = $testimony->title ?? '--';
            $desc = $testimony->description ?? '';
        @endphp
    
        <div class="col-md-6 col-lg-6 mb-4 testimony-item" 
             data-name="{{ strtolower($name) }}" 
             data-title="{{ strtolower($title) }}" 
             data-description="{{ strtolower($desc) }}">
            <div class="card h-100 shadow-sm border-0 p-3">
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ $image }}" alt="{{ $name }}" class="rounded" 
                         style="width: 75px; height: 75px; object-fit: cover;">
                    <div class="ms-3">
                        <h6 class="mb-0">{{ $name }}</h6>
                        <small class="text-muted">{{ $title }}</small>
                    </div>
                </div>
                <p class="text-muted small">
                    <i class="bx bxs-quote-alt-left me-1"></i>
                    {{ $desc }}
                    <i class="bx bxs-quote-alt-right ms-1"></i>
                </p>
            </div>
        </div>
    @endforeach
    
    </div>

    <!-- No Results Message -->
    <div class="text-center text-muted mt-4 d-none" id="noResultsMsg">
        <em>No testimonies match your search.</em>
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
