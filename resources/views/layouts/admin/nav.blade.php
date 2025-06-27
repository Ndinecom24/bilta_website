<nav class="navbar navbar-expand navbar-dark shadow-sm mb-4 static-top" style="background-color: #b25e1d;">
    <div class="container-fluid">

        <!-- Left: Optional Brand or Home -->
        <a class="navbar-brand font-weight-bold text-white" href="{{ route('admin.home') }}">
            <i class="fas fa-home mr-1"></i> Admin Panel
        </a>

        <!-- Right: Navbar Content -->
        <ul class="navbar-nav ml-auto">

            <!-- Search (Mobile) -->
            <li class="nav-item dropdown d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw text-white"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3 shadow" aria-labelledby="searchDropdown">
                    <form class="form-inline w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                   placeholder="Search..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>

            <!-- Divider -->
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="img-profile rounded-circle mr-2" src="{{ asset('admin/img/undraw_profile.svg') }}" style="width: 36px; height: 36px;">
                    <span class="d-none d-lg-inline text-white small">{{ auth()->user()->name ?? 'User' }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="userDropdown">

                    <a class="dropdown-item" href="{{ route('system.users.show', auth()->user()->id ?? 0) }}"
                       onclick="event.preventDefault(); document.getElementById('user-profile-form{{ auth()->user()->id ?? 0 }}').submit();">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile
                    </a>
                    <form id="user-profile-form{{ auth()->user()->id ?? 0 }}" action="{{ route('system.users.show', auth()->user()->uuid ?? 0) }}" method="POST" class="d-none">
                        @csrf
                    </form>

                    <a class="dropdown-item" href="#">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log
                    </a>

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="{{ route('logout') }}" data-toggle="modal" data-target="#logoutModal"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </li>
        </ul>
    </div>
</nav>
