<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Weekly Prayer Points</h2>
            <p class="lead mb-0">Stay aligned with our prayer focus and intercede for ongoing translation work.</p>
        </section>

        <section class="page-section">
            <div class="row g-3 mb-4 align-items-center">
                <div class="col-md-2"><input type="date" name="start_date" id="start_date" class="form-control" wire:model="start_date"></div>
                <div class="col-md-2"><input type="date" name="end_date" id="end_date" class="form-control" wire:model="end_date"></div>
                <div class="col-md-2"><button wire:click="search()" class="btn btn-primary w-100">Filter</button></div>
                <div class="col-md-4 offset-md-2"><input type="text" id="prayerSearch" class="form-control" placeholder="Search prayer points..."></div>
            </div>

            <p class="mb-3"><span class="site-pill">Total: <strong class="ms-1" id="totalCounter">{{ count($dataset) }}</strong></span></p>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="accordion" id="prayerAccordion">
                        @forelse($dataset as $key => $item)
                            <div class="accordion-item mb-3 border-0 site-card prayer-item">
                                <h2 class="accordion-header" id="heading{{ $key }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapse{{ $key }}">
                                        {{ $item->title }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $key }}" data-bs-parent="#prayerAccordion">
                                    <div class="accordion-body">
                                        <p>{{ $item->details }}</p>
                                        @if($item->scriptures)
                                            <p class="mb-0"><strong>Scriptures:</strong> <em>{{ $item->scriptures }}</em></p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="site-empty">No prayer points available.</div>
                        @endforelse
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="site-card p-2">
                        <img src="{{ asset('assets/img/biblee017c8414_1920.png') }}" class="img-fluid rounded" alt="Prayer focus">
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
