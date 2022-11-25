<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-cube"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Inventory<sup>App</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ Nav::isRoute('admin.dashboard') }}">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>{{ __('Dashboard') }}</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    {{ __('Interface') }}
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item {{ Nav::isRoute('admin.master') }} {{ Nav::isRoute('admin.supplier') }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master" aria-expanded="true"
      aria-controls="collapsePages">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Part Master</span>
    </a>
    <div id="master" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.master') }}">Data Master Barang</a>
        <a class="collapse-item" href="{{ route('admin.supplier') }}">Data Supplier</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <li class="nav-item {{ Nav::isRoute('admin.list-barang') }} {{ Nav::isRoute('admin.receive') }} {{ Nav::isRoute('admin.transaction') }} {{ Nav::isRoute('admin.return') }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#outgoing" aria-expanded="true"
      aria-controls="collapsePages">
      <i class="fas fa-fw fa-truck"></i>
      <span>Transaksi</span>
    </a>
    <div id="outgoing" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.list-barang') }}"> List Barang</a>
        <a class="collapse-item" href="{{ route('admin.receive') }}"> Data Barang Masuk</a>
        <a class="collapse-item" href="{{ route('admin.transaction') }}">Data Barang Keluar</a>
        <a class="collapse-item" href="{{ route('admin.return') }}">Return</a>
      </div>
    </div>
  </li>

  @if (auth()->user()->role == 'admin')
  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item {{ Nav::isRoute('admin.user-management') }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#user" aria-expanded="true"
      aria-controls="collapseUtilities">
      <i class="fas fa-users"></i>
      <span>User</span>
    </a>
    <div id="user" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">User</h6>
        <a class="collapse-item" href="{{ route('admin.user-management') }}">User</a>
      </div>
    </div>
  </li>
  @endif
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
