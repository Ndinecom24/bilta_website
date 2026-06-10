{{-- =========================
    PROFESSIONAL BiLTA HOME PAGE REDESIGN
========================= --}}

<div class="bilta-homepage">

    {{-- ================= HERO SECTION ================= --}}
    <section class="hero-section position-relative overflow-hidden"
        style="background-image:url('{{ $heroImageUrl }}')">

        <div class="hero-overlay"></div>

        {{-- Abstract decorative elements --}}
        <div class="hero-abstract-shapes">
            <div class="hero-shape hero-shape-1"></div>
           <div class="hero-shape hero-shape-2"></div>
            <div class="hero-shape hero-shape-3"></div>
          <div class="hero-shape hero-shape-4"></div>
            <div class="hero-shape hero-shape-5"></div>   {{--   --}}
            <div class="hero-grid-pattern"></div>
        </div>

        <div class="container position-relative">
            <div class="row min-vh-md-100 align-items-center py-5">

                <div class="col-lg-7" data-aos="fade-right">

                    <span class="hero-badge">
                        Bible & Literature Translation Association
                    </span>

                    <h1 class="hero-title mt-4">
                        Transforming Lives Through
                        <span>Scripture Translation</span>
                    </h1>

                    <p class="hero-description">
                        We work to make the Word of God and essential literature accessible
                        in local languages through translation, literacy development,
                        audio scripture initiatives, and community partnerships.
                    </p>

                    <div class="hero-actions d-flex flex-wrap gap-3 mt-4">

                        <a href="{{ route('projects', '0') }}"
                            class="btn btn-lg px-4 rounded-pill shadow-sm" style="background:#cd5b13; color:#fff; border:none;">
                            Explore Our Projects
                        </a>

                        <button class="btn btn-light btn-lg px-4 rounded-pill shadow-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#audioModal">

                            <i class="bi bi-play-circle me-2"></i>
                            Listen to Audio Bible
                        </button>

                    </div>

                    <div class="hero-impact mt-5">

                        <div class="hero-impact-item">
                            <h3>50+</h3>
                            <p>Active Projects</p>
                        </div>

                        <div class="hero-impact-item">
                            <h3>36+</h3>
                            <p>Completed Translations</p>
                        </div>

                        <div class="hero-impact-item">
                            <h3>108+</h3>
                            <p>Media Resources</p>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    {{-- ================= OUR SERVICES SECTION ================= --}}
    <section class="home-services-section py-5">

        <div class="container">

            <div class="text-center mb-5">

                <span class="section-tag">Our Services</span>

                <h2 class="section-title mt-3">
                    Our Services That Empower You
                </h2>

                <p class="section-description mx-auto">
                    We provide practical, faith-centered services that improve scripture access,
                    strengthen literacy, and support local language ministry impact.
                </p>

            </div>

            <div class="row g-4">

                @forelse ($services->take(6) as $service)

                    <div class="col-lg-4 col-md-6" data-aos="fade-up">

                        <article class="service-home-card h-100">

                            <div class="service-home-icon">
                                <i class="bi bi-stars"></i>
                            </div>

                            <h4 class="service-home-title">
                                {{ $service->title ?? 'Service' }}
                            </h4>

                            <p class="service-home-text mb-0">
                                {{ \Illuminate\Support\Str::limit(strip_tags($service->description ?? ''), 170) }}
                            </p>

                        </article>

                    </div>

                @empty

                    <div class="col-12">
                        <div class="summary-card text-center">
                            <p class="mb-0">No services available yet.</p>
                        </div>
                    </div>

                @endforelse

            </div>

            <div class="text-center mt-4">
                <a href="{{ route('services') }}" class="btn btn-outline-theme">
                    View All Services
                </a>
            </div>

            <div class="text-center mt-3">
                <p class="mb-2 text-muted">Need help choosing the right service for you?</p>
                <a href="{{ route('site.home') }}#contact" class="btn rounded-pill px-4" style="background:#cd5b13; color:#fff; border:none;">
                    Contact Us
                </a>
            </div>

        </div>

    </section>

    {{-- ================= MISSION SECTION ================= --}}
    <section class="mission-section py-5">

        <div class="container">

            <div class="row align-items-center g-5">

                <div class="col-lg-6" data-aos="fade-right">

                    <div class="mission-media-wrap">
                        @php
                            $missionFallback = asset('assets/img/susan-mbuzi.png');
                            $missionImages = collect($missionSliderImages ?? [])
                                ->filter(fn($item) => !empty($item))
                                ->values()
                                ->all();
                            if (empty($missionImages)) {
                                $missionImages = [$missionFallback];
                            }
                        @endphp

                        <div id="missionMediaCarousel" class="carousel slide mission-carousel" data-bs-ride="carousel" data-bs-interval="4500">
                            @if (count($missionImages) > 1)
                                <div class="carousel-indicators mission-carousel-indicators">
                                    @foreach ($missionImages as $index => $missionImage)
                                        <button type="button"
                                            data-bs-target="#missionMediaCarousel"
                                            data-bs-slide-to="{{ $index }}"
                                            class="{{ $index === 0 ? 'active' : '' }}"
                                            aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                            @endif

                            <div class="carousel-inner rounded-4 shadow-lg">
                                @foreach ($missionImages as $index => $missionImage)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $missionImage }}"
                                            class="img-fluid mission-image"
                                            alt="Bible Translation Work {{ $index + 1 }}"
                                            loading="lazy">
                                        <div class="mission-slide-overlay"></div>
                                    </div>
                                @endforeach
                            </div>

                            @if (count($missionImages) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#missionMediaCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#missionMediaCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>

                        <div class="mission-media-badge">
                            <h5 class="mb-1">Serving Communities</h5>
                            <p class="mb-0">Translation, literacy, and Scripture engagement in local languages.</p>
                        </div>
                    </div>

                </div>

                <div class="col-lg-6" data-aos="fade-left">

                    <div class="mission-panel">

                        <span class="section-tag">Who We Are</span>

                        <h2 class="section-title mt-3">
                            Bringing Scripture Closer to Every Community
                        </h2>

                        <p class="section-description mission-copy">
                            BiLTA exists to ensure that every community can access the Bible
                            and transformational literature in the language they understand best.
                            Through translation projects, literacy training, and digital scripture
                            initiatives, we help preserve language and strengthen faith.
                        </p>

                        <div class="mission-features-grid mt-4">

                            <div class="mission-feature-card">
                                <i class="bi bi-book"></i>
                                <div>
                                    <h5>Bible Translation</h5>
                                    <p>Translation of Scripture into local languages.</p>
                                </div>
                            </div>

                            <div class="mission-feature-card">
                                <i class="bi bi-headphones"></i>
                                <div>
                                    <h5>Audio Scripture</h5>
                                    <p>Accessible Bible resources through audio media.</p>
                                </div>
                            </div>

                            <div class="mission-feature-card">
                                <i class="bi bi-people"></i>
                                <div>
                                    <h5>Community Impact</h5>
                                    <p>Empowering communities through literacy and training.</p>
                                </div>
                            </div>

                        </div>

                        <div class="mission-cta mt-4">
                            <a href="{{ route('about') }}" class="btn btn-outline-theme">
                                Learn More About BiLTA
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- ================= PROJECTS SECTION ================= --}}
    <section class="projects-section py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <span class="section-tag">Our Work</span>

                <h2 class="section-title mt-3">
                    Translation & Literacy Projects
                </h2>

                <p class="section-description mx-auto">
                    Explore some of the impactful initiatives helping communities
                    experience Scripture in their heart language.
                </p>

            </div>

            <div class="row g-4">

                @foreach ($projects as $project)

                    <div class="col-lg-4 col-md-6" data-aos="zoom-in">

                        <div class="project-card h-100">

                            <div class="project-card-body">

                                <span class="project-category">
                                    {{ $project->myCategory->name ?? '--' }}
                                </span>

                                <h4 class="project-title mt-3">
                                    {{ $project->title ?? '--' }}
                                </h4>

                                <p class="project-text">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($project->description ?? ''), 130) }}
                                </p>

                                <a href="{{ route('projects.details', $project) }}"
                                    class="project-link">
                                    Learn More
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

    {{-- ================= LATEST NEWS SECTION ================= --}}
    <section class="latest-news-section py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <span class="section-tag">Latest News</span>

                <h2 class="section-title mt-3">
                    Recent Updates & Stories
                </h2>

                <p class="section-description mx-auto">
                    Stay up to date with BiLTA announcements, progress reports,
                    and ministry highlights.
                </p>

            </div>

            <div class="row g-4">

                @forelse ($latestNews as $newsItem)

                    <div class="col-lg-4 col-md-6" data-aos="fade-up">

                        <div class="news-card h-100">

                            <img src="{{ $newsItem->news_image_url ?? asset('assets/img/placeholder.png') }}"
                                class="news-image"
                                alt="{{ $newsItem->title ?? 'News' }}"
                                loading="lazy">

                            <div class="news-body">

                                <small class="text-muted d-block mb-2">
                                    {{ $newsItem->post_date ?? '--' }}
                                </small>

                                <h5 class="news-title mb-2">
                                    {{ $newsItem->title ?? '--' }}
                                </h5>

                                <p class="news-text mb-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($newsItem->short_description ?? ''), 140) }}
                                </p>

                                <a href="{{ route('news.details', ['news' => $newsItem, 'name' => $newsItem->title]) }}"
                                    class="project-link">
                                    Read News
                                    <i class="bi bi-arrow-right"></i>
                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="col-12">
                        <div class="summary-card text-center">
                            <p class="mb-0">No news updates available yet.</p>
                        </div>
                    </div>

                @endforelse

            </div>

            <div class="text-center mt-4">
                <a href="{{ route('news', '0') }}" class="btn btn-outline-theme">
                    View All News
                </a>
            </div>

        </div>

    </section>

    {{-- ================= CHAIRPERSON MESSAGE ================= --}}
    <section class="chairperson-section py-5">

        <div class="container">

            <div class="row align-items-center g-5">

                <div class="col-lg-4" data-aos="fade-right">

                    <div class="chairperson-profile text-center">

                        @if ($chairmanPhotoUrl)

                            <img src="{{ $chairmanPhotoUrl }}"
                                class="img-fluid rounded-circle shadow-lg chairperson-image"
                                alt="{{ $chairman->name ?? 'Chairperson' }}"
                                loading="lazy">

                        @else

                            <div class="chairperson-avatar-fallback mx-auto">
                                <i class="bi bi-person"></i>
                            </div>

                        @endif

                        <div class="mt-4">
                            <h5 class="mb-1">{{ $chairman->name ?? '--' }}</h5>
                            <p class="mb-0 text-muted">{{ $chairman->title ?? '--' }}</p>
                        </div>

                    </div>

                </div>

                <div class="col-lg-8" data-aos="fade-left">

                    <div class="chairperson-panel">

                        <span class="section-tag">Leadership Message</span>

                        <h2 class="section-title mt-3 mb-3">
                            Message From Our Chairperson
                        </h2>

                        <div class="chairperson-quote-mark">
                            <i class="bi bi-quote"></i>
                        </div>

                        <div class="chairperson-content">
                            {!! $chairman->message ?? '<p>No message available.</p>' !!}
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- ================= TESTIMONIALS ================= --}}
    <section class="testimonials-section py-5 bg-dark text-white">

        <div class="container">

            <div class="text-center mb-5">

                <span class="section-tag" style="background:rgba(205,91,19,.12); color:#cd5b13;">
                    Testimonials
                </span>

                <h2 class="section-title text-white mt-3">
                    Lives Being Impacted
                </h2>

            </div>

            <div class="swiper testimonials-slider">

                <div class="swiper-wrapper">

                    @foreach ($testimonials as $testimonial)

                        <div class="swiper-slide">

                            <div class="testimonial-card">

                                <div class="testimonial-content">

                                    <i class="bi bi-quote quote-icon"></i>

                                    <p>
                                        {{ $testimonial->testimonial ?? '--' }}
                                    </p>

                                </div>

                                <div class="testimonial-author">

                                    <h5>{{ $testimonial->name ?? '--' }}</h5>

                                    <span>{{ $testimonial->title ?? '--' }}</span>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

                <div class="swiper-pagination"></div>

            </div>

        </div>

    </section>

    {{-- ================= TEAM SECTION ================= --}}
    <section id="team" class="team-section py-5">

        <div class="container">

            <div class="text-center mb-5">

                <span class="section-tag">Our Team</span>

                <h2 class="section-title mt-3">
                    Dedicated People Behind the Mission
                </h2>

            </div>

            <div class="row g-4">

                @foreach ($our_teams as $our_team)

                    @php
                        $teamName = $our_team->name ?? '--';
                        $teamInitials = collect(explode(' ', $teamName))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('');
                    @endphp

                    <div class="col-lg-3 col-md-6" data-aos="fade-up">

                        <div class="team-card text-center">

                            <div class="team-initials-fallback" @if($our_team->team_image_url) style="display:none;" @endif>
                                <span>{{ $teamInitials }}</span>
                            </div>

                            @if ($our_team->team_image_url)
                                <img src="{{ $our_team->team_image_url }}"
                                    class="team-image"
                                    alt="{{ $teamName }}"
                                    loading="lazy"
                                    onerror="this.style.display='none';this.previousElementSibling.style.display='flex';">
                            @endif

                            <div class="team-body">

                                <h5>{{ $our_team->name ?? '--' }}</h5>

                                <span>{{ $our_team->position ?? '--' }}</span>

                                <p class="mt-3">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($our_team->details ?? ''), 100) }}
                                </p>

                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

    {{-- ================= CONTACT SECTION ================= --}}
    <section id="contact" class="contact-section py-5 bg-light">

        <div class="container">

            <div class="row g-5">

                <div class="col-lg-5">

                    <span class="section-tag">Get In Touch</span>

                    <h2 class="section-title mt-3">
                        Let’s Connect
                    </h2>

                    <p class="section-description">
                        Reach out to us for partnerships, translation support,
                        volunteering opportunities, or general inquiries.
                    </p>

                    <div class="contact-info mt-4">

                        <div class="contact-item">
                            <i class="bi bi-geo-alt"></i>
                            <div>
                                <h6>Address</h6>
                                <p>{{ $contact_us->address ?? '--' }}</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <div>
                                <h6>Email</h6>
                                <p>{{ $contact_us->email ?? 'infor@bilta.org' }}</p>
                            </div>
                        </div>

                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            <div>
                                <h6>Phone</h6>
                                <p>{{ $contact_us->phone ?? '--' }}</p>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-lg-7">

                    <div class="contact-form-card">

                        @if (session('contact_success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('contact_success') }}
                            </div>
                        @endif

                        @if (session('contact_error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('contact_error') }}
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}"
                            method="POST"
                            class="php-email-form">

                            @csrf

                            {{-- Honeypot: hidden from humans, bots will fill it --}}
                            <div style="position:absolute;left:-9999px;" aria-hidden="true">
                                <input type="text" name="website" tabindex="-1" autocomplete="off">
                            </div>
                            <input type="hidden" name="_form_loaded_at" value="{{ now()->timestamp }}">

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <input type="text"
                                        name="name"
                                        class="form-control form-control-lg"
                                        placeholder="Your Name"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <input type="email"
                                        name="email"
                                        class="form-control form-control-lg"
                                        placeholder="Your Email"
                                        required>
                                </div>

                                <div class="col-12">
                                    <input type="text"
                                        name="subject"
                                        class="form-control form-control-lg"
                                        placeholder="Subject"
                                        required>
                                </div>

                                <div class="col-12">
                                    <textarea name="message"
                                        rows="6"
                                        class="form-control"
                                        placeholder="Your Message"
                                        required></textarea>
                                </div>

                                <div class="col-12">
                                    <button type="submit"
                                        class="btn btn-lg w-100 rounded-pill"
                                        style="background:#cd5b13; color:#fff; border:none;">
                                        Send Message
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </section>

    {{-- ================= SPONSORS ================= --}}
    <section class="sponsors-section py-5">

        <div class="container">

            <div class="text-center mb-5">

                <span class="section-tag">Partners</span>

                <h2 class="section-title mt-3">
                    Trusted Sponsors & Partners
                </h2>

            </div>

            <div class="row justify-content-center g-4">

                @foreach ($sponsors as $sponsor)

                    @php
                        $sponsorName = $sponsor->name ?? '--';
                        $sponsorInitials = collect(explode(' ', $sponsorName))->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->implode('');
                    @endphp

                    <div class="col-6 col-md-3 col-lg-2">

                        <a href="{{ $sponsor->website_url ?? '#' }}"
                            target="_blank"
                            class="sponsor-card">

                            @if ($sponsor->sponsor_image_url)
                                <img src="{{ $sponsor->sponsor_image_url }}"
                                    class="img-fluid"
                                    alt="{{ $sponsorName }}"
                                    loading="lazy">
                            @else
                                <div class="sponsor-initials-fallback">
                                    <span>{{ $sponsorInitials }}</span>
                                </div>
                            @endif

                        </a>

                    </div>

                @endforeach

            </div>

        </div>

    </section>

    <div class="modal fade impact-modal" id="audioModal" tabindex="-1" aria-labelledby="audioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="audioModalLabel">Listen to Audio Bible</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-7">
                            <div class="summary-card">
                                <h6>Audio Scripture Access</h6>
                                <p class="mb-2">Explore available Audio Bible resources and listen in your preferred language.</p>
                                <p class="mb-0">Choose from our curated recordings and start listening right away.</p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="summary-card text-center">
                                <i class="bi bi-headphones" style="font-size:2rem;"></i>
                                <p class="mt-3 mb-3">Open the Audio Bible library to browse and play recordings.</p>
                                <a href="{{ route('audio.bible') }}" class="btn btn-theme w-100">
                                    Open Audio Bible Library
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- =========================
    CUSTOM CSS
========================= --}}

<style>

:root{
    --primary:#000000;
    --secondary:#cd5b13;
    --light:#efefff;
    --text:#445658;
}

body{
    font-family:'Inter',sans-serif;
    color:var(--text);
}

/* Responsive min-vh utility */
@media(min-width:768px){
    .min-vh-md-100{ min-height:100vh; }
}

.hero-section{
    background-size:cover;
    background-position:center;
    position:relative;
    color:white;
    isolation:isolate;
}

.hero-section::before,
.hero-section::after{
    content:'';
    position:absolute;
    border-radius:999px;
    pointer-events:none;
    z-index:0;
    filter:blur(4px);
}

.hero-section::before{
    width:420px;
    height:420px;
    left:-120px;
    top:-140px;
    background:radial-gradient(circle, rgba(30,64,175,.42) 0%, rgba(30,64,175,0) 72%);
}

.hero-section::after{
    width:460px;
    height:460px;
    right:-150px;
    bottom:-180px;
    background:radial-gradient(circle, rgba(37,99,235,.22) 0%, rgba(37,99,235,0) 70%);
}

.hero-section .container{
    z-index:2;
}

.hero-overlay{
    position: absolute;
    inset: 0;
    z-index: 1;

    background:
        radial-gradient(
            circle at 12% 18%,
            rgba(59, 130, 246, .32),
            transparent 42%
        ),

        radial-gradient(
            circle at 86% 16%,
            rgba(96, 165, 250, .26),
            transparent 40%
        ),

        radial-gradient(
            circle at 72% 82%,
            rgba(37, 99, 235, .24),
            transparent 46%
        ),

        linear-gradient(
            115deg,
            rgba(7, 15, 35, .95) 0%,
            rgba(15, 23, 42, .90) 32%,
            rgba(20, 38, 70, .84) 62%,
            rgba(29, 78, 216, .62) 100%
        );

    backdrop-filter: saturate(145%) blur(1px);
}

/* Abstract shapes */
.hero-abstract-shapes{
    position:absolute;
    inset:0;
    z-index:1;
    overflow:hidden;
    pointer-events:none;
}

.hero-shape{
    position:absolute;
    border-radius:50%;
    opacity:0;
    animation: heroShapeFloat 18s ease-in-out infinite;
}

.hero-shape-1{
    width:220px;
    height:220px;
    top:6%;
    right:10%;
    background:rgba(205, 90, 19, 0.016);
    border-radius:50%;
    animation-delay:5s;
    animation-duration:10s;
}

.hero-shape-2{
    width:200px;
    height:200px;
    bottom:12%;
    left:5%;
    border:1px solid rgba(255,255,255,.08);
    animation-delay:3s;
    animation-duration:16s;
}

.hero-shape-3{
    width:140px;
    height:140px;
    top:35%;
    right:15%;
    background:rgba(96,165,250,.08);
    border-radius:50%;
    animation-delay:6s;
    animation-duration:22s;
}

.hero-shape-4{
    width:80px;
    height:80px;
    bottom:25%;
    right:30%;
    border:1.5px solid rgba(205,91,19,.15);
    border-radius:20%;
    animation-delay:2s;
    animation-duration:14s;
}

.hero-shape-5{
    width:260px;
    height:260px;
    top:10%;
    left:50%;
    background:radial-gradient(circle, rgba(59,130,246,.1) 0%, transparent 65%);
    animation-delay:4s;
    animation-duration:24s;
}

.hero-grid-pattern{
    position:absolute;
    inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.025) 1px, transparent 1px);
    background-size:60px 60px;
    mask-image:radial-gradient(ellipse 70% 60% at 70% 50%, black 20%, transparent 70%);
    -webkit-mask-image:radial-gradient(ellipse 70% 60% at 70% 50%, black 20%, transparent 70%);
}

