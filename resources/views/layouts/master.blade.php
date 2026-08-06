{{-- =========================================================
    BiLTA MASTER WEBSITE LAYOUT REDESIGN
    Modern • Ministry Focused • Responsive • Professional
========================================================= --}}

<!DOCTYPE html>

@if (auth()->check())

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
            content="@hasSection('meta_description')
@yield('meta_description')
@else
BiLTA is dedicated to Bible translation, literacy development, scripture engagement, and making God's Word accessible in local languages.
@endif">

        <meta name="keywords"
            content="Bible Translation, Scripture, Audio Bible, Literacy, Christian Ministry, Zambia, BiLTA">

        {{-- Open Graph / Social Media Meta Tags --}}
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title"
            content="@hasSection('title')
@yield('title') | BiLTA
@else
BiLTA | Bible & Literature Translation Association
@endif">
        <meta property="og:description"
            content="@hasSection('meta_description')
@yield('meta_description')
@else
BiLTA is dedicated to Bible translation, literacy development, scripture engagement, and making God's Word accessible in local languages.
@endif">
        <meta property="og:image" content="{{ asset('assets/img/favicon.png') }}">

        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title"
            content="@hasSection('title')
@yield('title') | BiLTA
@else
BiLTA | Bible & Literature Translation Association
@endif">
        <meta name="twitter:description"
            content="@hasSection('meta_description')
