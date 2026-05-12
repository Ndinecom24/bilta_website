<style>
    :root {
        --topbar-bg: rgba(17, 17, 71, 0.92);
        --topbar-bg-secondary: rgba(26, 26, 107, 0.95);

        --topbar-border: rgba(255, 255, 255, 0.08);

        --topbar-text: #f8fafc;
        --topbar-muted: #cbd5e1;

        --topbar-accent: #c33205;
        --topbar-accent-light: #e04a1f;

        --topbar-hover: rgba(255, 255, 255, 0.08);

        --topbar-shadow:
            0 18px 40px rgba(17, 17, 71, 0.18);

        --topbar-radius: 22px;
    }

    /* ===================================
        MAIN TOPBAR
    ==================================== */

    .admin-topbar {
        position: sticky;
        top: 12px;
        z-index: 100;

        margin: 1rem;

        min-height: 78px;

        padding: .85rem 1.25rem;

        border-radius: var(--topbar-radius);

        background:
            linear-gradient(135deg,
                var(--topbar-bg),
                var(--topbar-bg-secondary));

        border: 1px solid var(--topbar-border);

        box-shadow: var(--topbar-shadow);

        backdrop-filter: blur(14px);

        overflow: hidden;
    }

    .admin-topbar::before {
        content: '';

        position: absolute;
        top: -120px;
        right: -80px;

        width: 260px;
        height: 260px;

        background:
            radial-gradient(circle,
                rgba(245, 158, 11, 0.14),
                transparent 70%);

        pointer-events: none;
    }

    /* ===================================
        MOBILE TOGGLE
    ==================================== */

    #sidebarToggleTop {
        width: 44px;
        height: 44px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 14px;

        background: rgba(255, 255, 255, 0.08);

        transition: all .25s ease;
    }

    #sidebarToggleTop:hover {
        background: rgba(245, 158, 11, 0.16);

        transform: rotate(90deg);
    }

    /* ===================================
        STATUS PILLS
    ==================================== */

    .admin-stat-pill {
        display: inline-flex;
        align-items: center;
        gap: .5rem;

        padding: .55rem .95rem;

        border-radius: 999px;

        background: rgba(255, 255, 255, 0.08);

        border: 1px solid rgba(255, 255, 255, 0.08);

        color: var(--topbar-text);

        font-size: .78rem;
        font-weight: 700;

        backdrop-filter: blur(10px);

        transition: all .25s ease;
    }

    .admin-stat-pill i {
        color: var(--topbar-accent);
    }

    .admin-stat-pill:hover {
        transform: translateY(-2px);

        background: rgba(245, 158, 11, 0.14);
    }

    /* ===================================
        SEARCH BAR
    ==================================== */

    .admin-search-form {
        max-width: 420px;
    }

    .admin-top-search {
        height: 48px !important;

        border-radius: 16px 0 0 16px !important;

        background: rgba(255, 255, 255, 0.08) !important;

        border: 1px solid rgba(255, 255, 255, 0.08) !important;

        color: #fff !important;

        padding-left: 1rem;

        transition: all .25s ease;
    }

    .admin-top-search:focus {
        background: rgba(255, 255, 255, 0.14) !important;

        border-color: rgba(245, 158, 11, 0.22) !important;

        box-shadow:
            0 0 0 4px rgba(245, 158, 11, 0.10) !important;
    }

    .admin-top-search::placeholder {
        color: #cbd5e1;
    }

    .admin-search-btn {
        width: 52px;

        border-radius: 0 16px 16px 0 !important;

        border: 0 !important;

        background:
            linear-gradient(135deg,
                var(--topbar-accent),
                var(--topbar-accent-light));

        color: #fff;

        transition: all .25s ease;
    }

    .admin-search-btn:hover {
        transform: scale(1.02);
    }

    /* ===================================
        TOPBAR LABELS
    ==================================== */

    .topbar-label {
        color: var(--topbar-muted);

        font-size: .8rem;
        font-weight: 600;
    }

    .topbar-divider {
        width: 1px;
        height: 32px;

        background: rgba(255, 255, 255, 0.08);

        margin: 0 1rem;
    }

    /* ===================================
        NAV ITEMS
    ==================================== */

    .admin-topbar .nav-link {
        color: var(--topbar-text) !important;

        transition: all .25s ease;
    }

    .admin-topbar .nav-link:hover {
        color: #fff !important;
    }

    /* ===================================
        PROFILE BUTTON
    ==================================== */

    .admin-user-button {
        display: flex;
        align-items: center;
        gap: .7rem;

        padding: .45rem .7rem;

        border-radius: 16px;

        background: rgba(255, 255, 255, 0.05);

        border: 1px solid rgba(255, 255, 255, 0.06);

        transition: all .25s ease;
    }

    .admin-user-button:hover {
        background: rgba(255, 255, 255, 0.10);

        transform: translateY(-2px);
    }

    .admin-user-button .img-profile {
        width: 42px !important;
        height: 42px !important;

        border: 2px solid rgba(245, 158, 11, 0.45);

        box-shadow:
            0 8px 20px rgba(245, 158, 11, 0.14);

        background: #fff;
    }

    .admin-user-name {
        display: flex;
        flex-direction: column;
        line-height: 1.1;
    }

    .admin-user-name strong {
        color: #fff;
        font-size: .84rem;
    }

    .admin-user-name small {
        color: #cbd5e1;
        font-size: .72rem;
    }

    /* ===================================
        DROPDOWN
    ==================================== */

    .admin-topbar .dropdown-menu {
        margin-top: .85rem;

        border: 1px solid rgba(226, 232, 240, 0.6);

        border-radius: 18px;

        overflow: hidden;

        box-shadow:
            0 20px 40px rgba(15, 23, 42, 0.16);

        padding: .6rem;
    }

    .admin-topbar .dropdown-item {
        display: flex;
        align-items: center;

        border-radius: 12px;

        padding: .8rem .95rem;

        font-size: .84rem;
        font-weight: 600;

        transition: all .2s ease;
    }

    .admin-topbar .dropdown-item i {
        width: 20px;
    }

    .admin-topbar .dropdown-item:hover {
        background: rgba(195, 50, 5, 0.08);

        color: #9a2804;

        transform: translateX(4px);
    }

    /* ===================================
        SEARCH DROPDOWN MOBILE
    ==================================== */

    .admin-mobile-search {
        border-radius: 18px;

        background: #fff;

        border: 1px solid rgba(226, 232, 240, 0.7);

        box-shadow:
            0 20px 40px rgba(15, 23, 42, 0.12);
    }

    /* ===================================
        RESPONSIVE
    ==================================== */

    @media (max-width: 992px) {

        .admin-topbar {
            margin: .75rem;
            padding: .75rem 1rem;
        }

        .admin-search-form {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {

        .admin-topbar {
            min-height: auto;
            border-radius: 18px;
        }

        .admin-user-name {
            display: none;
        }

        .topbar-divider {
            display: none;
        }

        .admin-user-button {
            padding: .3rem .5rem !important;
        }

        .admin-user-button .img-profile {
            width: 34px;
            height: 34px;
        }

        .admin-topbar .dropdown-menu {
            position: fixed !important;
            top: auto !important;
            bottom: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            border-radius: 18px 18px 0 0 !important;
            box-shadow: 0 -10px 40px rgba(0,0,0,.15) !important;
            transform: none !important;
        }
    }

    @media (max-width: 576px) {

        .admin-topbar {
            border-radius: 14px;
            padding: .5rem .65rem;
        }

        #sidebarToggleTop {
            width: 38px;
            height: 38px;
            border-radius: 10px;
        }

        .navbar-nav .nav-link {
            padding: .4rem .5rem;
        }

        .admin-mobile-search {
            left: .5rem !important;
            right: .5rem !important;
            width: auto !important;
        }
    }
</style>



<nav class="navbar navbar-expand admin-topbar static-top">

    <!-- MOBILE SIDEBAR TOGGLE -->
    <button id="sidebarToggleTop"
        class="btn btn-link d-md-none mr-2">

        <i class="fa fa-bars text-white"></i>

    </button>

    <!-- STATUS PILLS -->
    <div class="d-none d-md-flex align-items-center mr-4">

        <span class="admin-stat-pill mr-2">
            <i class="fas fa-globe-africa"></i>
            BiLTA CMS
        </span>

        <span class="admin-stat-pill">
            <i class="fas fa-layer-group"></i>
            Admin Workspace
        </span>

    </div>

    <!-- SEARCH -->
    <form class="d-none d-sm-inline-block form-inline mr-auto w-100 admin-search-form">

        <div class="input-group">

            <input type="text"
                class="form-control admin-top-search border-0 small"
                placeholder="Search pages, content, users..."
                aria-label="Search">

            <div class="input-group-append">

                <button class="btn admin-search-btn"
                    type="button">

                    <i class="fas fa-search fa-sm"></i>

                </button>

            </div>

        </div>

    </form>

    <!-- RIGHT NAV -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- MOBILE SEARCH -->
        <li class="nav-item dropdown d-sm-none">

            <button class="nav-link dropdown-toggle btn btn-link"
                id="searchDropdown"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                type="button">

                <i class="fas fa-search fa-fw"></i>

            </button>

            <div class="dropdown-menu dropdown-menu-right p-3 admin-mobile-search"
                aria-labelledby="searchDropdown">

                <form class="form-inline mr-auto w-100">

                    <div class="input-group">

                        <input type="text"
                            class="form-control bg-light border-0 small"
                            placeholder="Search..."
                            aria-label="Search">

                        <div class="input-group-append">

                            <button class="btn btn-primary"
                                type="button">

                                <i class="fas fa-search fa-sm"></i>

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </li>

        <!-- DATE -->
        <li class="nav-item mx-2 d-none d-lg-block">

            <span class="topbar-label">

                <i class="fas fa-calendar-alt mr-1"></i>

                {{ now()->format('l, d M Y') }}

            </span>

        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- USER -->
        <li class="nav-item dropdown">

            <button class="nav-link dropdown-toggle btn btn-link admin-user-button"
                id="userDropdown"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                type="button">

                <img class="img-profile rounded-circle"
                    src="{{ asset('admin/img/undraw_profile.svg') }}"
                    alt="Profile">

                <div class="admin-user-name d-none d-lg-flex">

                    <strong>
                        {{ auth()->user()->name ?? 'User' }}
                    </strong>

                    <small>
                        Administrator
                    </small>

                </div>

            </button>

            <!-- DROPDOWN -->
            <div class="dropdown-menu dropdown-menu-right animated--fade-in"
                aria-labelledby="userDropdown">

                <a class="dropdown-item"
                    href="#"
                    onclick="event.preventDefault(); document.getElementById('user-profile-form').submit();">

                    <i class="fas fa-user text-warning mr-2"></i>

                    My Profile

                </a>

                <form id="user-profile-form"
                    action="{{ route('system.users.show', auth()->user()->uuid ?? 0) }}"
                    method="POST"
                    class="d-none">

                    @csrf

                </form>

                <a class="dropdown-item"
                    href="{{ route('admin.home') }}">

                    <i class="fas fa-home text-primary mr-2"></i>

                    Dashboard

                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item text-danger"
                    href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                    <i class="fas fa-sign-out-alt mr-2"></i>

                    Logout

                </a>

                <form id="logout-form"
                    action="{{ route('logout') }}"
                    method="POST"
                    class="d-none">

                    @csrf

                </form>

            </div>

        </li>

    </ul>

</nav>

<style>
    .admin-topbar {
        background: #ffffff !important;
        border: 1px solid #d7e3ef !important;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.07) !important;
        backdrop-filter: none !important;
        overflow: visible !important;
    }

    .admin-topbar::before {
        display: none !important;
    }

    #sidebarToggleTop {
        background: #f3f4f6 !important;
    }

    #sidebarToggleTop:hover {
        background: #e5e7eb !important;
        transform: none !important;
    }

    #sidebarToggleTop i {
        color: #475569 !important;
    }

    .admin-stat-pill {
        background: #f7fafd !important;
        border: 1px solid #d8e4ef !important;
        color: #111147 !important;
    }

    .admin-stat-pill i {
        color: #c33205 !important;
    }

    .admin-stat-pill:hover {
        background: #f1f5f9 !important;
        transform: none !important;
    }

    .admin-top-search {
        background: #ffffff !important;
        border: 1px solid #d8e4ef !important;
        color: #111147 !important;
    }

    .admin-top-search:focus {
        border-color: #8888b8 !important;
        box-shadow: 0 0 0 3px rgba(17, 17, 71, 0.15) !important;
    }

    .admin-top-search::placeholder {
        color: #94a3b8 !important;
    }

    .admin-search-btn {
        background: #c33205 !important;
        color: #fff !important;
    }

    .admin-search-btn:hover {
        background: #9a2804 !important;
        transform: none !important;
    }

    .topbar-label,
    .admin-topbar .nav-link,
    .admin-user-name strong {
        color: #111147 !important;
    }

    .admin-user-name small {
        color: #6d86a0 !important;
    }

    .topbar-divider {
        background: #dbe7f2 !important;
    }

    .admin-user-button {
        background: #f8fbff !important;
        border: 1px solid #dbe7f2 !important;
    }

    .admin-user-button:hover {
        background: #f2f7fc !important;
        transform: none !important;
    }

    .admin-user-button .img-profile {
        border-color: #d7e3ef !important;
        box-shadow: 0 4px 10px rgba(15, 23, 42, 0.08) !important;
    }

    .admin-mobile-search {
        border: 1px solid #dbe3eb !important;
        border-radius: 14px !important;
    }

    .admin-topbar .dropdown-menu {
        z-index: 1200 !important;
    }
</style>

