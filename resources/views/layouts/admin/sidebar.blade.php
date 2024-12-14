<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion toggled" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center bg-white" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon">
            <img style="width: 150px" src="{{ asset('layout/images/bilta_logo_one.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3 text-danger">BiLTA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">Company Management</div>

    <!-- Company Info Links -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCompany" aria-expanded="false" aria-controls="collapseCompany">
            <i class="fas fa-fw fa-building"></i>
            <span>Company Info</span>
        </a>
        <div id="collapseCompany" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Company Info:</h6>
                <a class="collapse-item" href="{{ route('admin.page.intro') }}"><i class="fas fa-home"></i> Home Intro</a>
                <a class="collapse-item" href="{{ route('admin.company.about-us') }}"><i class="fas fa-info-circle"></i> About Us</a>
                <a class="collapse-item" href="{{ route('admin.company.values') }}"><i class="fas fa-bullseye"></i> Our Values</a>
                <a class="collapse-item" href="{{ route('admin.company.services') }}"><i class="fas fa-concierge-bell"></i> Our Services</a>
                <a class="collapse-item" href="{{ route('admin.company.contact-us') }}"><i class="fas fa-phone"></i> Contact Us</a>
                <a class="collapse-item" href="{{ route('admin.page.contact.emails') }}"><i class="fas fa-envelope"></i> Email Messages</a>
                <a class="collapse-item" href="{{ route('admin.page.our-team') }}"><i class="fas fa-users"></i> Our Team</a>

                <h6 class="collapse-header">Additional Pages:</h6>
                <a class="collapse-item" href="{{ route('admin.company.faqs') }}"><i class="fas fa-question-circle"></i> FAQs</a>
                <a class="collapse-item" href="{{ route('admin.page.weekly-prayer-points') }}"><i class="fas fa-praying-hands"></i> Weekly Prayer Points</a>
                <a class="collapse-item" href="{{ route('admin.page.item.news') }}"><i class="fas fa-newspaper"></i> News</a>
                <a class="collapse-item" href="{{ route('admin.page.testimonies') }}"><i class="fas fa-comments"></i> Testimonies</a>
                <a class="collapse-item" href="{{ route('admin.page.testimonial') }}"><i class="fas fa-comment-dots"></i> Testimonial</a>
                <a class="collapse-item" href="{{ route('admin.page.item.gallery') }}"><i class="fas fa-images"></i> Gallery</a>
                <a class="collapse-item" href="{{ route('admin.page.item.videos') }}"><i class="fas fa-video"></i> Videos</a>
                <a class="collapse-item" href="{{ route('admin.page.item.audio') }}"><i class="fas fa-audio"></i> Audio</a>
                <a class="collapse-item" href="{{ route('admin.page.item.projects') }}"><i class="fas fa-project-diagram"></i> Projects</a>
                <a class="collapse-item" href="{{ route('admin.page.item.category') }}"><i class="fas fa-tags"></i> Item Category</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">System Settings</div>

    <!-- Nav Item - Settings -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Settings</span>
        </a>
        <div id="collapseSettings" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">System Permissions:</h6>
                <a class="collapse-item" href="{{ route('system.roles') }}"><i class="fas fa-user-tag"></i> Roles</a>
                <a class="collapse-item" href="{{ route('system.permissions') }}"><i class="fas fa-shield-alt"></i> Permissions</a>
                <a class="collapse-item" href="{{ route('system.statuses') }}"><i class="fas fa-toggle-on"></i> Statuses</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - User Management -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="false" aria-controls="collapseUsers">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>User Management</span>
        </a>
        <div id="collapseUsers" class="collapse" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('system.users') }}"><i class="fas fa-users-cog"></i> Users</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="btn btn-primary rounded-circle border-0" data-toggle="modal" data-target="#sideBarPageRefreshModal">
            <i class="fas fa-sync-alt"></i> 
        </button>
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>


<!-- Modal -->
<div class="modal fade" id="sideBarPageRefreshModal" tabindex="-1" aria-labelledby="sideBarPageRefreshModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="sideBarPageRefreshModalLabel">Cache Refresh</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Click the button below to clear the cache.</p>
          <button id="refreshBtn" class="btn btn-primary" onclick="clearCache()">Refresh</button>
  
          <!-- Spinner -->
          <div id="spinner" class="mt-3" style="display: none;">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden"></span>
            </div>
            <span class="ms-2"></span>
          </div>
  
          <!-- Result Message -->
          <div id="resultMessage" class="mt-3"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function clearCache() {
      // Show spinner
      document.getElementById('spinner').style.display = 'flex';
      document.getElementById('resultMessage').innerHTML = '';
  
      // Send AJAX request to backend
      fetch('/clear-cache', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'  // Ensure CSRF token is included
        }
      })
      .then(response => response.json())
      .then(data => {
        // Hide spinner
        document.getElementById('spinner').style.display = 'none';
  
        // Display result message
        if (data.success) {
          document.getElementById('resultMessage').innerHTML = '<div class="alert alert-success">Cache cleared successfully!</div>';
        } else {
          document.getElementById('resultMessage').innerHTML = '<div class="alert alert-danger">Failed to clear cache. Please try again.</div>';
        }
      })
      .catch(error => {
        document.getElementById('spinner').style.display = 'none';
        document.getElementById('resultMessage').innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
        console.error('Error:', error);
      });
    }
  </script>
  
  
