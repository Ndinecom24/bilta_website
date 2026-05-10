{{-- =========================================================
    BiLTA MASTER WEBSITE LAYOUT REDESIGN
    Modern • Ministry Focused • Responsive • Professional
========================================================= --}}

<!DOCTYPE html>

@if(auth()->check())

    @include('layouts.admin.master')

@else

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- =========================================================
        META
    ========================================================= --}}
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') | BiLTA
        @else
            BiLTA | Bible & Literature Translation Association
        @endif
    </title>

    <meta name="description"
        content="@hasSection('meta_description')@yield('meta_description')@else BiLTA is dedicated to Bible translation, literacy development, scripture engagement, and making God's Word accessible in local languages.@endif">

    <meta name="keywords"
        content="Bible Translation, Scripture, Audio Bible, Literacy, Christian Ministry, Zambia, BiLTA">

    {{-- Open Graph / Social Media Meta Tags --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@hasSection('title')@yield('title') | BiLTA @else BiLTA | Bible & Literature Translation Association @endif">
    <meta property="og:description" content="@hasSection('meta_description')@yield('meta_description')@else BiLTA is dedicated to Bible translation, literacy development, scripture engagement, and making God's Word accessible in local languages.@endif">
    <meta property="og:image" content="{{ asset('assets/img/favicon.png') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@hasSection('title')@yield('title') | BiLTA @else BiLTA | Bible & Literature Translation Association @endif">
    <meta name="twitter:description" content="@hasSection('meta_description')@yield('meta_description')@else BiLTA is dedicated to Bible translation, literacy development, scripture engagement, and making God's Word accessible in local languages.@endif">
    <meta name="twitter:image" content="{{ asset('assets/img/favicon.png') }}">

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">

    <meta name="google-site-verification"
        content="zEabVLZ5N_dEO0PcCoEhDelHwpDzMbLgc14jLRA1IRE" />

    {{-- =========================================================
        FAVICONS
    ========================================================= --}}
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">

    {{-- =========================================================
        GOOGLE FONTS
    ========================================================= --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    {{-- =========================================================
        VENDOR CSS
    ========================================================= --}}
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    {{-- =========================================================
        MAIN CSS
    ========================================================= --}}
    <link href="{{ asset('assets/css/site-redesign.css') }}" rel="stylesheet">

    {{-- =========================================================
        LIVEWIRE
    ========================================================= --}}
    <livewire:styles />

    {{-- =========================================================
        MODERN MASTER LAYOUT CSS
    ========================================================= --}}
    <style>

        :root{
            --primary:#0f172a;
            --secondary:#f59e0b;
            --secondary-dark:#d97706;
            --light:#f8fafc;
            --text:#475569;
            --muted:#94a3b8;
            --white:#ffffff;
            --border:#e2e8f0;
            --success:#10b981;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Inter',sans-serif;
            color:var(--text);
            background:#ffffff;
            overflow-x:hidden;
        }

        a{
            text-decoration:none;
        }

        /* =========================================================
            TOP BAR
        ========================================================= */

        .topbar{
            background:var(--primary);
            color:#cbd5e1;
            font-size:.9rem;
            padding:10px 0;
        }

        .topbar a{
            color:#cbd5e1;
            transition:.3s;
        }

        .topbar a:hover{
            color:var(--secondary);
        }

        .topbar-info{
            display:flex;
            align-items:center;
            gap:25px;
        }

        .topbar-socials{
            display:flex;
            gap:12px;
        }

        .topbar-socials a{
            width:32px;
            height:32px;
            border-radius:50%;
            background:rgba(255,255,255,.08);
            display:flex;
            align-items:center;
            justify-content:center;
        }

        /* =========================================================
            HEADER
        ========================================================= */

        #header{
            position:sticky;
            top:0;
            z-index:999;
            background:rgba(255,255,255,.96);
            backdrop-filter:blur(10px);
            border-bottom:1px solid rgba(15,23,42,.06);
            transition:.3s ease;
        }

        .site-navbar{
            min-height:90px;
        }

        .site-brand{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .site-brand img{
            width:62px;
            height:62px;
            object-fit:contain;
        }

        .brand-title{
            font-size:1.6rem;
            font-weight:800;
            color:var(--primary);
            line-height:1;
        }

        .brand-title span{
            color:var(--secondary);
        }

        .brand-subtitle{
            font-size:.82rem;
            color:var(--muted);
            margin-top:3px;
        }

        /* =========================================================
            NAVIGATION
        ========================================================= */

        .navbar ul{
            display:flex;
            align-items:center;
            gap:6px;
            list-style:none;
            margin:0;
            padding:0;
        }

        .navbar a{
            color:var(--primary);
            font-weight:600;
            font-size:.95rem;
            padding:12px 16px;
            border-radius:12px;
            transition:.3s ease;
        }

        .navbar a:hover,
        .navbar .active{
            background:#fff7ed;
            color:var(--secondary);
        }

        .dropdown-menu-custom{
            position:absolute;
            background:white;
            min-width:240px;
            border-radius:18px;
            padding:14px;
            box-shadow:0 20px 45px rgba(0,0,0,.08);
            opacity:0;
            visibility:hidden;
            transform:translateY(10px);
            transition:.3s;
        }

        .dropdown:hover .dropdown-menu-custom{
            opacity:1;
            visibility:visible;
            transform:translateY(0);
        }

        /* =========================================================
            CTA BUTTONS
        ========================================================= */

        .btn-theme{
            background:var(--secondary);
            color:white;
            border:none;
            border-radius:14px;
            padding:12px 20px;
            font-weight:700;
            transition:.3s ease;
        }

        .btn-theme:hover{
            background:var(--secondary-dark);
            transform:translateY(-2px);
            color:white;
        }

        .btn-outline-theme{
            border:1px solid #fed7aa;
            background:#fff7ed;
            color:#c2410c;
            border-radius:14px;
            padding:12px 18px;
            font-weight:600;
            transition:.3s;
        }

        .btn-outline-theme:hover{
            background:var(--secondary);
            color:white;
        }

        /* =========================================================
            MOBILE NAV
        ========================================================= */

        .mobile-nav-toggle{
            display:none;
            font-size:1.7rem;
            color:var(--primary);
        }

        /* =========================================================
            MODALS
        ========================================================= */

        .impact-modal .modal-content{
            border:none;
            border-radius:28px;
            overflow:hidden;
            box-shadow:0 30px 80px rgba(0,0,0,.15);
        }

        .impact-modal .modal-header{
            background:
                linear-gradient(
                    135deg,
                    var(--primary),
                    #1e293b
                );
            color:white;
            border:none;
            padding:24px 30px;
        }

        .impact-modal .modal-title{
            font-weight:700;
            font-size:1.25rem;
        }

        .impact-modal .modal-body{
            padding:35px;
            background:#ffffff;
        }

        .summary-card{
            background:#f8fafc;
            border-radius:22px;
            padding:28px;
            height:100%;
            border:1px solid #e2e8f0;
        }

        .summary-card h6{
            font-size:1.1rem;
            font-weight:700;
            margin-bottom:18px;
            color:var(--primary);
        }

        .summary-list{
            list-style:none;
            padding:0;
            margin:0;
        }

        .summary-list li{
            position:relative;
            padding-left:28px;
            margin-bottom:12px;
            color:var(--text);
        }

        .summary-list li::before{
            content:'✓';
            position:absolute;
            left:0;
            color:var(--success);
            font-weight:700;
        }

        /* =========================================================
            COOKIE MODAL
        ========================================================= */

        #cookieConsentModal .modal-content{
            border-radius:24px;
            border:none;
        }

        #cookieConsentModal .nav-tabs .nav-link{
            border:none;
            color:var(--text);
            font-weight:600;
        }

        #cookieConsentModal .nav-tabs .nav-link.active{
            color:var(--secondary);
            border-bottom:2px solid var(--secondary);
        }

        /* =========================================================
            SCROLLBAR
        ========================================================= */

        ::-webkit-scrollbar{
            width:8px;
        }

        ::-webkit-scrollbar-thumb{
            background:#cbd5e1;
            border-radius:50px;
        }

        /* =========================================================
            RESPONSIVE
        ========================================================= */

        @media(max-width:991px){

            .mobile-nav-toggle{
                display:block;
            }

            .navbar ul{
                display:none;
            }

            .topbar{
                display:none;
            }

            .brand-subtitle{
                display:none;
            }

            .site-brand img{
                width:50px;
                height:50px;
            }

            .brand-title{
                font-size:1.3rem;
            }

        }

    </style>

    <style>
    .modern-sidebar {
        background: #fff;
        border-radius: 24px;
        padding: 26px;
        border: 1px solid #f0e2d3;
        box-shadow: 0 12px 35px rgba(44, 22, 8, 0.06);
        position: sticky;
        top: 100px;
        overflow: hidden;
    }

    .modern-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #c9853d, #e2b47e);
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 28px;
    }

    .sidebar-icon {
        width: 56px;
        height: 56px;
        border-radius: 18px;
        background: linear-gradient(135deg, #c9853d, #b7752f);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        box-shadow: 0 10px 25px rgba(201, 133, 61, 0.25);
        flex-shrink: 0;
    }

    .sidebar-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: #2f1d10;
    }

    .sidebar-subtitle {
        font-size: 0.86rem;
        color: #8a7b6d;
    }

    .category-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        padding: 14px 16px;
        border-radius: 18px;
        text-decoration: none;
        background: #fcfaf8;
        border: 1px solid #f3e5d6;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .category-item::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg,
                rgba(201, 133, 61, 0.06),
                rgba(201, 133, 61, 0));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .category-item:hover {
        transform: translateX(5px);
        border-color: #d6a36f;
        box-shadow: 0 10px 24px rgba(44, 22, 8, 0.08);
    }

    .category-item:hover::before {
        opacity: 1;
    }

    .category-content {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
        z-index: 2;
    }

    .category-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c9853d, #e0b17b);
        flex-shrink: 0;
    }

    .category-name {
        color: #3b2a1d;
        font-weight: 600;
        font-size: 0.95rem;
        transition: color 0.3s ease;
    }

    .category-item:hover .category-name {
        color: #a56628;
    }

    .category-count {
        min-width: 34px;
        height: 34px;
        border-radius: 12px;
        background: #fff;
        border: 1px solid #ecd7bf;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        font-weight: 700;
        color: #b7752f;
        position: relative;
        z-index: 2;
        box-shadow: 0 4px 12px rgba(44, 22, 8, 0.05);
    }

    @media (max-width: 991px) {
        .modern-sidebar {
            margin-bottom: 30px;
            position: relative;
            top: unset;
        }
    }