@keyframes heroShapeFloat{
    0%   { opacity:0; transform:translateY(20px) rotate(0deg); }
    15%  { opacity:1; }
    50%  { transform:translateY(-30px) rotate(8deg); }
    85%  { opacity:1; }
    100% { opacity:0; transform:translateY(20px) rotate(0deg); }
}

.hero-title{
    font-size:4rem;
    font-weight:800;
    line-height:1.1;
}

.hero-title span{
    color:var(--secondary);
}

.hero-description{
    font-size:1.15rem;
    line-height:1.9;
    max-width:700px;
    opacity:.95;
}

.hero-badge,
.section-tag{
    display:inline-block;
    background:rgba(205,91,19,.12);
    color:var(--secondary);
    padding:10px 18px;
    border-radius:50px;
    font-weight:600;
    font-size:.9rem;
}

.hero-impact{
    display:flex;
    gap:40px;
    flex-wrap:wrap;
}

.hero-impact-item h3{
    font-size:2rem;
    font-weight:800;
    margin-bottom:5px;
}

.section-title{
    font-size:2.5rem;
    font-weight:800;
    color:var(--primary);
}

.section-description{
    line-height:1.9;
    max-width:750px;
}

.home-services-section{
    background:#f8fafc;
}

.service-home-card{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:22px;
    padding:26px;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
    transition:.3s;
}