@yield('meta_description')
@else
BiLTA is dedicated to Bible translation, literacy development, scripture engagement, and making God's Word accessible in local languages.
@endif">
        <meta name="twitter:image" content="{{ asset('assets/img/favicon.png') }}">

        {{-- Canonical URL --}}
        <link rel="canonical" href="{{ url()->current() }}">

        <meta name="google-site-verification" content="zEabVLZ5N_dEO0PcCoEhDelHwpDzMbLgc14jLRA1IRE" />

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

        {{-- Non-critical CSS: load asynchronously --}}
        <link rel="preload" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet"></noscript>

        <link rel="preload" href="{{ asset('assets/vendor/aos/aos.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet"></noscript>

        <link rel="preload" href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet"></noscript>

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
            :root {
                --primary: #000000;
                --secondary: #cd5b13;
                --secondary-dark: #a34810;
                --light: #efefff;
                --text: #445658;
                --muted: #6b7d7f;
                --white: #ffffff;
                --border: #f0f0f0;
                --success: #10b981;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Inter', sans-serif;
                color: var(--text);
                background: #ffffff;
                overflow-x: hidden;
            }

            body.mobile-nav-active {
                overflow: hidden;
            }

            body::after {
                content: '';
                position: fixed;
                inset: 0;
                background: rgba(2, 6, 23, .45);
                opacity: 0;
                visibility: hidden;
                transition: opacity .25s ease, visibility .25s ease;
                z-index: 995;
                pointer-events: none;
            }

            body.mobile-nav-active::after {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }

            a {
                text-decoration: none;
            }

            /* =========================================================
            TOP BAR
        ========================================================= */

            .topbar {
                background: var(--primary);
                color: #cbd5e1;
                font-size: .9rem;
                padding: 10px 0;
            }

            .topbar a {
                color: #cbd5e1;
                transition: .3s;
            }

            .topbar a:hover {
                color: var(--secondary);
            }

            .topbar-info {
                display: flex;
                align-items: center;
                gap: 25px;
            }

            .topbar-socials {
                display: flex;
                gap: 12px;
            }

            .topbar-socials a {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background: rgba(255, 255, 255, .08);
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* =========================================================
            HEADER
        ========================================================= */

            #header {
                position: sticky;
                top: 0;
                z-index: 999;
                background: rgba(255, 255, 255, .96);
                backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(15, 23, 42, .06);
                transition: .3s ease;
            }

            .site-navbar {
                min-height: 90px;
            }

            .site-brand {
                display: flex;
                align-items: center;
                gap: 14px;
            }

            .site-brand img {
                width: 62px;
                height: 62px;
                object-fit: contain;
            }

            .brand-title {
                font-size: 1.6rem;
                font-weight: 800;
                color: var(--primary);
                line-height: 1;
            }

            .brand-title span {
                color: var(--secondary);
            }

            .brand-subtitle {
                font-size: .82rem;
                color: var(--muted);
                margin-top: 3px;
            }

            /* =========================================================
            NAVIGATION
        ========================================================= */

            .navbar ul {
                display: flex;
                align-items: center;
                gap: 6px;
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .navbar {
                position: relative;
            }

            .navbar a {
                color: var(--primary);
                font-weight: 600;
                font-size: .95rem;
                padding: 12px 16px;
                border-radius: 12px;
                transition: .3s ease;
            }

            .navbar a:hover,
            .navbar .active {
                background: #efefff;
                color: var(--secondary);
            }

            .dropdown-menu-custom {
                position: absolute;
                background: white;
                min-width: 240px;
                border-radius: 18px;
                border: 1px solid #f0f0f0;
                padding: 14px;
                box-shadow: 0 20px 45px rgba(0, 0, 0, .08);
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: .3s;
            }

            .dropdown-menu-custom a {
                color: var(--primary);
                font-weight: 600;
                border-radius: 10px;
                padding: 10px 12px;
            }

            .dropdown-menu-custom a:hover {
                background: #efefff;
                color: var(--secondary);
            }

            .dropdown:hover .dropdown-menu-custom {
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }

            /* =========================================================
            CTA BUTTONS
        ========================================================= */

            .btn-theme {
                background: var(--secondary);
                color: white;
                border: none;
                border-radius: 14px;
                padding: 12px 20px;
                font-weight: 700;
                transition: .3s ease;
            }

            .btn-theme:hover {
                background: var(--secondary-dark);
                transform: translateY(-2px);
                color: white;
            }

            .btn-outline-theme {
                border: 1px solid #d8d8ff;
                background: #efefff;
                color: #cd5b13;
                border-radius: 14px;
                padding: 12px 18px;
                font-weight: 600;
                transition: .3s;
            }

            .btn-outline-theme:hover {
                background: var(--secondary);
                color: white;
            }

            /* =========================================================
            MOBILE NAV
        ========================================================= */

            .mobile-nav-toggle {
                display: none;
                font-size: 1.7rem;
                color: var(--primary);
                cursor: pointer;
                border: none;
                background: #efefff;
                width: 42px;
                height: 42px;
                border-radius: 12px;
                align-items: center;
                justify-content: center;
            }

            /* =========================================================
            MODALS
        ========================================================= */

            .impact-modal .modal-content {
                border: none;
                border-radius: 28px;
                overflow: hidden;
                box-shadow: 0 30px 80px rgba(0, 0, 0, .15);
            }

            .impact-modal .modal-header {
                background:
                    linear-gradient(135deg,
                        #f59e0b,
                        #cd5b13);
                color: white;
                border: none;
                padding: 24px 30px;
            }

            .impact-modal .modal-title {
                font-weight: 700;
                font-size: 1.25rem;
            }

            .impact-modal .modal-body {
                padding: 35px;
                background: #ffffff;
            }

            .modal-header-icon {
                width: 48px;
                height: 48px;
                border-radius: 16px;
                background: rgba(255, 255, 255, .2);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem;
                flex-shrink: 0;
            }

            /* Impact Stat Cards */
            .impact-stat-card {
                background: #f8fafc;
                border-radius: 18px;
                padding: 20px 12px;
                border: 1px solid #e2e8f0;
                transition: all .3s ease;
            }

            .impact-stat-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, .08);
                border-color: #cd5b13;
            }

            .impact-stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 12px;
                background: linear-gradient(135deg, #fff3e0, #ffe0b2);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.1rem;
                color: #cd5b13;
                margin-bottom: 10px;
            }

            .impact-stat-number {
                font-size: 1.4rem;
                font-weight: 800;
                color: #0f2742;
                line-height: 1.1;
            }

            .impact-stat-label {
                font-size: .78rem;
                color: #64748b;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .3px;
                margin-top: 4px;
            }

            /* Impact Verse */
            .impact-verse {
                background: #fff;
                border-radius: 14px;
                padding: 16px;
                border-left: 3px solid #cd5b13;
            }

            /* Separator */
            .separator-or {
                display: flex;
                align-items: center;
                gap: 12px;
                color: #94a3b8;
                font-size: .82rem;
                font-weight: 600;
            }

            .separator-or::before,
            .separator-or::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e2e8f0;
            }

            /* Direct Donate Button */
            .btn-donate-direct {
                background: #f8fafc;
                border: 2px dashed #cbd5e1;
                border-radius: 14px;
                padding: 14px 20px;
                color: #0f2742;
                font-weight: 600;
                transition: all .3s ease;
            }

            .btn-donate-direct:hover {
                background: #efefff;
                border-color: #cd5b13;
                color: #cd5b13;
            }

            /* Sponsor Tier Cards */
            .sponsor-tier-card {
                background: #f8fafc;
                border-radius: 18px;
                padding: 22px 16px;
                border: 1px solid #e2e8f0;
                text-align: center;
                transition: all .3s ease;
                position: relative;
                height: 100%;
            }

            .sponsor-tier-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, .1);
                border-color: #cd5b13;
            }

            .sponsor-tier-card.featured {
                background: linear-gradient(145deg, #fffbf5, #fff8f0);
                border-color: #e9a36a;
                box-shadow: 0 6px 20px rgba(205, 91, 19, .1);
            }

            .sponsor-tier-badge {
                position: absolute;
                top: -10px;
                left: 50%;
                transform: translateX(-50%);
                background: linear-gradient(135deg, #f59e0b, #cd5b13);
                color: #fff;
                padding: 3px 14px;
                border-radius: 50px;
                font-size: .7rem;
                font-weight: 700;
                letter-spacing: .3px;
                text-transform: uppercase;
                white-space: nowrap;
            }

            .sponsor-tier-icon {
                width: 48px;
                height: 48px;
                border-radius: 14px;
                background: linear-gradient(135deg, #fff3e0, #ffe0b2);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 1.3rem;
                color: #cd5b13;
                margin-bottom: 12px;
            }

            .sponsor-tier-card h6 {
                font-size: .95rem;
                font-weight: 700;
                color: #0f2742;
                margin-bottom: 8px;
            }

            .sponsor-tier-card p {
                font-size: .82rem;
                color: #64748b;
                margin: 0;
                line-height: 1.4;
            }

            /* Sponsor Contact Items */
            .sponsor-contact-item {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 10px 14px;
                background: #fff;
                border-radius: 14px;
                border: 1px solid #f0f0f0;
            }

            .sponsor-contact-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
                background: #efefff;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #cd5b13;
                flex-shrink: 0;
            }

            .summary-card {
                background: #f8fafc;
                border-radius: 22px;
                padding: 28px;
                height: 100%;
                border: 1px solid #e2e8f0;
            }

            .summary-card h6 {
                font-size: 1.1rem;
                font-weight: 700;
                margin-bottom: 18px;
                color: var(--primary);
            }

            .summary-list {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .summary-list li {
                position: relative;
                padding-left: 28px;
                margin-bottom: 12px;
                color: var(--text);
            }

            .summary-list li::before {
                content: '✓';
                position: absolute;
                left: 0;
                color: var(--success);
                font-weight: 700;
            }

            /* =========================================================
            COOKIE CONSENT BANNER & MODAL
        ========================================================= */

            .cookie-banner {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 9999;
                background: rgba(15, 23, 42, .97);
                backdrop-filter: blur(12px);
                border-top: 1px solid rgba(255, 255, 255, .08);
                padding: 22px 0;
                transition: opacity .3s ease, transform .3s ease;
            }

            .cookie-banner-inner {
                display: flex;
                align-items: center;
                gap: 24px;
                flex-wrap: wrap;
            }

            .cookie-banner-content {
                display: flex;
                align-items: flex-start;
                gap: 16px;
                flex: 1;
                min-width: 0;
            }

            .cookie-banner-icon {
                width: 46px;
                height: 46px;
                border-radius: 14px;
                background: linear-gradient(135deg, #cd5b13, #f59e0b);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 1.2rem;
                flex-shrink: 0;
            }

            .cookie-banner-title {
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
                margin-bottom: 4px;
            }

            .cookie-banner-text {
                color: #94a3b8;
                font-size: .88rem;
                line-height: 1.5;
                margin: 0;
            }

            .cookie-link {
                color: #f59e0b;
                text-decoration: underline;
                font-weight: 600;
            }

            .cookie-link:hover {
                color: #fbbf24;
            }

            .cookie-banner-actions {
                display: flex;
                align-items: center;
                gap: 10px;
                flex-shrink: 0;
            }

            .cookie-btn-accept {
                background: linear-gradient(135deg, #cd5b13, #e9782f);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 12px 22px;
                font-weight: 700;
                font-size: .9rem;
                transition: all .3s ease;
            }

            .cookie-btn-accept:hover {
                background: linear-gradient(135deg, #b14d12, #cd5b13);
                color: #fff;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(205, 91, 19, .3);
            }

            .cookie-btn-reject {
                background: transparent;
                color: #94a3b8;
                border: 1px solid rgba(148, 163, 184, .3);
                border-radius: 12px;
                padding: 12px 20px;
                font-weight: 600;
                font-size: .9rem;
                transition: all .3s ease;
            }

            .cookie-btn-reject:hover {
                color: #fff;
                border-color: rgba(255, 255, 255, .3);
                background: rgba(255, 255, 255, .06);
            }

            .cookie-btn-settings {
                background: rgba(255, 255, 255, .06);
                color: #cbd5e1;
                border: 1px solid rgba(255, 255, 255, .1);
                border-radius: 12px;
                padding: 12px 18px;
                font-weight: 600;
                font-size: .9rem;
                transition: all .3s ease;
            }

            .cookie-btn-settings:hover {
                background: rgba(255, 255, 255, .12);
                color: #fff;
            }

            .cookie-btn-save {
                background: linear-gradient(135deg, #cd5b13, #e9782f);
                color: #fff;
                border: none;
                border-radius: 12px;
                padding: 12px 22px;
                font-weight: 700;
                font-size: .9rem;
                transition: all .3s ease;
            }

            .cookie-btn-save:hover {
                background: linear-gradient(135deg, #b14d12, #cd5b13);
                color: #fff;
                transform: translateY(-2px);
            }

            /* Cookie Preferences Modal */
            .cookie-modal-content {
                border: none;
                border-radius: 24px;
                overflow: hidden;
                box-shadow: 0 30px 80px rgba(0, 0, 0, .2);
            }

            .cookie-modal-header {
                background: linear-gradient(135deg, #0f2742, #1a3a5c);
                color: #fff;
                padding: 22px 28px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .cookie-modal-icon {
                width: 44px;
                height: 44px;
                border-radius: 14px;
                background: rgba(255, 255, 255, .15);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1.2rem;
                flex-shrink: 0;
            }

            .cookie-modal-body {
                padding: 28px;
                background: #fff;
            }

            .cookie-modal-footer {
                padding: 18px 28px;
                background: #f8fafc;
                border-top: 1px solid #e2e8f0;
            }

            /* Cookie Categories */
            .cookie-category {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 18px;
                padding: 22px;
                margin-bottom: 16px;
                transition: border-color .2s ease;
            }

            .cookie-category:hover {
                border-color: #cbd5e1;
            }

            .cookie-category:last-child {
                margin-bottom: 0;
            }

            .cookie-category-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 12px;
            }

            .cookie-category-desc {
                margin-top: 14px;
                font-size: .88rem;
                color: #64748b;
                line-height: 1.6;
                padding-left: 52px;
            }

            .cookie-cat-icon {
                width: 38px;
                height: 38px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
                flex-shrink: 0;
            }

            .cookie-cat-icon.essential {
                background: #e0f2fe;
                color: #0284c7;
            }

            .cookie-cat-icon.analytics {
                background: #fef3c7;
                color: #d97706;
            }

            .cookie-cat-icon.marketing {
                background: #fce7f3;
                color: #db2777;
            }

            .cookie-examples {
                display: flex;
                flex-wrap: wrap;
                gap: 6px;
            }

            .cookie-example-tag {
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 3px 10px;
                font-size: .78rem;
                color: #64748b;
                font-weight: 500;
            }

            /* Toggle Switches */
            .cookie-category .form-check-input {
                width: 48px;
                height: 26px;
                cursor: pointer;
            }

            .cookie-category .form-check-input:checked {
                background-color: #cd5b13;
                border-color: #cd5b13;
            }

            .cookie-category .form-check-input:focus {
                box-shadow: 0 0 0 .2rem rgba(205, 91, 19, .25);
            }

            /* Floating Cookie Button */
            .cookie-floating-btn {
                position: fixed;
                bottom: 24px;
                left: 24px;
                z-index: 990;
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(135deg, #0f2742, #1a3a5c);
                color: #fff;
                border: 2px solid rgba(255, 255, 255, .15);
                font-size: 1.1rem;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                box-shadow: 0 8px 25px rgba(0, 0, 0, .2);
                transition: all .3s ease;
            }

            .cookie-floating-btn:hover {
                transform: scale(1.1);
                background: linear-gradient(135deg, #cd5b13, #e9782f);
                box-shadow: 0 10px 30px rgba(205, 91, 19, .3);
            }

            /* Responsive */
            @media(max-width:768px) {
                .cookie-banner {
                    padding: 16px 0;
                }

                .cookie-banner-inner {
                    flex-direction: column;
                    gap: 16px;
                }

                .cookie-banner-actions {
                    width: 100%;
                    flex-direction: column;
                }

                .cookie-banner-actions .btn {
                    width: 100%;
                }

                .cookie-banner-icon {
                    display: none;
                }

                .cookie-category-desc {
                    padding-left: 0;
                }

                .cookie-modal-body {
                    padding: 18px;
                }

                .cookie-category {
                    padding: 16px;
                }

                .cookie-floating-btn {
                    bottom: 16px;
                    left: 16px;
                    width: 42px;
                    height: 42px;
                    font-size: 1rem;
                }
            }

            /* =========================================================
            SCROLLBAR
        ========================================================= */

            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 50px;
            }

            /* =========================================================
            RESPONSIVE
        ========================================================= */

            @media(max-width:991px) {

                .mobile-nav-toggle {
                    display: inline-flex;
                }

                .site-header-actions .header-cta-desktop {
                    display: none;
                }

                .navbar ul {
                    display: flex;
                    flex-direction: column;
                    position: fixed;
                    top: 0;
                    right: -100%;
                    width: min(88vw, 360px);
                    height: 100vh;
                    background: #ffffff !important;
                    border: 1px solid #f0f0f0;
                    border-radius: 0;
                    box-shadow: -18px 0 45px rgba(2, 6, 23, .12);
                    padding: 82px 14px 18px;
                    z-index: 1001;
                    gap: 6px;
                    overflow-y: auto;
                    transition: right .28s ease;
                }

                .navbar ul.mobile-nav-open {
                    right: 0;
                }

                .navbar ul li {
                    width: 100%;
                }

                .navbar a {
                    display: block;
                    padding: 12px 14px;
                    border-radius: 12px;
                    font-size: .98rem;
                    min-height: 44px;
                }

                .navbar .dropdown>a {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .navbar .dropdown>a i {
                    transition: transform .2s ease;
                }

                .dropdown.mobile-dropdown-open>a i {
                    transform: rotate(180deg);
                }

                .dropdown-menu-custom {
                    position: static;
                    box-shadow: none;
                    border-radius: 12px;
                    padding: 8px;
                    margin-top: 6px;
                    background: #f8fafc !important;
                    border: 1px solid #e5e7eb;
                    transform: none;
                    opacity: 1;
                    visibility: visible;
                    display: none;
                }

                .dropdown-menu-custom a {
                    background: #f8fafc;
                    color: var(--primary);
                    margin-bottom: 2px;
                }

                .dropdown-menu-custom a:hover {
                    background: #efefff;
                    color: var(--secondary);
                }

                .dropdown.mobile-dropdown-open .dropdown-menu-custom {
                    display: block;
                }

                .mobile-nav-cta {
                    margin-top: 10px;
                }

                .mobile-nav-cta .btn {
                    width: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .topbar {
                    display: none;
                }

                .brand-subtitle {
                    display: none;
                }

                .site-brand img {
                    width: 50px;
                    height: 50px;
                }

                .brand-title {
                    font-size: 1.3rem;
                }

            }

            @media(max-width:576px) {

                .btn-outline-theme {
                    display: none;
                }

                .btn-theme {
                    padding: 10px 14px;
                    font-size: .85rem;
                }

                .site-navbar {
                    min-height: 74px;
                }

                .site-brand {
                    gap: 10px;
                    min-width: 0;
                }

                .brand-title {
                    font-size: 1.08rem;
                    line-height: 1.05;
                    white-space: nowrap;
                }

                .mobile-nav-toggle {
                    font-size: 1.95rem;
                    margin-left: 2px;
                }

            }

            /* =========================================================
            MODAL RESPONSIVE
        ========================================================= */

            @media(max-width:768px) {
                .impact-modal .modal-body {
                    padding: 20px;
                }

                .impact-modal .modal-header {
                    padding: 18px 20px;
                }

                .impact-stat-card {
                    padding: 14px 8px;
                }

                .impact-stat-number {
                    font-size: 1.1rem;
                }

                .impact-stat-label {
                    font-size: .7rem;
                }

                .sponsor-tier-card {
                    padding: 16px 12px;
                }

                .sponsor-tier-card p {
                    font-size: .75rem;
                }

                .summary-card {
                    padding: 20px;
                }

                .modal-header-icon {
                    width: 40px;
                    height: 40px;
                    font-size: 1.1rem;
                }
            }

            /* =========================================================
            GLOBAL MOBILE SAFETY
        ========================================================= */

            img,
            svg,
            video,
            canvas,
            iframe {
                max-width: 100%;
                height: auto;
            }

            table {
                width: 100%;
            }

            @media (max-width: 991px) {

                .container,
                .container-fluid {
                    padding-left: 14px;
                    padding-right: 14px;
                }

                .row {
                    margin-left: -8px;
                    margin-right: -8px;
                }

                .row>* {
                    padding-left: 8px;
                    padding-right: 8px;
                    min-width: 0;
                }

                table,
                .table-responsive {
                    display: block;
                    overflow-x: auto;
                    -webkit-overflow-scrolling: touch;
                }
            }

            @media (max-width: 420px) {
                .btn-theme {
                    padding: 8px 11px;
                    font-size: .78rem;
                }

                .site-brand img {
                    width: 44px;
                    height: 44px;
                }

                .brand-title {
                    font-size: .98rem;
                }
            }
        </style>

        <style>
            .modern-sidebar {
                background: #fff;
                border-radius: 24px;
                padding: 26px;
                border: 1px solid #f0f0f0;
                box-shadow: 0 12px 35px rgba(0, 0, 0, 0.06);
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
                background: linear-gradient(to left, rgb(102, 71, 38), #cd5b13);
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
                background: linear-gradient(135deg,
                        #e9782f 0%,
                        #cd5b13 38%,
                        #a34810 72%,
                        #7f3508 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-size: 1.2rem;
                box-shadow: 0 10px 25px rgba(205, 91, 19, 0.25);
                flex-shrink: 0;
            }

            .sidebar-title {
                font-size: 1.15rem;
                font-weight: 700;
                color: #000000;
            }

            .sidebar-subtitle {
                font-size: 0.86rem;
                color: #445658;
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
                background: #efefff;
                border: 1px solid #f0f0f0;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .category-item::before {
                content: '';
                position: absolute;
                inset: 0;
                background: linear-gradient(135deg,
                        rgba(205, 91, 19, 0.06),
                        rgba(205, 91, 19, 0));
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .category-item:hover {
                transform: translateX(5px);
                border-color: #cd5b13;
                box-shadow: 0 10px 24px rgba(0, 0, 0, 0.08);
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
                background: linear-gradient(to left, #f59e0b, #cd5b13);
                flex-shrink: 0;
            }

            .category-name {
                color: #000000;
                font-weight: 600;
                font-size: 0.95rem;
                transition: color 0.3s ease;
            }

            .category-item:hover .category-name {
                color: #cd5b13;
            }

            .category-count {
                min-width: 34px;
                height: 34px;
                border-radius: 12px;
                background: #fff;
                border: 1px solid #f0f0f0;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.82rem;
                font-weight: 700;
                color: #cd5b13;
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
                border: 1px solid #f0f0f0;
                transition: all 0.35s ease;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
                position: relative;
            }

            .news-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 45px rgba(0, 0, 0, 0.14);
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
                color: #cd5b13;
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
                color: #445658;
            }

            .news-meta span {
                display: flex;
                align-items: center;
                gap: 6px;
            }

            .news-meta i {
                color: #cd5b13;
            }

            .news-title {
                font-size: 1.2rem;
                font-weight: 700;
                line-height: 1.5;
                color: #000000;
                margin-bottom: 14px;
            }

            .news-description {
                color: #445658;
                font-size: 0.95rem;
                line-height: 1.7;
                margin-bottom: 22px;
            }

            .news-btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 10px 20px;
                border-radius: 8px;
                background: #cd5b13;
                color: #fff;
                font-size: 0.88rem;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.2s ease;
                border: 1px solid transparent;
            }

            .news-btn:hover {
                color: #fff;
                background: #a34810;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(205, 91, 19, 0.25);
            }

            .news-empty-state {
                background: #fff;
                border-radius: 24px;
                padding: 70px 30px;
                text-align: center;
                border: 1px dashed #c4b8d4;
            }

            .empty-icon {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background: linear-gradient(135deg, #efefff, #d8d8ff);
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 0 auto 20px;
                color: #cd5b13;
                font-size: 2rem;
            }

            .news-empty-state h4 {
                color: #000000;
                margin-bottom: 10px;
                font-weight: 700;
            }

            .news-empty-state p {
                color: #445658;
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
                    <a href="{{ route('site.home') }}" class="site-brand">

                        <img src="{{ asset('layout/images/bilta_logo_one.png') }}" alt="BiLTA Logo">

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

                        <ul id="mainSiteNav">

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
                                    <a href="{{ route('projects.map') }}" class="d-block">
                                        Projects Map
                                    </a>
                                    <a href="{{ route('newsletters') }}" class="d-block mb-2">
                                        Newsletters
                                    </a>
                                    <a href="{{ route('gallery') }}" class="d-block mb-2">
                                        Gallery
                                    </a>

                                    <a href="{{ route('videos') }}" class="d-block mb-2">
                                        Videos
                                    </a>

                                    <a href="{{ route('audio.bible') }}" class="d-block mb-2">
                                        Audio Bible
                                    </a>

                                    <a href="{{ route('news', '0') }}" class="d-block mb-2">
                                        News
                                    </a>

                                    <a href="{{ route('faqs') }}" class="d-block">
                                        FAQs
                                    </a>

                                </div>

                            </li>

                            <li>
                                <a href="{{ route('site.home') }}#contact">
                                    Contact
                                </a>
                            </li>

                            <li class="mobile-nav-cta d-lg-none">
                                <button class="btn btn-outline-theme" data-bs-toggle="modal"
                                    data-bs-target="#sponsorModal">
                                    Sponsor
                                </button>
                            </li>

                            <li class="mobile-nav-cta d-lg-none">
                                <button class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#donateModal">
                                    <i class="bi bi-heart-fill me-2"></i>
                                    Give
                                </button>
                            </li>

                        </ul>

                    </nav>

                    {{-- ACTIONS --}}
                    <div class="d-flex align-items-center gap-2 site-header-actions">

                        <button class="btn btn-outline-theme header-cta-desktop" data-bs-toggle="modal"
                            data-bs-target="#sponsorModal">

                            Sponsor

                        </button>

                        <button class="btn btn-theme header-cta-desktop" data-bs-toggle="modal"
                            data-bs-target="#donateModal">

                            <i class="bi bi-heart-fill me-2"></i>
                            Give

                        </button>

                        <button type="button" class="mobile-nav-toggle" aria-label="Toggle navigation"
                            aria-expanded="false" aria-controls="mainSiteNav">
                            <i class="bi bi-list"></i>
                        </button>

                    </div>

                </div>

            </div>

        </header>

        {{-- =========================================================
        PAGE CONTENT
    ========================================================= --}}
        <main>

            @if (isset($slot))
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

        {{-- COOKIE CONSENT (GDPR / UK PECR) --}}
        @include('partials.site.cookie-consent')

        {{-- =========================================================
        LIVEWIRE
    ========================================================= --}}
        <livewire:scripts />

        {{-- =========================================================
        VENDOR JS
    ========================================================= --}}
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}" defer></script>

        <script src="{{ asset('assets/vendor/aos/aos.js') }}" defer></script>

        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}" defer></script>

        {{-- =========================================================
        APP INIT
    ========================================================= --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                AOS.init({
                    duration: 800,
                    once: true
                });
            });

            // =========================================================
            // MOBILE NAV TOGGLE
            // =========================================================
            (function() {
                const toggle = document.querySelector('.mobile-nav-toggle');
                const navUl = document.querySelector('.navbar ul');

                if (toggle && navUl) {
                    const closeMobileNav = function() {
                        navUl.classList.remove('mobile-nav-open');
                        document.body.classList.remove('mobile-nav-active');
                        document.querySelectorAll('.navbar .dropdown.mobile-dropdown-open').forEach(function(dropdown) {
                            dropdown.classList.remove('mobile-dropdown-open');
                        });
                        toggle.setAttribute('aria-expanded', 'false');
                        const icon = toggle.querySelector('i');
                        if (icon) {
                            icon.classList.add('bi-list');
                            icon.classList.remove('bi-x');
                        }
                    };

                    toggle.addEventListener('click', function() {
                        navUl.classList.toggle('mobile-nav-open');
                        const isOpen = navUl.classList.contains('mobile-nav-open');
                        document.body.classList.toggle('mobile-nav-active', isOpen);
                        this.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                        // Switch hamburger ↔ close icon
                        const icon = this.querySelector('i');
                        if (icon) {
                            icon.classList.toggle('bi-list');
                            icon.classList.toggle('bi-x');
                        }
                    });

                    // Close nav when a link is clicked (but not dropdowns)
                    navUl.querySelectorAll('a').forEach(function(link) {
                        if (!link.closest('.dropdown')) {
                            link.addEventListener('click', function() {
                                closeMobileNav();
                            });
                        }
                    });

                    document.addEventListener('click', function(event) {
                        if (window.innerWidth > 991) return;
                        const clickedInsideNav = event.target.closest('.navbar');
                        const clickedToggle = event.target.closest('.mobile-nav-toggle');
                        if (!clickedInsideNav && !clickedToggle && navUl.classList.contains('mobile-nav-open')) {
                            closeMobileNav();
                        }
                    });

                    window.addEventListener('resize', function() {
                        if (window.innerWidth > 991) {
                            closeMobileNav();
                        }
                    });

                    document.addEventListener('keydown', function(event) {
                        if (event.key === 'Escape' && navUl.classList.contains('mobile-nav-open')) {
                            closeMobileNav();
                        }
                    });
                }

                // Mobile dropdown toggle (touch-friendly)
                document.querySelectorAll('.navbar .dropdown > a').forEach(function(trigger) {
                    trigger.addEventListener('click', function(e) {
                        if (window.innerWidth <= 991) {
                            e.preventDefault();
                            const currentDropdown = this.closest('.dropdown');
                            document.querySelectorAll('.navbar .dropdown.mobile-dropdown-open').forEach(
                                function(dropdown) {
                                    if (dropdown !== currentDropdown) {
                                        dropdown.classList.remove('mobile-dropdown-open');
                                    }
                                });
                            currentDropdown.classList.toggle('mobile-dropdown-open');
                        }
                    });
                });
            })();
        </script>

    </body>

    </html>

@endif