</style>

<style>
    .news-section {
        position: relative;
    }

    .news-card {
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #f1e3d3;
        transition: all 0.35s ease;
        box-shadow: 0 10px 30px rgba(44, 22, 8, 0.06);
        position: relative;
    }

    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 45px rgba(44, 22, 8, 0.14);
    }

    .news-card-image {
        position: relative;
        overflow: hidden;
        height: 240px;
    }

    .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .news-card:hover .news-card-image img {
        transform: scale(1.08);
    }

    .news-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top,
                rgba(0, 0, 0, 0.55),
                rgba(0, 0, 0, 0.05));
    }

    .news-badge {
        position: absolute;
        top: 18px;
        left: 18px;
        background: rgba(255, 255, 255, 0.92);
        color: #8a5a2b;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.4px;
        backdrop-filter: blur(8px);
    }

    .news-card-body {
        padding: 24px;
    }

    .news-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 16px;
        font-size: 13px;
        color: #8b7b6f;
    }

    .news-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .news-meta i {
        color: #c9853d;
    }

    .news-title {
        font-size: 1.2rem;
        font-weight: 700;
        line-height: 1.5;
        color: #2e1c0f;
        margin-bottom: 14px;
    }

    .news-description {
        color: #6d6259;
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 22px;
    }

    .news-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 22px;
        border-radius: 14px;
        background: linear-gradient(135deg, #c9853d, #a76d32);
        color: #fff;
        font-size: 0.92rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 10px 24px rgba(201, 133, 61, 0.25);
    }

    .news-btn:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(201, 133, 61, 0.35);
    }

    .news-empty-state {
        background: #fff;
        border-radius: 24px;
        padding: 70px 30px;
        text-align: center;
        border: 1px dashed #d8c1a8;
    }

    .empty-icon {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f8ead8, #f5ddc2);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #b97835;
        font-size: 2rem;
    }

    .news-empty-state h4 {
        color: #3d2818;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .news-empty-state p {
        color: #7a6d63;
        margin: 0;
    }

    @media (max-width: 768px) {
        .news-card-image {
            height: 220px;
        }

        .news-card-body {
            padding: 20px;
        }

        .news-title {
            font-size: 1.05rem;
        }
    }
