<div class="site-shell py-5" id="testimony-section">
    <div class="container">
        @php
            $testimonies = $testimonies ?? collect();
        @endphp

        <section class="page-hero">
            <h2 class="mb-2">Testimonies</h2>
            <p class="lead mb-0">Stories of encouragement and transformation from communities we serve.</p>
        </section>

     <section class="modern-testimony-section">

    {{-- Header --}}
    <div class="testimony-header">

        <div>
            <span class="testimony-mini-title">
                Faith Stories
            </span>

            <h2 class="testimony-main-title">
                Life Changing Testimonies
            </h2>

            <p class="testimony-subtitle">
                Inspiring stories of faith, healing, transformation and hope.
            </p>
        </div>

        <div class="testimony-count-card">
            <strong>{{ count($testimonies) }}</strong>
            <span>Total Testimonies</span>
        </div>

    </div>

    {{-- Search --}}
    <div class="testimony-search-bar">

        <div class="testimony-search-wrapper">

            <i class="fas fa-search"></i>

            <input type="text"
                id="testimonySearch"
                class="testimony-search-input"
                placeholder="Search testimonies by name, title or content...">

        </div>

    </div>

    {{-- Testimony Grid --}}
    <div class="row g-4"
        id="testimonyContainer">

        @foreach ($testimonies as $testimony)

            @php
                $image = $testimony->image
                    ? asset('storage/' . $testimony->image)
                    : 'https://api.dicebear.com/9.x/thumbs/svg?seed=Maria';

                $name = $testimony->name ?? '--';
                $title = $testimony->title ?? '--';
                $desc = $testimony->description ?? '';
            @endphp

            <div class="col-lg-6 testimony-item"
                data-name="{{ strtolower($name) }}"
                data-title="{{ strtolower($title) }}"
                data-description="{{ strtolower($desc) }}">

                <div class="modern-testimony-card h-100">

                    {{-- Decorative Glow --}}
                    <div class="card-glow"></div>

                    {{-- Quote Icon --}}
                    <div class="quote-icon">
                        <i class="fas fa-quote-left"></i>
                    </div>

                    {{-- User --}}
                    <div class="testimony-user">

                        <div class="testimony-avatar-wrapper">

                            <img src="{{ $image }}"
                                alt="{{ $name }}"
                                class="testimony-avatar">

                            <div class="avatar-ring"></div>

                        </div>

                        <div class="testimony-user-info">

                            <h5 class="testimony-name">
                                {{ $name }}
                            </h5>

                            <span class="testimony-role">
                                {{ $title }}
                            </span>

                        </div>

                    </div>

                    {{-- Content --}}
                    <div class="testimony-content">

                        <p class="testimony-text">
                            {{ Str::limit($desc, 260, '...') }}
                        </p>

                    </div>

                    {{-- Footer --}}
                    <div class="testimony-footer">

                        <div class="faith-badge">
                            <i class="fas fa-dove me-2"></i>
                            Faith Testimony
                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    {{-- Empty State --}}
    <div class="modern-no-results d-none"
        id="noResultsMsg">

        <div class="no-results-icon">
            <i class="fas fa-search"></i>
        </div>

        <h4>No Matching Testimonies</h4>

        <p>
            No testimonies match your current search keywords.
        </p>

    </div>

</section>

<section class="public-testimony-submit mt-5">
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4 p-md-5">
            <h3 class="mb-2">Share Your Testimony</h3>
            <p class="text-muted mb-4">Submit your testimony below. Our BILTA admins will review it first, then publish it before it appears publicly.</p>

            @if (session()->has('testimonial_success'))
                <div class="alert alert-success" role="alert">
                    {{ session('testimonial_success') }}
                </div>
            @endif

            @if (session()->has('testimonial_error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('testimonial_error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('testimonies.submit') }}" class="row g-3" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="_form_loaded_at" value="{{ now()->timestamp }}">

                <div style="position:absolute; left:-9999px; opacity:0; pointer-events:none;" aria-hidden="true">
                    <label for="website">Website</label>
                    <input id="website" type="text" name="website" value="">
                </div>

                <div class="col-md-4">
                    <label for="publicTestimonyName" class="form-label font-weight-bold">Name</label>
                    <input id="publicTestimonyName" type="text" name="name" class="form-control" value="{{ old('name') }}" required maxlength="255">
                </div>

                <div class="col-md-4">
                    <label for="publicTestimonyEmail" class="form-label font-weight-bold">Email</label>
                    <input id="publicTestimonyEmail" type="email" name="email" class="form-control" value="{{ old('email') }}" required maxlength="255">
                </div>

                <div class="col-md-4">
                    <label for="publicTestimonyPhone" class="form-label font-weight-bold">Phone</label>
                    <input id="publicTestimonyPhone" type="text" name="phone" class="form-control" value="{{ old('phone') }}" required maxlength="30">
                </div>

                <div class="col-12">
                    <label for="publicTestimonyTitle" class="form-label font-weight-bold">Title (Optional)</label>
                    <input id="publicTestimonyTitle" type="text" name="title" class="form-control" value="{{ old('title') }}" maxlength="255" placeholder="Example: How God transformed my life">
                </div>

                <div class="col-12">
                    <label for="publicTestimonyImage" class="form-label font-weight-bold">Photo (Optional)</label>
                    <input id="publicTestimonyImage" type="file" name="image" class="form-control" accept="image/*">
                    <small class="text-muted">Accepted: JPG, PNG, WEBP. Max 5 MB.</small>
                </div>

                <div class="col-12">
                    <label for="publicTestimonyDescription" class="form-label font-weight-bold">Your Testimony</label>
                    <textarea id="publicTestimonyDescription" name="description" rows="6" class="form-control" required maxlength="5000" placeholder="Please share the full details of your testimony.">{{ old('description') }}</textarea>
                </div>

                <div class="col-12 d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <small class="text-muted">Submissions are reviewed by admins before publishing.</small>
                    <button type="submit" class="btn btn-primary px-4">Submit Testimony</button>
                </div>
            </form>
        </div>
    </div>
