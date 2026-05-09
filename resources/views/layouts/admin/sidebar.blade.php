<style>
    :root {
        --sidebar-bg: #0b1220;
        --sidebar-bg-secondary: #111827;

        --sidebar-card: rgba(255, 255, 255, 0.05);

        --sidebar-border: rgba(255, 255, 255, 0.08);

        --sidebar-text: #e2e8f0;
        --sidebar-muted: #94a3b8;

        --sidebar-accent: #f59e0b;
        --sidebar-accent-light: #fbbf24;

        --sidebar-hover: rgba(245, 158, 11, 0.14);
        --sidebar-active: linear-gradient(135deg,
                rgba(245, 158, 11, 0.22),
                rgba(251, 191, 36, 0.08));

        --sidebar-shadow: 0 25px 45px rgba(0, 0, 0, 0.18);
    }

    /* ===================================
        MAIN SIDEBAR
    ==================================== */

    .admin-sidebar {
        position: relative;

        background:
            linear-gradient(180deg,
                #020617 0%,
                #0f172a 40%,
                #111827 75%,
                #020617 100%) !important;

        border-right: 1px solid var(--sidebar-border);

        box-shadow: var(--sidebar-shadow);

        overflow-x: hidden;
    }

    .admin-sidebar::before {
        content: '';

        position: absolute;
        top: -120px;
        right: -80px;

        width: 260px;
        height: 260px;

        background:
            radial-gradient(circle,
                rgba(245, 158, 11, 0.18),
                transparent 70%);

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

        border-radius: 16px;

        background: rgba(255, 255, 255, 0.95);

        padding: .45rem;

        box-shadow:
            0 10px 24px rgba(245, 158, 11, 0.18);
    }

    .admin-brand-title {
        color: #fff;

        font-size: 1rem;
        font-weight: 800;

        letter-spacing: .02em;

        line-height: 1.15;
    }

    .admin-brand-subtitle {
        color: #cbd5e1;

        font-size: .72rem;
        font-weight: 500;

        opacity: .85;
    }

    /* ===================================
        DIVIDERS & HEADINGS
    ==================================== */

    .admin-sidebar .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.06);

        margin: .8rem 1rem;
    }

    .admin-sidebar .sidebar-heading {
        color: #64748b;

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

        color: var(--sidebar-accent);

        font-size: .9rem;

        transition: all .25s ease;
    }

    .admin-sidebar .nav-item .nav-link span {
        flex: 1;
    }

    /* Hover */

    .admin-sidebar .nav-item .nav-link:hover {
        background: var(--sidebar-hover);

        color: #fff;

        transform: translateX(4px);
    }

    .admin-sidebar .nav-item .nav-link:hover i {
        color: var(--sidebar-accent-light);
    }

    /* Active */

    .admin-sidebar .nav-item.active .nav-link {
        background: var(--sidebar-active);

        color: #fff;

        box-shadow:
            inset 0 0 0 1px rgba(245, 158, 11, 0.12);
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
        background: #fff7ed;

        color: #b45309;

        transform: translateX(4px);
    }

    .admin-sidebar .collapse-inner .collapse-item.active {
        background: rgba(245, 158, 11, 0.12);

        color: #b45309;
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

        border: 1px solid rgba(245, 158, 11, 0.28);

        color: #fbbf24;

        background: rgba(245, 158, 11, 0.04);

        transition: all .25s ease;
    }

    .admin-sidebar .btn-refresh-sidebar:hover {
        background: rgba(245, 158, 11, 0.16);

        color: #fff;

        transform: translateY(-2px);

        box-shadow:
            0 12px 24px rgba(245, 158, 11, 0.18);
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
        background: rgba(245, 158, 11, 0.25);
        border-radius: 999px;
    }

    /* ===================================
        MOBILE
    ==================================== */

    @media (max-width: 768px) {

        .admin-sidebar .nav-item .nav-link {
            margin: 0 .55rem;
            padding: .75rem .85rem;
        }

        .admin-sidebar .collapse-inner {
            margin-left: .75rem;
        }

        .admin-brand-title {
            font-size: .92rem;
        }
    }