</style>

</head>

<body>

    {{-- =========================================================
        CHAT WIDGET
    ========================================================= --}}
    <script id="chatway"
        async="true"
        src="https://cdn.chatway.app/widget.js?id=6OC9P2rVU5pW">
    </script>

    {{-- =========================================================
        TOP BAR
    ========================================================= --}}
    <section class="topbar">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center">

                <div class="topbar-info">

                    <div>
                        <i class="bi bi-envelope me-2"></i>

                        <a href="mailto:{{ $contact_us->email ?? 'infor@bilta.org' }}">
                            {{ $contact_us->email ?? 'infor@bilta.org' }}
                        </a>
                    </div>

                    <div>
                        <i class="bi bi-telephone me-2"></i>

                        {{ $contact_us->phone ?? '--' }}
                    </div>

                </div>

                <div class="topbar-socials">

                    <a href="{{ $contact_us->facebook_url ?? '#' }}">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="{{ $contact_us->linkedin_url ?? '#' }}">
                        <i class="bi bi-linkedin"></i>
                    </a>

                    <a href="{{ $contact_us->youtube ?? '#' }}">
                        <i class="bi bi-youtube"></i>
                    </a>

                </div>

            </div>

        </div>

    </section>

    {{-- =========================================================
        HEADER
    ========================================================= --}}
    <header id="header">

        <div class="container">

            <div class="site-navbar d-flex align-items-center justify-content-between">

                {{-- BRAND --}}
                <a href="{{ route('site.home') }}"
                    class="site-brand">

                    <img src="{{ asset('layout/images/bilta_logo_one.png') }}"
                        alt="BiLTA Logo">

                    <div>

                        <div class="brand-title">
                            Bi<span>LTA</span>
                        </div>

                        <div class="brand-subtitle">
                            Bible & Literature Translation Association
                        </div>

                    </div>

                </a>

                {{-- NAVIGATION --}}
                <nav class="navbar">

                    <ul>

                        <li>
                            <a href="{{ route('site.home') }}">
                                Home
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('about') }}">
                                About
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('services') }}">
                                Services
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('projects', '0') }}">
                                Projects
                            </a>
                        </li>

                        <li class="dropdown position-relative">

                            <a href="#">
                                Resources
                                <i class="bi bi-chevron-down small"></i>
                            </a>

                            <div class="dropdown-menu-custom">

                                <a href="{{ route('gallery') }}"
                                    class="d-block mb-2">
                                    Gallery
                                </a>

                                <a href="{{ route('videos') }}"
                                    class="d-block mb-2">
                                    Videos
                                </a>

                                <a href="{{ route('audio.bible') }}"
                                    class="d-block mb-2">
                                    Audio Bible
                                </a>

                                <a href="{{ route('news', '0') }}"
                                    class="d-block mb-2">
                                    News
                                </a>

                                <a href="{{ route('faqs') }}"
                                    class="d-block">
                                    FAQs
                                </a>

                            </div>

                        </li>

                        <li>
                            <a href="{{ route('site.home') }}#team">
                                Team
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('site.home') }}#contact">
                                Contact
                            </a>
                        </li>

                    </ul>

                </nav>

                {{-- ACTIONS --}}
                <div class="d-flex align-items-center gap-2">

                    <button class="btn btn-outline-theme"
                        data-bs-toggle="modal"
                        data-bs-target="#sponsorModal">

                        Sponsor

                    </button>

                    <button class="btn btn-theme"
                        data-bs-toggle="modal"
                        data-bs-target="#donateModal">

                        <i class="bi bi-heart-fill me-2"></i>
                        Donate

                    </button>

                    <i class="bi bi-list mobile-nav-toggle"></i>

                </div>

            </div>

        </div>

    </header>

    {{-- =========================================================
        PAGE CONTENT
    ========================================================= --}}
    <main>

        @if(isset($slot))

            {{ $slot }}

        @else

            @yield('content')

        @endif

    </main>

    {{-- =========================================================
        MODALS
    ========================================================= --}}

    {{-- DONATION MODAL --}}
    @include('partials.site.donation-modal')

    {{-- SPONSOR MODAL --}}
    @include('partials.site.sponsor-modal')

    {{-- FOOTER --}}
    @include('partials.site.footer')

    {{-- =========================================================
        LIVEWIRE
    ========================================================= --}}
    <livewire:scripts />

    {{-- =========================================================
        VENDOR JS
    ========================================================= --}}
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>

    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    {{-- =========================================================
        APP INIT
    ========================================================= --}}
    <script>

        AOS.init({
            duration:800,
            once:true
        });

    </script>

</body>

</html>

@endif