.service-home-card:hover{
    transform:translateY(-6px);
    box-shadow:0 16px 36px rgba(15,23,42,.1);
}

.service-home-icon{
    width:54px;
    height:54px;
    border-radius:14px;
    background:rgba(205,91,19,.12);
    color:var(--secondary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.35rem;
    margin-bottom:16px;
}

.service-home-title{
    font-size:1.2rem;
    font-weight:700;
    color:var(--primary);
    margin-bottom:10px;
}

.service-home-text{
    color:var(--text);
    line-height:1.75;
}

.mission-section{
    background:#ffffff;
}

.mission-media-wrap{
    position:relative;
}

.mission-carousel .carousel-inner{
    border-radius:1rem;
}

.mission-image{
    width:100%;
    object-fit:cover;
    min-height:420px;
}

.mission-slide-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(to top, rgba(15,23,42,.48), rgba(15,23,42,.08));
}

.mission-carousel-indicators [data-bs-target]{
    background-color:rgba(255,255,255,.7);
}

.mission-media-badge{
    position:absolute;
    right:18px;
    bottom:18px;
    max-width:320px;
    background:rgba(15,23,42,.92);
    color:#e2e8f0;
    padding:18px 20px;
    border-radius:16px;
    box-shadow:0 14px 34px rgba(2,6,23,.22);
}

