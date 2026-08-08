<style>
    :root {
        --sidebar-bg: #1a1d23;
        --sidebar-bg-secondary: #22262e;

        --sidebar-card: rgba(255, 255, 255, 0.04);

        --sidebar-border: rgba(255, 255, 255, 0.06);

        --sidebar-text: #c8cdd5;
        --sidebar-muted: #7c8490;

        --sidebar-accent: #cd5b13;
        --sidebar-accent-light: #e8863e;

        --sidebar-hover: rgba(255, 255, 255, 0.06);
        --sidebar-active: linear-gradient(135deg,
                rgba(205, 91, 19, 0.14),
                rgba(205, 91, 19, 0.05));

        --sidebar-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    /* ===================================
        MAIN SIDEBAR
    ==================================== */

    .admin-sidebar {
        position: relative;

        background:
            linear-gradient(180deg,
                #15171c 0%,
                #1e2028 35%,
                #24272f 60%,
                #1e2028 85%,
                #15171c 100%) !important;

        border-right: 1px solid rgba(255, 255, 255, 0.06);

        box-shadow: var(--sidebar-shadow);

        overflow-x: hidden;
    }

    .admin-sidebar::before {
        content: '';

        position: absolute;
        top: -80px;
        right: -50px;

        width: 180px;
        height: 180px;

        background:
            radial-gradient(circle,
                rgba(255, 255, 255, 0.03),
                transparent 70%);

        pointer-events: none;
    }

    .admin-sidebar::after {
        content: '';
        position: absolute;
        bottom: -60px;
        left: -30px;
        width: 140px;
        height: 140px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.02), transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* ===================================
        BRAND SECTION
    ==================================== */

    .admin-sidebar .sidebar-brand {
        position: relative;

        height: auto;

        padding: 1.2rem 1rem 1rem;

        border-bottom: 1px solid rgba(255, 255, 255, 0.06);

        margin-bottom: .3rem;
    }

    .admin-brand-wrap {
        display: flex;
        align-items: center;
        gap: .85rem;

        width: 100%;
    }

    .admin-brand-logo {
        width: 52px;
        height: 52px;

        object-fit: contain;

        border-radius: 14px;

        background: rgba(255, 255, 255, 0.95);

        padding: .45rem;

        box-shadow:
            0 6px 16px rgba(0, 0, 0, 0.2);
    }

    .admin-brand-title {
        color: #fff;

        font-size: 1rem;

        font-weight: 800;

        letter-spacing: .02em;

        line-height: 1.15;
    }

    .admin-sidebar .sidebar-close-mobile {
        display: none;
        margin-left: auto;
        width: 36px;
        height: 36px;
        border: 1px solid rgba(255, 255, 255, 0.14);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.08);
        color: #e2e8f0;
        align-items: center;
        justify-content: center;
    }

    .admin-brand-subtitle {
        color: #8a909a;

        font-size: .72rem;
        font-weight: 500;

        opacity: .85;
    }

    .admin-role-pill {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        margin-top: .45rem;
        padding: .2rem .55rem;
        border-radius: 999px;
        font-size: .65rem;
        font-weight: 700;
        letter-spacing: .04em;
        text-transform: uppercase;
        border: 1px solid rgba(255, 255, 255, 0.16);
        background: rgba(255, 255, 255, 0.08);
        color: #e2e8f0;
    }

    .admin-role-pill i {
        font-size: .62rem;
    }

    /* ===================================
        DIVIDERS & HEADINGS
    ==================================== */

    .admin-sidebar .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.06);

        margin: .8rem 1rem;
    }

    .admin-sidebar .sidebar-heading {
        color: #6b7280;

        font-size: .68rem;
        font-weight: 800;

        letter-spacing: .14em;

        text-transform: uppercase;

        margin: 1rem 1.1rem .65rem;
    }

    /* ===================================
        NAV ITEMS
    ==================================== */

    .admin-sidebar .nav-item {
        margin-bottom: .18rem;
    }

    .admin-sidebar .nav-item .nav-link {
        position: relative;

        display: flex;
        align-items: center;

        gap: .8rem;

        margin: 0 .75rem;
        padding: .82rem .95rem;

        border-radius: 16px;

        color: var(--sidebar-text);

        font-size: .84rem;
        font-weight: 600;

        transition: all .25s ease;
    }

    .admin-sidebar .nav-item .nav-link i {
        width: 20px;

        text-align: center;

        color: #9ca3af;

        font-size: .9rem;

        transition: all .25s ease;
    }

    .admin-sidebar .nav-item .nav-link span {
        flex: 1;
    }

    .admin-sidebar .menu-arrow {
        color: #7c8490;
        font-size: .72rem;
        transition: transform .2s ease, color .2s ease;
    }

    .admin-sidebar .nav-link[aria-expanded="true"] .menu-arrow {
        transform: rotate(180deg);
        color: #cd5b13;
    }

    /* Hover */

    .admin-sidebar .nav-item .nav-link:hover {
        background: var(--sidebar-hover);

        color: #fff;

        transform: translateX(4px);
    }

    .admin-sidebar .nav-item .nav-link:hover i {
        color: #cd5b13;
    }

    /* Active */

    .admin-sidebar .nav-item.active .nav-link {
        background: var(--sidebar-active);

        color: #fff;

        box-shadow:
            inset 0 0 0 1px rgba(205, 91, 19, 0.12);
    }

    .admin-sidebar .nav-item.active .nav-link::before {
        content: '';

        position: absolute;
        left: -0.75rem;
        top: 10px;

        width: 4px;
        height: calc(100% - 20px);

        border-radius: 999px;

        background: linear-gradient(to bottom,
                var(--sidebar-accent),
                var(--sidebar-accent-light));
    }

    /* ===================================
        COLLAPSE MENUS
    ==================================== */

    .admin-sidebar .collapse-inner {
        position: relative;

        margin: .45rem .8rem .65rem 1rem;
        padding: .55rem;

        border-radius: 18px;

        background:
            linear-gradient(180deg,
                rgba(255, 255, 255, 0.98),
                rgba(248, 250, 252, 0.98));

        box-shadow:
            0 15px 35px rgba(2, 6, 23, 0.16);

        overflow: hidden;
    }

    .admin-sidebar .collapse-inner::before {
        content: '';

        position: absolute;
        top: 0;
        left: 0;

        width: 4px;
        height: 100%;

        background:
            linear-gradient(to bottom,
                var(--sidebar-accent),
                var(--sidebar-accent-light));
    }

    .admin-sidebar .collapse-inner .collapse-item {
        display: flex;
        align-items: center;

        border-radius: 12px;

        padding: .72rem .85rem;

        color: #334155;

        font-size: .79rem;
        font-weight: 600;

        transition: all .2s ease;
    }

    .admin-sidebar .collapse-inner .collapse-item:hover,
    .admin-sidebar .collapse-inner .collapse-item:focus {
        background: #fff3eb;

        color: #cd5b13;

        transform: translateX(4px);
    }

    .admin-sidebar .collapse-inner .collapse-item.active {
        background: rgba(205, 91, 19, 0.10);

        color: #cd5b13;
    }

    .admin-sidebar .collapse-inner .collapse-item i {
        width: 16px;
        margin-right: .35rem;
        color: #94a3b8;
        font-size: .76rem;
        text-align: center;
    }

    .admin-sidebar .collapse-inner .collapse-item.active i,
    .admin-sidebar .collapse-inner .collapse-item:hover i,
    .admin-sidebar .collapse-inner .collapse-item:focus i {
        color: #cd5b13;
    }

    /* ===================================
        QUICK ACTIONS
    ==================================== */

    .admin-sidebar .sidebar-quick-actions {
        margin: 1rem .95rem 0;
    }

    .admin-sidebar .btn-refresh-sidebar {
        width: 100%;

        border-radius: 14px;

        padding: .7rem .9rem;

        font-size: .76rem;
        font-weight: 700;

        border: 1px solid rgba(255, 255, 255, 0.1);

        color: #9ca3af;

        background: rgba(255, 255, 255, 0.04);

        transition: all .25s ease;
    }

    .admin-sidebar .btn-refresh-sidebar:hover {
        background: rgba(255, 255, 255, 0.08);

        color: #fff;

        transform: translateY(-2px);

        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* ===================================
        SIDEBAR TOGGLE
    ==================================== */

    .admin-sidebar #sidebarToggle {
        width: 42px;
        height: 42px;

        background:
            linear-gradient(135deg,
                rgba(255, 255, 255, 0.14),
                rgba(255, 255, 255, 0.08));

        border: 1px solid rgba(255, 255, 255, 0.08);

        transition: all .25s ease;
    }

    .admin-sidebar #sidebarToggle:hover {
        transform: rotate(180deg);

        background:
            linear-gradient(135deg,
                rgba(245, 158, 11, 0.24),
                rgba(251, 191, 36, 0.12));
    }

    /* ===================================
        SCROLLBAR
    ==================================== */

    .admin-sidebar::-webkit-scrollbar {
        width: 8px;
    }

    .admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .admin-sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.12);
        border-radius: 999px;
    }

    /* ===================================
        MOBILE
    ==================================== */

    @media (max-width: 768px) {

        .admin-sidebar .nav-item .nav-link {
            margin: 0 .55rem;
            padding: .72rem .8rem;
            font-size: .82rem;
            border-radius: 12px;
        }

        .admin-sidebar .collapse-inner {
            margin-left: .55rem;
            margin-right: .55rem;
            padding: .45rem;
            border-radius: 14px;
        }

        .admin-sidebar .collapse-inner .collapse-item {
            padding: .65rem .75rem;
            font-size: .78rem;
        }

        .admin-brand-title {
            font-size: .92rem;
        }

        .admin-brand-subtitle {
            font-size: .65rem;
        }

        .admin-brand-logo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
        }

        .admin-sidebar .sidebar-brand {
            padding: 1rem .8rem .8rem;
        }

        .admin-sidebar .sidebar-heading {
            font-size: .62rem;
            margin: .8rem .8rem .5rem;
        }

        .admin-sidebar .sidebar-divider {
            margin: .5rem .8rem;
        }

        .admin-sidebar .sidebar-quick-actions {
            margin: .8rem .6rem 0;
        }

        .admin-sidebar .btn-refresh-sidebar {
            padding: .55rem .75rem;
            font-size: .72rem;
        }

        .admin-sidebar .sidebar-close-mobile {
            display: inline-flex;
        }
    }
