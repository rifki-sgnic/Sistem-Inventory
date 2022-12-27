<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-cube"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Inventory<sup>App</sup></div>
  </a>

  @hasrole('admin|superadmin|testing')
  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item {{ Nav::isRoute('dashboard') }}">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>{{ __('Dashboard') }}</span>
    </a>
  </li>
  @endhasrole
  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Heading -->
  {{-- <div class="sidebar-heading">
    {{ __('Interface') }}
  </div> --}}

  @hasrole('admin|superadmin|purchasing|testing')
  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item {{ Nav::isRoute('master.index') }} {{ Nav::isRoute('supplier.index') }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#master" aria-expanded="true"
      aria-controls="collapsePages">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Part Master</span>
    </a>
    <div id="master" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @hasrole('admin|superadmin|testing')
        <a class="collapse-item" href="{{ route('master.index') }}">Data Master Barang</a>
        @endhasrole
        @hasrole('admin|superadmin|purchasing|testing')
        <a class="collapse-item" href="{{ route('supplier.index') }}">Data Supplier</a>
        @endhasrole
        </div>
      </div>
    </li>
  @endhasrole

  <hr class="sidebar-divider my-0">
  <li class="nav-item {{ Nav::isRoute('list-barang.index') }} {{ Nav::isRoute('receive.index') }} {{ Nav::isRoute('transaction.index') }} {{ Nav::isRoute('return.index') }} {{ Nav::isRoute('request-barang.index') }} {{ Nav::isRoute('request-barang.tambah') }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#outgoing" aria-expanded="true"
      aria-controls="collapsePages">
      <i class="fas fa-fw fa-truck"></i>
      <span>Transaksi</span>
    </a>
    <div id="outgoing" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        @hasrole('admin|superadmin|purchasing|testing')
        <a class="collapse-item" href="{{ route('request-barang.index') }}">Data Request Barang</a>
        @endhasrole
        <a class="collapse-item" href="{{ route('list-barang.index') }}">List Penerimaan Barang</a>
        @hasrole('admin|superadmin|testing')
        <a class="collapse-item" href="{{ route('receive.index') }}">Data Barang Masuk</a>
        <a class="collapse-item" href="{{ route('transaction.index') }}">Data Barang Keluar</a>
        @endhasrole
        @hasrole('admin|superadmin|purchasing|testing')
        <a class="collapse-item" href="{{ route('return.index') }}">Return</a>
        @endhasrole
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  @role ('superadmin|testing')
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
  @endrole
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