</style>

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
            </div>

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
    <div class="sidebar-heading">
        Company
    </div>

    <li class="nav-item {{ request()->routeIs('admin.page.intro') || request()->routeIs('admin.company.about-us') || request()->routeIs('admin.company.values') || request()->routeIs('admin.company.services') || request()->routeIs('admin.company.contact-us') || request()->routeIs('admin.page.chairmans.messages') || request()->routeIs('admin.page.our.sponsors') || request()->routeIs('admin.page.contact.emails') || request()->routeIs('admin.page.front.requests') || request()->routeIs('admin.page.our-team') ? 'active' : '' }}">

        <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseCompany"
            aria-expanded="true"
            aria-controls="collapseCompany">

            <i class="fas fa-building"></i>
            <span>Company Information</span>

        </a>

        <div id="collapseCompany"
            class="collapse {{ request()->routeIs('admin.page.intro') || request()->routeIs('admin.company.about-us') || request()->routeIs('admin.company.values') || request()->routeIs('admin.company.services') || request()->routeIs('admin.company.contact-us') || request()->routeIs('admin.page.chairmans.messages') || request()->routeIs('admin.page.our.sponsors') || request()->routeIs('admin.page.contact.emails') || request()->routeIs('admin.page.front.requests') || request()->routeIs('admin.page.our-team') ? 'show' : '' }}"
            data-parent="#accordionSidebar">

            <div class="collapse-inner">

                <a class="collapse-item" href="{{ route('admin.page.intro') }}">
                    Home Intro
                </a>

                <a class="collapse-item" href="{{ route('admin.company.about-us') }}">
                    About Us
                </a>

                <a class="collapse-item" href="{{ route('admin.company.values') }}">
                    Our Values
                </a>

                <a class="collapse-item" href="{{ route('admin.company.services') }}">
                    Services
                </a>

                <a class="collapse-item" href="{{ route('admin.company.contact-us') }}">
                    Contact Us
                </a>

                <a class="collapse-item" href="{{ route('admin.page.chairmans.messages') }}">
                    Chairman Message
                </a>

                <a class="collapse-item" href="{{ route('admin.page.our.sponsors') }}">
                    Sponsors
                </a>

                <a class="collapse-item" href="{{ route('admin.page.contact.emails') }}">
                    Email Messages
                </a>

                <a class="collapse-item" href="{{ route('admin.page.front.requests') }}">
                    Front Requests
                </a>

                <a class="collapse-item" href="{{ route('admin.page.our-team') }}">
                    Our Team
                </a>

            </div>

        </div>

    </li>

    <!-- CONTENT -->
    <div class="sidebar-heading">
        Content
    </div>

    <li class="nav-item {{ request()->routeIs('admin.company.faqs') || request()->routeIs('admin.page.weekly-prayer-points') || request()->routeIs('admin.page.item.news') || request()->routeIs('admin.page.testimonies') || request()->routeIs('admin.page.testimonial') || request()->routeIs('admin.page.item.gallery') || request()->routeIs('admin.page.item.videos') || request()->routeIs('admin.page.item.audio') || request()->routeIs('admin.page.item.projects') || request()->routeIs('admin.page.item.category') || request()->routeIs('admin.page.live.analytics.clicks') ? 'active' : '' }}">

        <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapsePages"
            aria-expanded="true"
            aria-controls="collapsePages">

            <i class="fas fa-layer-group"></i>
            <span>Content Pages</span>

        </a>

        <div id="collapsePages"
            class="collapse {{ request()->routeIs('admin.company.faqs') || request()->routeIs('admin.page.weekly-prayer-points') || request()->routeIs('admin.page.item.news') || request()->routeIs('admin.page.testimonies') || request()->routeIs('admin.page.testimonial') || request()->routeIs('admin.page.item.gallery') || request()->routeIs('admin.page.item.videos') || request()->routeIs('admin.page.item.audio') || request()->routeIs('admin.page.item.projects') || request()->routeIs('admin.page.item.category') || request()->routeIs('admin.page.live.analytics.clicks') ? 'show' : '' }}"
            data-parent="#accordionSidebar">

            <div class="collapse-inner">

                <a class="collapse-item" href="{{ route('admin.company.faqs') }}">
                    FAQs
                </a>

                <a class="collapse-item" href="{{ route('admin.page.weekly-prayer-points') }}">
                    Prayer Points
                </a>

                <a class="collapse-item" href="{{ route('admin.page.item.news') }}">
                    News
                </a>

                <a class="collapse-item" href="{{ route('admin.page.testimonies') }}">
                    Testimonies
                </a>

                <a class="collapse-item" href="{{ route('admin.page.testimonial') }}">
                    Short Testimonials
                </a>

                <a class="collapse-item" href="{{ route('admin.page.item.gallery') }}">
                    Gallery
                </a>

                <a class="collapse-item" href="{{ route('admin.page.item.videos') }}">
                    Videos
                </a>

                <a class="collapse-item" href="{{ route('admin.page.item.audio') }}">
                    Audio
                </a>

                <a class="collapse-item" href="{{ route('admin.page.item.projects') }}">
                    Projects
                </a>

                <a class="collapse-item" href="{{ route('admin.page.item.category') }}">
                    Categories
                </a>

                <a class="collapse-item" href="{{ route('admin.page.live.analytics.clicks') }}">
                    Analytics
                </a>

            </div>

        </div>

    </li>

    <!-- SYSTEM -->
    <div class="sidebar-heading">
        System
    </div>

    <li class="nav-item {{ request()->routeIs('system.roles') || request()->routeIs('system.permissions') || request()->routeIs('system.statuses') ? 'active' : '' }}">

        <a class="nav-link collapsed"
            href="#"
            data-toggle="collapse"
            data-target="#collapseSettings"
            aria-expanded="true"
            aria-controls="collapseSettings">

            <i class="fas fa-cogs"></i>
            <span>System Settings</span>

        </a>

        <div id="collapseSettings"
            class="collapse {{ request()->routeIs('system.roles') || request()->routeIs('system.permissions') || request()->routeIs('system.statuses') ? 'show' : '' }}"
            data-parent="#accordionSidebar">

            <div class="collapse-inner">

                <a class="collapse-item" href="{{ route('system.roles') }}">
                    Roles
                </a>

                <a class="collapse-item" href="{{ route('system.permissions') }}">
                    Permissions
                </a>

                <a class="collapse-item" href="{{ route('system.statuses') }}">
                    Statuses
                </a>

            </div>

        </div>

    </li>

    <!-- USERS -->
    <li class="nav-item {{ request()->routeIs('system.users') ? 'active' : '' }}">

        <a class="nav-link" href="{{ route('system.users') }}">

            <i class="fas fa-users-cog"></i>

            <span>Users Management</span>

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