</section>

<style>
    .modern-testimony-section {
        position: relative;
    }

    /* Header */

    .testimony-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 34px;
    }

    .testimony-mini-title {
        display: inline-block;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #c33205;
        margin-bottom: 8px;
    }

    .testimony-main-title {
        font-size: 2.3rem;
        font-weight: 800;
        color: #2f1d10;
        margin-bottom: 10px;
    }

    .testimony-subtitle {
        color: #76695d;
        font-size: 1rem;
        max-width: 620px;
        line-height: 1.8;
        margin: 0;
    }

    .testimony-count-card {
        background: linear-gradient(135deg, #f8ead9, #f4dfc5);
        border-radius: 24px;
        padding: 20px 26px;
        min-width: 180px;
        text-align: center;
        box-shadow: 0 12px 28px rgba(44, 22, 8, 0.06);
    }

    .testimony-count-card strong {
        display: block;
        font-size: 2rem;
        line-height: 1;
        color: #a76728;
        margin-bottom: 8px;
    }

    .testimony-count-card span {
        color: #7d6d60;
        font-size: 0.9rem;
        font-weight: 600;
    }

    /* Search */

    .testimony-search-bar {
        margin-bottom: 36px;
    }

    .testimony-search-wrapper {
        position: relative;
        background: #fff;
        border-radius: 24px;
        padding: 16px;
        border: 1px solid #f0e2d3;
        box-shadow: 0 12px 32px rgba(44, 22, 8, 0.05);
    }

    .testimony-search-wrapper i {
        position: absolute;
        left: 34px;
        top: 50%;
        transform: translateY(-50%);
        color: #b57e41;
    }

    .testimony-search-input {
        width: 100%;
        height: 56px;
        border-radius: 18px;
        border: 1px solid #ead9c5;
        background: #fcfaf8;
        padding: 0 20px 0 54px;
        font-size: 0.96rem;
        transition: all 0.3s ease;
    }

    .testimony-search-input:focus {
        outline: none;
        border-color: #c33205;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(195, 50, 5, 0.08);
    }

    /* Cards */

    .modern-testimony-card {
        position: relative;
        background: #fff;
        border-radius: 30px;
        padding: 32px;
        border: 1px solid #f0e2d3;
        overflow: hidden;
        transition: all 0.35s ease;
        box-shadow: 0 14px 34px rgba(44, 22, 8, 0.06);
    }

    .modern-testimony-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 22px 48px rgba(44, 22, 8, 0.14);
    }

    .card-glow {
        position: absolute;
        top: -80px;
        right: -80px;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(rgba(201, 133, 61, 0.12), transparent 70%);
    }

    .quote-icon {
        width: 68px;
        height: 68px;
        border-radius: 22px;
        background: linear-gradient(135deg, #c33205, #9a2804);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.3rem;
        margin-bottom: 28px;
        box-shadow: 0 12px 28px rgba(195, 50, 5, 0.24);
    }

    .testimony-user {
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 26px;
    }

    .testimony-avatar-wrapper {
        position: relative;
        width: 82px;
        height: 82px;
        flex-shrink: 0;
    }

    .testimony-avatar {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 24px;
        position: relative;
        z-index: 2;
    }

    .avatar-ring {
        position: absolute;
        inset: -5px;
        border-radius: 28px;
        border: 2px dashed rgba(201, 133, 61, 0.35);
    }

    .testimony-name {
        font-size: 1.18rem;
        font-weight: 800;
        color: #2f1d10;
        margin-bottom: 6px;
    }

    .testimony-role {
        display: inline-block;
        color: #a66729;
        font-size: 0.88rem;
        font-weight: 700;
        background: rgba(201, 133, 61, 0.10);
        padding: 7px 14px;
        border-radius: 50px;
    }

    .testimony-content {
        position: relative;
    }

    .testimony-text {
        color: #67584d;
        line-height: 2;
        font-size: 0.97rem;
        margin-bottom: 30px;
        position: relative;
    }

    .testimony-footer {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .faith-badge {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, #f8ebdb, #f4dfc7);
        color: #a66729;
        padding: 10px 18px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
    }

    /* Empty */

    .modern-no-results {
        background: #fff;
        border-radius: 30px;
        padding: 70px 30px;
        text-align: center;
        border: 1px dashed #ddc3a5;
        margin-top: 20px;
    }

    .no-results-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin: 0 auto 24px;
        background: linear-gradient(135deg, #f8eadb, #f4dec6);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #b67633;
        font-size: 2rem;
    }

    .modern-no-results h4 {
        color: #311f12;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .modern-no-results p {
        color: #7d6e63;
        margin: 0;
    }

    /* Responsive */

    @media (max-width: 768px) {
        .testimony-main-title {
            font-size: 1.8rem;
        }

        .modern-testimony-card {
            padding: 24px;
        }

        .testimony-user {
            align-items: flex-start;
        }

        .testimony-avatar-wrapper {
            width: 72px;
            height: 72px;
        }

        .quote-icon {
            width: 58px;
            height: 58px;
            font-size: 1.1rem;
        }
    }
</style>
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
