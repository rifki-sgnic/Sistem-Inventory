<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->user()->name }} ({{ auth()->user()->roles->pluck('name')->first() }})</span>
        {{-- <figure class="img-profile rounded-circle avatar font-weight-bold" data-initial=""><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i></figure> --}}
        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        {{-- <a class="dropdown-item" href="">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          {{ __('Profile') }}
        </a>
        <a class="dropdown-item" href="javascript:void(0)">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          {{ __('Settings') }}
        </a>
        <a class="dropdown-item" href="javascript:void(0)">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          {{ __('Activity Log') }}
        </a>
        <div class="dropdown-divider"></div> --}}
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          {{ __('Logout') }}
        </a>
      </div>
    </li>

  </ul>

</nav>