.mission-media-badge h5{
    color:#ffffff;
    font-weight:700;
}

.mission-panel{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:24px;
    padding:30px;
    box-shadow:0 12px 30px rgba(15,23,42,.06);
}

.mission-copy{
    max-width:100%;
}

.mission-features-grid{
    display:grid;
    gap:14px;
}

.mission-feature-card{
    display:flex;
    gap:14px;
    align-items:flex-start;
    padding:14px;
    border-radius:16px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
}

.mission-feature-card i{
    width:52px;
    height:52px;
    border-radius:14px;
    background:rgba(205,91,19,.1);
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--secondary);
    font-size:1.3rem;
    flex-shrink:0;
}

.mission-feature-card h5{
    margin:0 0 6px;
    color:var(--primary);
    font-weight:700;
}

.mission-feature-card p{
    margin:0;
    color:var(--text);
    line-height:1.65;
}

.project-card{
    background:white;
    border:1px solid #dbeafe;
    border-radius:24px;
    padding:35px;
    transition:.3s;
    box-shadow:0 10px 35px rgba(15,23,42,.07);
}

.project-card:hover{
    transform:translateY(-8px);
    box-shadow:0 16px 38px rgba(30,64,175,.16);
}

.project-category{
    background:#eff6ff;
    border:1px solid #bfdbfe;
    color:#cd5b13;
    border-radius:50px;
    font-size:.85rem;
    font-weight:600;
    padding:6px 12px;
}

