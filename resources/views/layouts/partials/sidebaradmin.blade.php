<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('admin.dashboard') }}" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Pengaduan</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::user()->username }}</a>
        <small class="text-muted d-block">Administrator</small>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">DASHBOARD</li>
        <li class="nav-item">
          <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-header">MENU</li>
        <li class="nav-item">
          <a href="{{ route('admin.aspirasi.index') }}" class="nav-link {{ Request::routeIs('admin.aspirasi.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-clipboard-list"></i>
            <p>Daftar Aspirasi</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ Request::routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tags"></i>
            <p>Kelola Kategori</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('admin.laporan') }}" class="nav-link {{ Request::routeIs('admin.laporan') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Laporan</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>