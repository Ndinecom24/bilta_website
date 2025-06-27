<ul class="navbar-nav sidebar sidebar-dark bg-dark accordion " id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center bg-white py-3" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('layout/images/bilta_logo_one.png') }}" style="width: 120px;" alt="BiLTA Logo">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Section: Company Management -->
    <div class="sidebar-heading text-uppercase">Company</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompany"
            aria-expanded="false" aria-controls="collapseCompany">
            <i class="fas fa-building"></i>
            <span>Company Info</span>
        </a>
        <div id="collapseCompany" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.page.intro') }}"><i class="fas fa-home"></i> Home Intro</a>
                <a class="collapse-item" href="{{ route('admin.company.about-us') }}"><i class="fas fa-info-circle"></i> About Us</a>
                <a class="collapse-item" href="{{ route('admin.company.values') }}"><i class="fas fa-bullseye"></i> Our Values</a>
                <a class="collapse-item" href="{{ route('admin.company.services') }}"><i class="fas fa-concierge-bell"></i> Our Services</a>
                <a class="collapse-item" href="{{ route('admin.company.contact-us') }}"><i class="fas fa-phone"></i> Contact Us</a>
                <a class="collapse-item" href="{{ route('admin.page.chairmans.messages') }}"><i class="fas fa-user-tie"></i> Chairman's Message</a>
                <a class="collapse-item" href="{{ route('admin.page.our.sponsors') }}"><i class="fas fa-handshake"></i> Our Sponsors</a>
                <a class="collapse-item" href="{{ route('admin.page.contact.emails') }}"><i class="fas fa-inbox"></i> Email Messages</a>
                <a class="collapse-item" href="{{ route('admin.page.our-team') }}"><i class="fas fa-users"></i> Our Team</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Section: Content Pages -->
    <div class="sidebar-heading text-uppercase">Pages</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="false" aria-controls="collapsePages">
            <i class="fas fa-copy"></i>
            <span>Content Management</span>
        </a>
        <div id="collapsePages" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.company.faqs') }}"><i class="fas fa-question-circle"></i> FAQs</a>
                <a class="collapse-item" href="{{ route('admin.page.weekly-prayer-points') }}"><i class="fas fa-praying-hands"></i> Prayer Points</a>
                <a class="collapse-item" href="{{ route('admin.page.item.news') }}"><i class="fas fa-newspaper"></i> News</a>
                <a class="collapse-item" href="{{ route('admin.page.testimonies') }}"><i class="fas fa-comments"></i> Testimonies</a>
                <a class="collapse-item" href="{{ route('admin.page.testimonial') }}"><i class="fas fa-comment-dots"></i> Testimonial</a>
                <a class="collapse-item" href="{{ route('admin.page.item.gallery') }}"><i class="fas fa-images"></i> Gallery</a>
                <a class="collapse-item" href="{{ route('admin.page.item.videos') }}"><i class="fas fa-video"></i> Videos</a>
                <a class="collapse-item" href="{{ route('admin.page.item.audio') }}"><i class="fas fa-music"></i> Audio</a>
                <a class="collapse-item" href="{{ route('admin.page.item.projects') }}"><i class="fas fa-project-diagram"></i> Projects</a>
                <a class="collapse-item" href="{{ route('admin.page.item.category') }}"><i class="fas fa-tags"></i> Item Categories</a>
                <a class="collapse-item" href="{{ route('admin.page.live.analytics.clicks') }}"><i class="fas fa-tags"></i> Page Clicks</a>

                
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Section: System Settings -->
    <div class="sidebar-heading text-uppercase">Settings</div>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings"
            aria-expanded="false" aria-controls="collapseSettings">
            <i class="fas fa-cogs"></i>
            <span>System Settings</span>
        </a>
        <div id="collapseSettings" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('system.roles') }}"><i class="fas fa-user-tag"></i> Roles</a>
                <a class="collapse-item" href="{{ route('system.permissions') }}"><i class="fas fa-shield-alt"></i> Permissions</a>
                <a class="collapse-item" href="{{ route('system.statuses') }}"><i class="fas fa-toggle-on"></i> Statuses</a>
            </div>
        </div>
    </li>

    <!-- Section: User Management -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
            aria-expanded="false" aria-controls="collapseUsers">
            <i class="fas fa-user-cog"></i>
            <span>User Management</span>
        </a>
        <div id="collapseUsers" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('system.users') }}"><i class="fas fa-users-cog"></i> Users</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider mt-3">

    <!-- Sidebar Actions -->
    <div class="text-center d-none d-md-inline">
        <button class="btn btn-outline-light btn-sm rounded-pill mb-2" data-toggle="modal" data-target="#sideBarPageRefreshModal">
            <i class="fas fa-sync-alt"></i> Refresh Cache
        </button>
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