.project-title{
    font-weight:700;
    color:#0f172a;
}

.project-link{
    color:#cd5b13; 
    font-weight:600;
    text-decoration:none;
}

.project-link:hover{
    color:#1d4ed8;
}

.latest-news-section{
    background:#f8fafc;
}

.news-card{
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 10px 35px rgba(0,0,0,.05);
    transition:.3s;
}

.news-card:hover{
    transform:translateY(-6px);
}

.news-image{
    width:100%;
    height:220px;
    object-fit:cover;
}

.news-body{
    padding:24px;
}

.news-title{
    font-weight:700;
    color:var(--primary);
}

.news-text{
    color:var(--text);
    line-height:1.75;
}

.chairperson-section{
    background:#ffffff;
}

.chairperson-profile{
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:24px;
    padding:26px;
    box-shadow:0 12px 30px rgba(15,23,42,.06);
}

.chairperson-image{
    width:320px;
    height:320px;
    object-fit:cover;
    border:6px solid #ffffff;
}

.chairperson-avatar-fallback{
    width:220px;
    height:220px;
    border-radius:999px;
    border:6px solid #ffffff;
    background:#f1f5f9;
    color:#94a3b8;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:4.2rem;
}

.chairperson-panel{
    position:relative;
    background:#ffffff;
    border:1px solid #e2e8f0;
    border-radius:24px;
    padding:34px;
    box-shadow:0 12px 30px rgba(15,23,42,.06);
}