</style>

@php
    $isAdminUser = auth()->check() ? auth()->user()->hasRole('admin') : false;
@endphp

<ul class="navbar-nav sidebar sidebar-dark accordion admin-sidebar" id="accordionSidebar">

    <!-- BRAND -->
    <a class="sidebar-brand" href="{{ route('admin.home') }}">
        <div class="admin-brand-wrap">

            <img src="{{ asset('layout/images/bilta_logo_one.png') }}"
                class="admin-brand-logo"
                alt="BiLTA Logo">

            <div>
                <div class="admin-brand-title">
                    BiLTA Admin
                </div>

                <div class="admin-brand-subtitle">
                    Content Management Hub
                </div>

                <div class="admin-role-pill">
                    <i class="fas {{ $isAdminUser ? 'fa-user-shield' : 'fa-user' }}"></i>
                    {{ $isAdminUser ? 'Administrator' : 'Employee Access' }}
                </div>
            </div>

            <button type="button" id="sidebarCloseMobile" class="sidebar-close-mobile" aria-label="Close sidebar">
                <i class="fas fa-times"></i>
            </button>

        </div>
    </a>

    <hr class="sidebar-divider">

    <!-- DASHBOARD -->
    <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- COMPANY -->
    @canany(['manage-home-intro', 'manage-about-us', 'manage-values', 'manage-services', 'manage-contact-us', 'manage-chairman-message', 'manage-sponsors', 'view-emails', 'view-front-requests', 'manage-team'])
    <div class="sidebar-heading">
        Company
    </div>

    <li class="nav-item {{ request()->routeIs('admin.page.intro') || request()->routeIs('admin.company.about-us') || request()->routeIs('admin.company.values') || request()->routeIs('admin.company.services') || request()->routeIs('admin.company.contact-us') || request()->routeIs('admin.page.chairmans.messages') || request()->routeIs('admin.page.our.sponsors') || request()->routeIs('admin.page.contact.emails') || request()->routeIs('admin.page.front.requests') || request()->routeIs('admin.page.our-team') ? 'active' : '' }}">

        <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseCompany"
            aria-expanded="{{ request()->routeIs('admin.page.intro') || request()->routeIs('admin.company.about-us') || request()->routeIs('admin.company.values') || request()->routeIs('admin.company.services') || request()->routeIs('admin.company.contact-us') || request()->routeIs('admin.page.chairmans.messages') || request()->routeIs('admin.page.our.sponsors') || request()->routeIs('admin.page.contact.emails') || request()->routeIs('admin.page.front.requests') || request()->routeIs('admin.page.our-team') ? 'true' : 'false' }}"
            aria-controls="collapseCompany">

            <i class="fas fa-building"></i>
            <span>Company Information</span>
            <i class="fas fa-chevron-down menu-arrow"></i>

        </a>

        <div id="collapseCompany"
            class="collapse {{ request()->routeIs('admin.page.intro') || request()->routeIs('admin.company.about-us') || request()->routeIs('admin.company.values') || request()->routeIs('admin.company.services') || request()->routeIs('admin.company.contact-us') || request()->routeIs('admin.page.chairmans.messages') || request()->routeIs('admin.page.our.sponsors') || request()->routeIs('admin.page.contact.emails') || request()->routeIs('admin.page.front.requests') || request()->routeIs('admin.page.our-team') ? 'show' : '' }}"
            data-parent="#accordionSidebar">

            <div class="collapse-inner">

                @can('manage-home-intro')
                <a class="collapse-item {{ request()->routeIs('admin.page.intro') ? 'active' : '' }}" href="{{ route('admin.page.intro') }}">
                    <i class="fas fa-home"></i>
                    Home Intro
                </a>
                @endcan

                @can('manage-about-us')
                <a class="collapse-item {{ request()->routeIs('admin.company.about-us') ? 'active' : '' }}" href="{{ route('admin.company.about-us') }}">
                    <i class="fas fa-address-card"></i>
                    About Us
                </a>
                @endcan

                @can('manage-values')
                <a class="collapse-item {{ request()->routeIs('admin.company.values') ? 'active' : '' }}" href="{{ route('admin.company.values') }}">
                    <i class="fas fa-gem"></i>
                    Our Values
                </a>
                @endcan

                @can('manage-services')
                <a class="collapse-item {{ request()->routeIs('admin.company.services') ? 'active' : '' }}" href="{{ route('admin.company.services') }}">
                    <i class="fas fa-briefcase"></i>
                    Services
                </a>
                @endcan

                @can('manage-contact-us')
                <a class="collapse-item {{ request()->routeIs('admin.company.contact-us') ? 'active' : '' }}" href="{{ route('admin.company.contact-us') }}">
                    <i class="fas fa-address-book"></i>
                    Contact Us
                </a>
                @endcan

                @can('manage-chairman-message')
                <a class="collapse-item {{ request()->routeIs('admin.page.chairmans.messages') ? 'active' : '' }}" href="{{ route('admin.page.chairmans.messages') }}">
                    <i class="fas fa-comment-dots"></i>
                    Chairman Message
                </a>
                @endcan

                @can('manage-sponsors')
                <a class="collapse-item {{ request()->routeIs('admin.page.our.sponsors') ? 'active' : '' }}" href="{{ route('admin.page.our.sponsors') }}">
                    <i class="fas fa-handshake"></i>
                    Partners
                </a>
                @endcan

                @can('view-emails')
                <a class="collapse-item {{ request()->routeIs('admin.page.contact.emails') ? 'active' : '' }}" href="{{ route('admin.page.contact.emails') }}">
                    <i class="fas fa-envelope-open-text"></i>
                    Email Messages
                </a>
                @endcan

                @can('view-front-requests')
                <a class="collapse-item {{ request()->routeIs('admin.page.front.requests') ? 'active' : '' }}" href="{{ route('admin.page.front.requests') }}">
                    <i class="fas fa-inbox"></i>
                    Front Requests
                </a>
                @endcan

                @can('manage-team')
                <a class="collapse-item {{ request()->routeIs('admin.page.our-team') ? 'active' : '' }}" href="{{ route('admin.page.our-team') }}">
                    <i class="fas fa-user-friends"></i>
                    Our Team
                </a>
                @endcan

            </div>

        </div>

    </li>
    @endcanany

    <!-- CONTENT -->
    @canany(['manage-faqs', 'manage-prayer-points', 'manage-news', 'manage-newsletters', 'manage-testimonies', 'manage-testimonials', 'manage-gallery', 'manage-videos', 'manage-audio', 'manage-projects', 'manage-categories', 'view-analytics'])
    <div class="sidebar-heading">
        Content
    </div>

    <li class="nav-item {{ request()->routeIs('admin.company.faqs') || request()->routeIs('admin.page.weekly-prayer-points') || request()->routeIs('admin.page.item.news') || request()->routeIs('admin.page.item.newsletters') || request()->routeIs('admin.page.testimonies') || request()->routeIs('admin.page.testimonial') || request()->routeIs('admin.page.item.gallery') || request()->routeIs('admin.page.item.videos') || request()->routeIs('admin.page.item.audio') || request()->routeIs('admin.page.item.projects') || request()->routeIs('admin.page.item.category') || request()->routeIs('admin.page.live.analytics.clicks') ? 'active' : '' }}">

        <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapsePages"
            aria-expanded="{{ request()->routeIs('admin.company.faqs') || request()->routeIs('admin.page.weekly-prayer-points') || request()->routeIs('admin.page.item.news') || request()->routeIs('admin.page.item.newsletters') || request()->routeIs('admin.page.testimonies') || request()->routeIs('admin.page.testimonial') || request()->routeIs('admin.page.item.gallery') || request()->routeIs('admin.page.item.videos') || request()->routeIs('admin.page.item.audio') || request()->routeIs('admin.page.item.projects') || request()->routeIs('admin.page.item.projects.map') || request()->routeIs('admin.page.item.category') || request()->routeIs('admin.page.live.analytics.clicks') ? 'true' : 'false' }}"
            aria-controls="collapsePages">

            <i class="fas fa-layer-group"></i>
            <span>Content Pages</span>
            <i class="fas fa-chevron-down menu-arrow"></i>

        </a>

        <div id="collapsePages"
            class="collapse {{ request()->routeIs('admin.company.faqs') || request()->routeIs('admin.page.weekly-prayer-points') || request()->routeIs('admin.page.item.news') || request()->routeIs('admin.page.item.newsletters') || request()->routeIs('admin.page.testimonies') || request()->routeIs('admin.page.testimonial') || request()->routeIs('admin.page.item.gallery') || request()->routeIs('admin.page.item.videos') || request()->routeIs('admin.page.item.audio') || request()->routeIs('admin.page.item.projects') || request()->routeIs('admin.page.item.category') || request()->routeIs('admin.page.live.analytics.clicks') ? 'show' : '' }}"
            data-parent="#accordionSidebar">

            <div class="collapse-inner">

                @can('manage-faqs')
                <a class="collapse-item {{ request()->routeIs('admin.company.faqs') ? 'active' : '' }}" href="{{ route('admin.company.faqs') }}">
                    <i class="fas fa-question-circle"></i>
                    FAQs
                </a>
                @endcan

                @can('manage-prayer-points')
                <a class="collapse-item {{ request()->routeIs('admin.page.weekly-prayer-points') ? 'active' : '' }}" href="{{ route('admin.page.weekly-prayer-points') }}">
                    <i class="fas fa-praying-hands"></i>
                    Prayer Points
                </a>
                @endcan

                @can('manage-news')
                <a class="collapse-item {{ request()->routeIs('admin.page.item.news') ? 'active' : '' }}" href="{{ route('admin.page.item.news') }}">
                    <i class="fas fa-newspaper"></i>
                    News
                </a>
                @endcan

                @can('manage-newsletters')
                <a class="collapse-item {{ request()->routeIs('admin.page.item.newsletters') ? 'active' : '' }}" href="{{ route('admin.page.item.newsletters') }}">
                    <i class="fas fa-paper-plane"></i>
                    Newsletters
                </a>
                @endcan

                @can('manage-testimonies')
                <a class="collapse-item {{ request()->routeIs('admin.page.testimonies') ? 'active' : '' }}" href="{{ route('admin.page.testimonies') }}">
                    <i class="fas fa-comment-alt"></i>
                    Testimonies
                </a>
                @endcan

                @can('manage-testimonials')
                <a class="collapse-item {{ request()->routeIs('admin.page.testimonial') ? 'active' : '' }}" href="{{ route('admin.page.testimonial') }}">
                    <i class="fas fa-quote-right"></i>
                    Short Testimonials
                </a>
                @endcan

                @can('manage-gallery')
                <a class="collapse-item {{ request()->routeIs('admin.page.item.gallery') ? 'active' : '' }}" href="{{ route('admin.page.item.gallery') }}">
                    <i class="fas fa-images"></i>
                    Gallery
                </a>
                @endcan

                @can('manage-videos')
                <a class="collapse-item {{ request()->routeIs('admin.page.item.videos') ? 'active' : '' }}" href="{{ route('admin.page.item.videos') }}">
                    <i class="fas fa-video"></i>
                    Videos
                </a>
                @endcan

                @can('manage-audio')
                <a class="collapse-item {{ request()->routeIs('admin.page.item.audio') ? 'active' : '' }}" href="{{ route('admin.page.item.audio') }}">
                    <i class="fas fa-headphones"></i>
                    Audio
                </a>
                @endcan

                @can('manage-projects')
                <a class="collapse-item {{ request()->routeIs('admin.page.item.projects') ? 'active' : '' }}" href="{{ route('admin.page.item.projects') }}">
                    <i class="fas fa-language"></i>
                    Projects
                </a>
                <a class="collapse-item {{ request()->routeIs('admin.page.item.projects.map') ? 'active' : '' }}" href="{{ route('admin.page.item.projects.map') }}">
                    <i class="fas fa-map-marked-alt"></i> Projects Map
                </a>
                @endcan

                @can('manage-categories')
                <a class="collapse-item {{ request()->routeIs('admin.page.item.category') ? 'active' : '' }}" href="{{ route('admin.page.item.category') }}">
                    <i class="fas fa-tags"></i>
                    Categories
                </a>
                @endcan

                @can('view-analytics')
                <a class="collapse-item {{ request()->routeIs('admin.page.live.analytics.clicks') ? 'active' : '' }}" href="{{ route('admin.page.live.analytics.clicks') }}">
                    <i class="fas fa-chart-line"></i>
                    Analytics
                </a>
                @endcan

            </div>

        </div>

    </li>
    @endcanany

    <!-- DEPARTMENTS -->
    @can('manage-departments')
    <li class="nav-item {{ request()->routeIs('admin.departments') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.departments') }}">
            <i class="fas fa-fw fa-building"></i>
            <span>Departments</span>
        </a>
    </li>
    @endcan

    <!-- INTERNAL COMMUNICATIONS -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Internal
    </div>

    <!-- Announcements (Employee view - all authenticated users) -->
    <li class="nav-item {{ request()->routeIs('employee.announcements') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('employee.announcements') }}">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Announcements</span>
        </a>
    </li>

    <!-- Documents (Employee view - all authenticated users) -->
    <li class="nav-item {{ request()->routeIs('employee.documents') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('employee.documents') }}">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Documents</span>
        </a>
    </li>

    <!-- Announcements Admin -->
    @can('manage-announcements')
    <li class="nav-item {{ request()->routeIs('admin.announcements') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.announcements') }}">
            <i class="fas fa-fw fa-bullhorn"></i>
            <span>Manage Announcements</span>
        </a>
    </li>
    @endcan

    <!-- Documents Admin -->
    @can('manage-documents')
    <li class="nav-item {{ request()->routeIs('admin.documents') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.documents') }}">
            <i class="fas fa-fw fa-archive"></i>
            <span>Manage Documents</span>
        </a>
    </li>
    @endcan

    <!-- LEAVE MANAGEMENT -->
    @canany(['apply-leave', 'manage-leave-types', 'manage-leave-applications', 'manage-leave-balances', 'manage-approval-workflows'])
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Leave Management
    </div>

    <li class="nav-item {{ request()->routeIs('admin.leave.*') ? 'active' : '' }}">

        <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseLeave"
            aria-expanded="{{ request()->routeIs('admin.leave.*') ? 'true' : 'false' }}"
            aria-controls="collapseLeave">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Leave</span>
            <i class="fas fa-chevron-down menu-arrow"></i>
        </a>

        <div id="collapseLeave"
            class="collapse {{ request()->routeIs('admin.leave.*') ? 'show' : '' }}"
            aria-labelledby="headingLeave"
            data-parent="#accordionSidebar">

            <div class="bg-white py-2 collapse-inner rounded">

                @can('apply-leave')
                <a class="collapse-item {{ request()->routeIs('admin.leave.my-applications') ? 'active' : '' }}" href="{{ route('admin.leave.my-applications') }}">
                    <i class="fas fa-user-clock"></i>
                    My Leave
                </a>
                @endcan

                @can('manage-leave-applications')
                <a class="collapse-item {{ request()->routeIs('admin.leave.applications') ? 'active' : '' }}" href="{{ route('admin.leave.applications') }}">
                    <i class="fas fa-clipboard-list"></i>
                    All Applications
                </a>
                @endcan

                @can('manage-leave-types')
                <a class="collapse-item {{ request()->routeIs('admin.leave.types') ? 'active' : '' }}" href="{{ route('admin.leave.types') }}">
                    <i class="fas fa-calendar-week"></i>
                    Leave Types
                </a>
                @endcan

                @can('manage-leave-balances')
                <a class="collapse-item {{ request()->routeIs('admin.leave.balances') ? 'active' : '' }}" href="{{ route('admin.leave.balances') }}">
                    <i class="fas fa-balance-scale"></i>
                    Leave Balances
                </a>
                @endcan

                @can('manage-approval-workflows')
                <a class="collapse-item {{ request()->routeIs('admin.leave.workflows') ? 'active' : '' }}" href="{{ route('admin.leave.workflows') }}">
                    <i class="fas fa-project-diagram"></i>
                    Approval Workflows
                </a>
                @endcan

            </div>

        </div>

    </li>
    @endcanany

    <!-- SYSTEM -->
    @canany(['manage-roles', 'manage-permissions', 'manage-statuses', 'manage-users'])
    <div class="sidebar-heading">
        System
    </div>

    @canany(['manage-roles', 'manage-permissions', 'manage-statuses'])
    <li class="nav-item {{ request()->routeIs('system.roles') || request()->routeIs('system.permissions') || request()->routeIs('system.statuses') ? 'active' : '' }}">

        <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseSettings"
            aria-expanded="{{ request()->routeIs('system.roles') || request()->routeIs('system.permissions') || request()->routeIs('system.statuses') ? 'true' : 'false' }}"
            aria-controls="collapseSettings">

            <i class="fas fa-cogs"></i>
            <span>System Settings</span>
            <i class="fas fa-chevron-down menu-arrow"></i>

        </a>

        <div id="collapseSettings"
            class="collapse {{ request()->routeIs('system.roles') || request()->routeIs('system.permissions') || request()->routeIs('system.statuses') ? 'show' : '' }}"
            data-parent="#accordionSidebar">

            <div class="collapse-inner">

                @can('manage-roles')
                <a class="collapse-item {{ request()->routeIs('system.roles') ? 'active' : '' }}" href="{{ route('system.roles') }}">
                    <i class="fas fa-user-shield"></i>
                    Roles
                </a>
                @endcan

                @can('manage-permissions')
                <a class="collapse-item {{ request()->routeIs('system.permissions') ? 'active' : '' }}" href="{{ route('system.permissions') }}">
                    <i class="fas fa-key"></i>
                    Permissions
                </a>
                @endcan

                @can('manage-statuses')
                <a class="collapse-item {{ request()->routeIs('system.statuses') ? 'active' : '' }}" href="{{ route('system.statuses') }}">
                    <i class="fas fa-toggle-on"></i>
                    Statuses
                </a>
                @endcan

            </div>

        </div>

    </li>
    @endcanany

    <!-- USERS -->
    @can('manage-users')
    <li class="nav-item {{ request()->routeIs('system.users') ? 'active' : '' }}">

        <a class="nav-link" href="{{ route('system.users') }}">

            <i class="fas fa-users-cog"></i>

            <span>User Accounts</span>

        </a>

    </li>
    @endcan
    @endcanany

    <!-- TRAINING CENTER -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Help & Training</div>
    <li class="nav-item {{ request()->routeIs('admin.training') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.training') }}">
            <i class="fas fa-graduation-cap"></i>
            <span>Training Center</span>
        </a>
    </li>

    <hr class="sidebar-divider mt-3">

    <!-- QUICK ACTIONS -->
    <div class="sidebar-quick-actions text-center d-none d-md-block">

        @if (session('success'))
            <div class="alert alert-success py-2 px-2 small mb-2" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger py-2 px-2 small mb-2" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <button class="btn btn-refresh-sidebar mb-2"
            data-toggle="modal"
            data-target="#sideBarPageRefreshModal">

            <i class="fas fa-sync-alt mr-1"></i>

            Refresh System Cache

        </button>

    </div>

    <div class="modal fade" id="sideBarPageRefreshModal" tabindex="-1" role="dialog" aria-labelledby="sideBarPageRefreshModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sideBarPageRefreshModalLabel">Clear System Cache</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-left">
                    This will run <strong>php artisan optimize:clear</strong> and clear cached config, routes, views, and compiled files.
                    <div class="mt-2 text-muted small">Proceed only if you intend to refresh application cache now.</div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('admin.cache.clear') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">Run optimize:clear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TOGGLE -->
    <div class="text-center d-none d-md-inline mb-4">
        <button class="rounded-circle border-0"
            id="sidebarToggle">
        </button>
    </div>