<style>
    .admin-sidebar {
        background: #0f2742 !important;
        border-right: 1px solid rgba(255, 255, 255, 0.06) !important;
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.18) !important;
    }

    .admin-sidebar::before {
        display: none !important;
    }

    .admin-sidebar .sidebar-brand {
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
    }

    .admin-brand-logo {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.16) !important;
    }

    .admin-brand-title {
        color: #f9fafb !important;
    }

    .admin-brand-subtitle {
        color: #b9cbe0 !important;
    }

    .admin-sidebar .sidebar-heading {
        color: #9ab1c9 !important;
    }

    .admin-sidebar .nav-item .nav-link {
        color: #dbe7f2 !important;
        border-radius: 12px !important;
    }

    .admin-sidebar .nav-item .nav-link i {
        color: #e39a4f !important;
    }

    .admin-sidebar .nav-item .nav-link:hover {
        background: rgba(255, 255, 255, 0.12) !important;
        transform: none !important;
    }

    .admin-sidebar .nav-item.active .nav-link {
        background: rgba(227, 154, 79, 0.16) !important;
        box-shadow: none !important;
    }

    .admin-sidebar .nav-item.active .nav-link::before {
        background: #e39a4f !important;
    }

    .admin-sidebar .collapse-inner {
        background: #f8fafc !important;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.1) !important;
    }

    .admin-sidebar .collapse-inner::before {
        background: #e39a4f !important;
    }

    .admin-sidebar .collapse-inner .collapse-item {
        color: #334155 !important;
    }

    .admin-sidebar .collapse-inner .collapse-item:hover,
    .admin-sidebar .collapse-inner .collapse-item:focus,
    .admin-sidebar .collapse-inner .collapse-item.active {
        background: #eef4fa !important;
        color: #1f3f63 !important;
        transform: none !important;
    }

    .admin-sidebar .btn-refresh-sidebar {
        border: 1px solid rgba(227, 154, 79, 0.35) !important;
        color: #f3d1ad !important;
        background: rgba(255, 255, 255, 0.04) !important;
    }

    .admin-sidebar .btn-refresh-sidebar:hover {
        background: rgba(227, 154, 79, 0.18) !important;
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
</style>