.chairperson-quote-mark{
    width:54px;
    height:54px;
    border-radius:14px;
    background:rgba(205,91,19,.14);
    color:var(--secondary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.6rem;
    margin-bottom:16px;
}

.chairperson-content{
    color:var(--text);
    line-height:1.85;
}

.chairperson-content p:last-child{
    margin-bottom:0;
}

.testimonial-card{
    background:rgba(255,255,255,.08);
    padding:40px;
    border-radius:24px;
    backdrop-filter:blur(10px);
}

.quote-icon{
    font-size:2rem;
    color:var(--secondary);
}

.team-card{
    background:white;
    border-radius:24px;
    overflow:hidden;
    border:1px solid #dbeafe;
    box-shadow:0 10px 35px rgba(0,0,0,.06);
    transition:.3s;
}

.team-card:hover{
    transform:translateY(-6px);
    box-shadow:0 16px 36px rgba(29,78,216,.16);
}

.team-image{
    width:100%;
    height:320px;
    object-fit:cover;
}

.team-body{
    padding:25px;
}

.team-body h5{
    color:#0f172a;
}

.team-body span{
    color:#cd5b13;
}

.contact-form-card{
    background:white;
    padding:40px;
    border-radius:24px;
    box-shadow:0 10px 40px rgba(0,0,0,.05);
}

.contact-item{
    display:flex;
    gap:16px;
    margin-bottom:25px;
}

.contact-item i{
    width:55px;
    height:55px;
    border-radius:16px;
    background:#efefff;
    color:var(--secondary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:1.3rem;
}

.sponsor-card{
    background:white;
    border-radius:20px;
    padding:25px;
    display:flex;
    align-items:center;
    justify-content:center;
    height:130px;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
    transition:.3s;
}

.sponsor-card:hover{
    transform:translateY(-5px);
}

@media(max-width:991px){

    .hero-title{
        font-size:2.7rem;
    }

    .section-title{
        font-size:2rem;
    }

    .mission-image{
        min-height:300px;
    }

    .mission-media-badge{
        position:static;
        margin-top:14px;
        max-width:100%;
    }

    .mission-panel{
        padding:24px;
    }

    .chairperson-image{
        width:260px;
        height:260px;
    }

    .chairperson-panel{
        padding:24px;
    }

}

@media(max-width:576px){

    .hero-title{
        font-size:1.9rem;
    }

    .hero-title span{
        font-size:inherit;
    }

    .hero-impact{
        gap:20px;
    }

    .hero-impact-item h3{
        font-size:1.5rem;
    }

    .section-title{
        font-size:1.6rem;
    }

    .mission-image{
        min-height:200px;
    }

    .chairperson-image{
        width:200px;
        height:200px;
    }

    .chairperson-avatar-fallback{
        width:160px;
        height:160px;
        font-size:3rem;
    }

    .testimonial-card{
        padding:20px;
    }

    .team-image,
    .team-initials-fallback{
        height:220px;
    }

    .team-initials-fallback{
        font-size:2.8rem;
    }

    .contact-form-card{
        padding:20px;
    }

    .contact-item i{
        width:42px;
        height:42px;
        font-size:1.1rem;
    }

    .sponsor-card{
        height:100px;
        padding:16px;
    }

    .news-image{
        height:180px;
    }

    .project-card{
        padding:24px;
    }

    .service-home-card{
        padding:20px;
    }

    .mission-panel{
        padding:18px;
    }

    .mission-feature-card i{
        width:40px;
        height:40px;
        font-size:1.1rem;
    }

}

.team-initials-fallback{
    width:100%;
    height:320px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#0c2340;
    color:rgba(255,255,255,0.85);
    font-size:3.4rem;
    font-weight:700;
    letter-spacing:3px;
    text-transform:uppercase;
    position:relative;
    overflow:hidden;
}

.team-initials-fallback::before{
    content:'';
    position:absolute;
    bottom:-30px;
    right:-30px;
    width:160px;
    height:160px;
    background:rgba(205,91,19,0.15);
    border-radius:50%;
    pointer-events:none;
}

.team-initials-fallback::after{
    content:'';
    position:absolute;
    top:-20px;
    left:-20px;
    width:100px;
    height:100px;
    background:rgba(255,255,255,0.04);
    border-radius:50%;
    pointer-events:none;
}

.sponsor-initials-fallback{
    display:flex;
    align-items:center;
    justify-content:center;
    width:100%;
    height:100%;
    background:linear-gradient(135deg,#f1f5f9,#e2e8f0);
    color:#000000;
    font-size:1.8rem;
    font-weight:800;
    letter-spacing:1px;
    border-radius:12px;
}

</style>

</div>
