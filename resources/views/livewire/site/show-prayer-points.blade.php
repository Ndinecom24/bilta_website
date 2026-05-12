<div class="site-shell py-5">
    <div class="container">
        <section class="page-hero">
            <h2 class="mb-2">Weekly Prayer Points</h2>
            <p class="lead mb-0">Stay aligned with our prayer focus and intercede for ongoing translation work.</p>
        </section>

      <section class="modern-prayer-section">

    {{-- Header --}}
    <div class="prayer-section-header">

        <div>
            <span class="prayer-mini-title">
                Spiritual Growth
            </span>

            <h2 class="prayer-main-title">
                Prayer Points & Scriptures
            </h2>
        </div>

        <div class="prayer-counter-card">
            <strong id="totalCounter">{{ count($dataset) }}</strong>
            <span>Total Prayer Points</span>
        </div>

    </div>

    {{-- Filters --}}
    <div class="prayer-toolbar">

        <div class="row g-3 align-items-center w-100">

            <div class="col-lg-2 col-md-6">
                <div class="modern-input-group">
                    <label>Start Date</label>

                    <input type="date"
                        name="start_date"
                        id="start_date"
                        class="modern-input"
                        wire:model="start_date">
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <div class="modern-input-group">
                    <label>End Date</label>

                    <input type="date"
                        name="end_date"
                        id="end_date"
                        class="modern-input"
                        wire:model="end_date">
                </div>
            </div>

            <div class="col-lg-2 col-md-6">
                <button wire:click="search()"
                    class="modern-filter-btn w-100">

                    <i class="fas fa-filter me-2"></i>
                    Filter
                </button>
            </div>

            <div class="col-lg-6 col-md-6">

                <div class="prayer-search-wrapper">
                    <i class="fas fa-search"></i>

                    <input type="text"
                        id="prayerSearch"
                        class="prayer-search-input"
                        placeholder="Search prayer points or scriptures...">
                </div>

            </div>

        </div>

    </div>

    {{-- Content --}}
    <div class="row g-4">

        {{-- Prayer Accordion --}}
        <div class="col-lg-8">

            <div class="accordion modern-prayer-accordion"
                id="prayerAccordion">

                @forelse($dataset as $key => $item)

                    <div class="accordion-item prayer-card prayer-item">

                        <h2 class="accordion-header"
                            id="heading{{ $key }}">

                            <button class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapse{{ $key }}"
                                aria-expanded="false"
                                aria-controls="collapse{{ $key }}">

                                <div class="prayer-title-wrapper">

                                    <div class="prayer-icon">
                                        <i class="fas fa-praying-hands"></i>
                                    </div>

                                    <div>
                                        <span class="prayer-label">
                                            Prayer Point
                                        </span>

                                        <h5 class="prayer-title">
                                            {{ $item->title }}
                                        </h5>
                                    </div>

                                </div>

                            </button>

                        </h2>

                        <div id="collapse{{ $key }}"
                            class="accordion-collapse collapse"
                            aria-labelledby="heading{{ $key }}"
                            data-bs-parent="#prayerAccordion">

                            <div class="accordion-body">

                                <div class="prayer-details">
                                    {{ $item->details }}
                                </div>

                                @if($item->scriptures)

                                    <div class="scripture-box">

                                        <div class="scripture-icon">
                                            <i class="fas fa-book-bible"></i>
                                        </div>

                                        <div>
                                            <span class="scripture-label">
                                                Supporting Scripture
                                            </span>

                                            <p class="scripture-text mb-0">
                                                {{ $item->scriptures }}
                                            </p>
                                        </div>

                                    </div>

                                @endif

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="prayer-empty-state">

                        <div class="empty-icon">
                            <i class="fas fa-dove"></i>
                        </div>

                        <h4>No Prayer Points Available</h4>

                        <p>
                            There are currently no prayer points to display.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

        {{-- Side Image --}}
        <div class="col-lg-4">

            <div class="prayer-side-card">

                <div class="side-image-wrapper">

                    <img src="{{ asset('assets/img/biblee017c8414_1920.png') }}"
                        class="img-fluid"
                        alt="Prayer focus">

                    <div class="side-overlay"></div>

                    <div class="side-content">

                        <span class="side-label">
                            Daily Reflection
                        </span>

                        <h4>
                            Stay Rooted in Prayer & Faith
                        </h4>

                        <p>
                            Strengthen your spiritual walk through consistent prayer and scripture meditation.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<style>
    .modern-prayer-section {
        position: relative;
    }

    /* Header */

    .prayer-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 32px;
    }

    .prayer-mini-title {
        display: inline-block;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #c33205;
        margin-bottom: 8px;
    }

    .prayer-main-title {
        font-size: 2.3rem;
        font-weight: 800;
        color: #2f1d10;
        margin: 0;
    }

    .prayer-counter-card {
        background: linear-gradient(135deg, #f7ead9, #f4dec5);
        border-radius: 24px;
        padding: 18px 24px;
        min-width: 180px;
        text-align: center;
        box-shadow: 0 12px 28px rgba(44, 22, 8, 0.06);
    }

    .prayer-counter-card strong {
        display: block;
        font-size: 1.9rem;
        line-height: 1;
        color: #a56628;
        margin-bottom: 6px;
    }

    .prayer-counter-card span {
        color: #7c6c60;
        font-size: 0.92rem;
        font-weight: 600;
    }

    /* Toolbar */

    .prayer-toolbar {
        background: #fff;
        border-radius: 28px;
        padding: 24px;
        border: 1px solid #f0e2d3;
        margin-bottom: 36px;
        box-shadow: 0 12px 32px rgba(44, 22, 8, 0.05);
    }

    .modern-input-group label {
        display: block;
        font-size: 0.82rem;
        font-weight: 700;
        color: #816d5d;
        margin-bottom: 8px;
    }

    .modern-input {
        width: 100%;
        height: 54px;
        border-radius: 18px;
        border: 1px solid #ead9c4;
        background: #fcfaf8;
        padding: 0 16px;
        transition: all 0.3s ease;
    }

    .modern-input:focus {
        outline: none;
        border-color: #c33205;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(195, 50, 5, 0.08);
    }

    .modern-filter-btn {
        height: 54px;
        margin-top: 28px;
        border: none;
        border-radius: 18px;
        background: linear-gradient(135deg, #c33205, #9a2804);
        color: #fff;
        font-weight: 700;
        transition: all 0.3s ease;
        box-shadow: 0 10px 24px rgba(195, 50, 5, 0.24);
    }

    .modern-filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(195, 50, 5, 0.32);
    }

    .prayer-search-wrapper {
        position: relative;
        margin-top: 28px;
    }

    .prayer-search-wrapper i {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #b47d40;
    }

    .prayer-search-input {
        width: 100%;
        height: 54px;
        border-radius: 18px;
        border: 1px solid #ead9c4;
        background: #fcfaf8;
        padding: 0 18px 0 50px;
        transition: all 0.3s ease;
    }

    .prayer-search-input:focus {
        outline: none;
        border-color: #c33205;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(195, 50, 5, 0.08);
    }

    /* Accordion */

    .modern-prayer-accordion .accordion-item {
        border: none;
        background: transparent;
        margin-bottom: 18px;
    }

    .prayer-card {
        border-radius: 26px;
        overflow: hidden;
        background: #fff;
        border: 1px solid #f0e2d3;
        box-shadow: 0 12px 30px rgba(44, 22, 8, 0.06);
        transition: all 0.35s ease;
    }

    .prayer-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 38px rgba(44, 22, 8, 0.10);
    }

    .modern-prayer-accordion .accordion-button {
        background: #fff;
        border: none;
        box-shadow: none;
        padding: 24px;
    }

    .modern-prayer-accordion .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg,
                rgba(201, 133, 61, 0.04),
                rgba(201, 133, 61, 0));
    }

    .modern-prayer-accordion .accordion-button::after {
        background-size: 18px;
    }

    .prayer-title-wrapper {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .prayer-icon {
        width: 58px;
        height: 58px;
        border-radius: 18px;
        background: linear-gradient(135deg, #c33205, #9a2804);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        box-shadow: 0 10px 24px rgba(195, 50, 5, 0.24);
        flex-shrink: 0;
    }

    .prayer-label {
        display: inline-block;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        color: #c33205;
        margin-bottom: 6px;
    }

    .prayer-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2f1d10;
        margin: 0;
    }

    .accordion-body {
        padding: 0 24px 24px 24px;
    }

    .prayer-details {
        color: #64564b;
        line-height: 1.9;
        margin-bottom: 24px;
    }

    .scripture-box {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        background: linear-gradient(135deg, #f9ecdc, #f6e4cd);
        border-radius: 20px;
        padding: 20px;
    }

    .scripture-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #c33205, #9a2804);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        flex-shrink: 0;
    }

    .scripture-label {
        display: inline-block;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #a56628;
        margin-bottom: 6px;
    }

    .scripture-text {
        color: #58493e;
        line-height: 1.8;
        font-style: italic;
    }

    /* Side Card */

    .prayer-side-card {
        position: sticky;
        top: 100px;
    }

    .side-image-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 30px;
        min-height: 620px;
        box-shadow: 0 18px 45px rgba(44, 22, 8, 0.12);
    }

    .side-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .side-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.72),
                rgba(0, 0, 0, 0.15));
    }

    .side-content {
        position: absolute;
        left: 30px;
        right: 30px;
        bottom: 30px;
        color: #fff;
    }

    .side-label {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 50px;
        background: rgba(255, 255, 255, 0.14);
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        font-size: 0.78rem;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .side-content h4 {
        font-size: 1.7rem;
        font-weight: 800;
        line-height: 1.4;
        margin-bottom: 16px;
    }

    .side-content p {
        color: rgba(255, 255, 255, 0.88);
        line-height: 1.8;
        margin: 0;
    }

    /* Empty */

    .prayer-empty-state {
        background: #fff;
        border-radius: 28px;
        padding: 70px 30px;
        text-align: center;
        border: 1px dashed #dfc4a4;
    }

    .empty-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #f9ecdc, #f5e0c5);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b47432;
        font-size: 2rem;
    }

    .prayer-empty-state h4 {
        color: #301e11;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .prayer-empty-state p {
        color: #7d6e62;
        margin: 0;
    }

    /* Responsive */

    @media (max-width: 991px) {
        .prayer-side-card {
            position: relative;
            top: unset;
        }

        .side-image-wrapper {
            min-height: 420px;
        }
    }

    @media (max-width: 768px) {
        .prayer-main-title {
            font-size: 1.8rem;
        }

        .prayer-toolbar {
            padding: 18px;
        }

        .modern-prayer-accordion .accordion-button {
            padding: 18px;
        }

        .accordion-body {
            padding: 0 18px 18px 18px;
        }

        .prayer-title-wrapper {
            gap: 14px;
        }

        .prayer-icon {
            width: 50px;
            height: 50px;
        }

        .side-content {
            left: 22px;
            right: 22px;
            bottom: 22px;
        }

        .side-content h4 {
            font-size: 1.4rem;
        }
    }
</style>
    </div>
</div>