</ul>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('accordionSidebar');
        const closeMobileButton = document.getElementById('sidebarCloseMobile');

        if (!sidebar) {
            return;
        }

        const isMobile = () => window.matchMedia('(max-width: 768px)').matches;

        const closeSidebar = () => {
            document.body.classList.add('sidebar-toggled');
            sidebar.classList.add('toggled');
        };

        const openSidebar = () => {
            document.body.classList.remove('sidebar-toggled');
            sidebar.classList.remove('toggled');
        };

        if (isMobile()) {
            closeSidebar();
        }

        if (closeMobileButton) {
            closeMobileButton.addEventListener('click', function(e) {
                e.preventDefault();
                closeSidebar();
            });
        }

        let wasMobile = isMobile();
        window.addEventListener('resize', function() {
            const nowMobile = isMobile();

            if (!wasMobile && nowMobile) {
                closeSidebar();
            }

            if (wasMobile && !nowMobile) {
                openSidebar();
            }

            wasMobile = nowMobile;
        });
    });
</script>

<style>
    .admin-sidebar {
        background: linear-gradient(180deg, #15171c 0%, #1e2028 35%, #24272f 60%, #1e2028 85%, #15171c 100%) !important;
        border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.2) !important;
    }

    .admin-sidebar::before {
        display: block !important;
    }

    .admin-sidebar .sidebar-brand {
        border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        background: transparent !important;
    }

    .admin-brand-logo {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2) !important;
    }

    .admin-brand-title {
        color: #f9fafb !important;
    }

    .admin-brand-subtitle {
        color: #8a909a !important;
    }

    .admin-sidebar .sidebar-heading {
        color: #6b7280 !important;
    }

    .admin-sidebar .nav-item .nav-link {
        color: #c8cdd5 !important;
        border-radius: 12px !important;
    }

    .admin-sidebar .nav-item .nav-link i {
        color: #9ca3af !important;
    }

    .admin-sidebar .nav-item .nav-link:hover {
        background: rgba(255, 255, 255, 0.06) !important;
        transform: none !important;
    }

    .admin-sidebar .nav-item.active .nav-link {
        background: rgba(205, 91, 19, 0.12) !important;
        box-shadow: none !important;
    }

    .admin-sidebar .nav-item.active .nav-link i {
        color: #cd5b13 !important;
    }

    .admin-sidebar .nav-item.active .nav-link::before {
        background: #cd5b13 !important;
    }

    .admin-sidebar .collapse-inner {
        background: #f8fafc !important;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
    }

    .admin-sidebar .collapse-inner::before {
        background: #cd5b13 !important;
    }

    .admin-sidebar .collapse-inner .collapse-item {
        color: #334155 !important;
    }

    .admin-sidebar .collapse-inner .collapse-item:hover,
    .admin-sidebar .collapse-inner .collapse-item:focus,
    .admin-sidebar .collapse-inner .collapse-item.active {
        background: #fff3eb !important;
        color: #cd5b13 !important;
        transform: none !important;
    }

    .admin-sidebar .btn-refresh-sidebar {
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #9ca3af !important;
        background: rgba(255, 255, 255, 0.04) !important;
    }

    .admin-sidebar .btn-refresh-sidebar:hover {
        background: rgba(255, 255, 255, 0.08) !important;
        color: #fff !important;
        transform: none !important;
        box-shadow: none !important;
    }

    .admin-sidebar #sidebarToggle {
        background: rgba(255, 255, 255, 0.08) !important;
    }

    .admin-sidebar #sidebarToggle:hover {
        transform: none !important;
        background: rgba(255, 255, 255, 0.16) !important;
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            bottom: 0 !important;
            width: min(86vw, 320px) !important;
            max-width: min(86vw, 320px) !important;
            min-height: 100vh !important;
            max-height: 100vh !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch;
            z-index: 1045 !important;
            box-shadow: 0 14px 34px rgba(0, 0, 0, 0.3) !important;
            transform: translateX(0);
            transition: transform .25s ease !important;
            padding-bottom: calc(env(safe-area-inset-bottom, 0px) + .75rem);
        }

        .admin-sidebar.toggled {
            transform: translateX(-105%) !important;
        }

        .admin-sidebar .nav-item .nav-link {
            padding: .85rem .9rem !important;
            font-size: .86rem !important;
            line-height: 1.25;
        }

        .admin-sidebar .collapse-inner .collapse-item {
            padding: .78rem .85rem !important;
            font-size: .82rem !important;
            line-height: 1.25;
        }

        .admin-sidebar .sidebar-brand {
            position: sticky;
            top: 0;
            z-index: 2;
            background: transparent !important;
        }
    }
</style>
