<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center bg-white" href="{{route('admin.home')}}">
        <div class="sidebar-brand-icon ">
            <img style="width: 150px" src="{{asset('layout/images/bilta_logo_one.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3 text-danger">BiLTA <sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>


    <!-- Nav Item - company Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompany"
           aria-expanded="true" aria-controls="collapseCompany">
            <i class="fas fa-fw fa-wrench"></i>
            <span>General Details</span>
        </a>
        <div id="collapseCompany" class="collapse" aria-labelledby="headingCompany"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Company Details:</h6>
                <a class="collapse-item" href="{{route('admin.page.intro')}}">Home Intro</a>
                <a class="collapse-item" href="{{route('admin.company.about-us')}}">About Us</a>
                <a class="collapse-item" href="{{route('admin.company.values')}}">Our Values</a>
                <a class="collapse-item" href="{{route('admin.company.services')}}">Our Services</a>
                <a class="collapse-item" href="{{route('admin.company.contact-us')}}">Contact Us</a>
                <a class="collapse-item" href="{{route('admin.page.our-team')}}">Our Team</a>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="{{route('admin.company.faqs')}}">FAQs</a>
                <a class="collapse-item" href="{{route('admin.page.weekly-prayer-points')}}">Weekly Prayer Points</a>
                <a class="collapse-item" href="{{route('admin.page.item.news')}}">News</a>
                <a class="collapse-item" href="{{route('admin.page.testimonies')}}">Testimonies</a>
                <a class="collapse-item" href="{{route('admin.page.testimonial')}}">Testimonial</a>
                <a class="collapse-item" href="{{route('admin.page.item.gallery')}}">Gallery</a>
                <a class="collapse-item" href="{{route('admin.page.item.videos')}}">Videos</a>
                <a class="collapse-item" href="{{route('admin.page.item.projects')}}">Projects</a>
                <a class="collapse-item" href="{{route('admin.page.item.category')}}">Item Category</a>
            </div>
        </div>
    </li>



    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        System
    </div>



    <!-- Nav Item - settings Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Settings</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">System Permissions:</h6>
                <a class="collapse-item" href="{{route('system.roles')}}">Roles</a>
                <a class="collapse-item" href="{{route('system.permissions')}}">Permissions</a>
                <a class="collapse-item" href="{{route('system.statuses')}}">Statuses</a>
            </div>
        </div>
    </li>


    <!-- Nav Item - users Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
           aria-expanded="true" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>User Management</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers"
             data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('system.users')}}">Users</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>


</ul>
