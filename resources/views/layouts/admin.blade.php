<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Admin Panel') - Inventaris TKJT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  @stack('css')

  <style>
    :root {
      --sidebar-bg: #111828;
      --primary-btn: #fc9a05;
      --sidebar-text: #eaeef9;
      --active-bg: rgba(252, 154, 5, 0.2);
    }
    
    body { background: #f8fafc; font-family: system-ui, -apple-system, sans-serif; }
    
    /* Sidebar */
    .sidebar { width: 260px; background: var(--sidebar-bg); min-height: 100vh; position: fixed; z-index: 1000; transition: all 0.3s; }
    .sidebar-header { padding: 20px 15px; border-bottom: 1px solid rgba(234, 238, 249, 0.1); }
    .sidebar-brand { color: var(--sidebar-text); font-weight: 700; font-size: 1.2rem; text-decoration: none; }
    .sidebar-brand i { color: var(--primary-btn); margin-right: 10px; }
    .sidebar-subtitle { color: rgba(234, 238, 249, 0.7); font-size: 0.85rem; }
    .sidebar-menu { padding: 15px 10px; overflow-y: auto; max-height: calc(100vh - 120px); }
    .sidebar-menu::-webkit-scrollbar { width: 5px; }
    .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(252, 154, 5, 0.3); border-radius: 10px; }
    
    .menu-title { color: rgba(234, 238, 249, 0.5); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px 8px; }
    .nav-link { color: var(--sidebar-text); padding: 12px 20px; margin: 3px 10px; border-radius: 8px; transition: all 0.2s; display: flex; align-items: center; text-decoration: none; }
    .nav-link i { width: 22px; margin-right: 12px; opacity: 0.8; }
    .nav-link:hover { background: rgba(255, 255, 255, 0.1); color: white; transform: translateX(5px); }
    .nav-link.active { background: var(--active-bg); color: var(--primary-btn); font-weight: 600; }
    .nav-link.active i { color: var(--primary-btn); opacity: 1; }
    
    /* Main Content */
    .main-content { margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; display: flex; flex-direction: column; transition: margin-left 0.3s; }
    .main-content.expanded { margin-left: 0; width: 100%; }
    
    /* Navbar */
    .navbar { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 12px 20px; border-bottom: 1px solid #e2e8f0; }
    .navbar-brand { font-weight: 600; color: #1e293b; font-size: 1.1rem; }
    .menu-toggle { color: #475569; border: 1px solid #e2e8f0; border-radius: 8px; padding: 8px 12px; transition: all 0.2s; }
    .menu-toggle:hover { background: #f1f5f9; }
    .user-info { color: #475569; font-size: 0.9rem; }
    .user-info strong { color: #1e293b; }
    
    /* Content & Cards */
    .content { flex: 1; padding: 25px; background: #f8fafc; }
    .card { border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px rgba(0,0,0,0.04); background: white; transition: all 0.3s; }
    .card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.08); transform: translateY(-2px); }
    .card-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 18px 25px; border-radius: 12px 12px 0 0 !important; font-weight: 600; }
    .card-body { padding: 25px; }
    
    /* Alerts */
    .alert { border-radius: 10px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    
    /* Mobile Sidebar */
    .offcanvas-header { background: var(--sidebar-bg); color: var(--sidebar-text); border-bottom: 1px solid rgba(234, 238, 249, 0.1); }
    .offcanvas-body { background: var(--sidebar-bg); padding: 0; }
    .mobile-menu { padding: 15px; }
    .mobile-menu .nav-link { color: var(--sidebar-text); padding: 12px 15px; margin-bottom: 5px; border-radius: 8px; border: 1px solid rgba(234, 238, 249, 0.1); background: rgba(255, 255, 255, 0.05); }
    .mobile-menu .nav-link:hover, .mobile-menu .nav-link.active { background: var(--active-bg); color: var(--primary-btn); border-color: rgba(252, 154, 5, 0.3); }
    
    /* Tables */
    .table { border-radius: 8px; overflow: hidden; }
    .table thead th { background: #f1f5f9; color: #475569; font-weight: 600; border-bottom: 2px solid #e2e8f0; padding: 15px; }
    .table tbody td { padding: 15px; vertical-align: middle; }
    .table-hover tbody tr:hover { background: #f8fafc; }
    
    @media (max-width: 992px) {
      .main-content { margin-left: 0; width: 100%; }
    }
  </style>
</head>
<body>
<div class="sidebar d-none d-lg-block">
  <div class="sidebar-header">
    <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
      <i class="fa-solid fa-boxes-stacked"></i> Admin Panel
    </a>
  </div>
  
  <div class="sidebar-menu">
    @php
      $menus = [
        'menu' => [
          ['route' => 'admin.dashboard', 'icon' => 'fa-gauge-high', 'text' => 'Dashboard']
        ],
        'Manajemen Data' => [
          ['route' => 'barang.*', 'icon' => 'fa-box', 'text' => 'Barang'],
          ['route' => 'bahan.*', 'icon' => 'fa-flask-vial', 'text' => 'Bahan'],
          ['route' => 'kategori.*', 'icon' => 'fa-tags', 'text' => 'Kategori'],
          ['route' => 'lokasi.*', 'icon' => 'fa-location-dot', 'text' => 'Lokasi']
        ],
        'Manajemen Pengguna' => [
          ['route' => 'guru.*', 'icon' => 'fa-chalkboard-user', 'text' => 'Guru'],
          ['route' => 'siswa.*', 'icon' => 'fa-user-graduate', 'text' => 'Siswa']
        ],
        'Konfigurasi & Laporan' => [
          ['route' => 'aturan.*', 'icon' => 'fa-sliders', 'text' => 'Aturan'],
          ['route' => 'admin.laporan.peminjaman', 'icon' => 'fa-file', 'text' => 'Peminjaman'],
          ['route' => 'admin.laporan.bahan', 'icon' => 'fa-flask', 'text' => 'Laporan Bahan'],
          ['route' => 'api-sarpras.index', 'icon' => 'fa-network-wired', 'text' => 'API Sarpras']
        ]
      ];
    @endphp
    
    @foreach($menus as $title => $items)
      @if($title !== 'menu')
        <h6 class="menu-title">{{ $title }}</h6>
      @endif
      @foreach($items as $item)
        <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" 
           href="{{ route(str_replace('.*', '.index', $item['route'])) }}">
          <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['text'] }}
        </a>
      @endforeach
    @endforeach
    
    <div class="mt-4">
      <a class="nav-link text-danger" href="{{ route('auth.logout') }}">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </a>
    </div>
  </div>
</div>
<div class="main-content">
  <nav class="navbar">
    <div class="container-fluid px-0">
      <button class="btn menu-toggle d-lg-none me-3" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <button class="btn menu-toggle d-none d-lg-block me-3" id="desktopToggle">
        <i class="fa-solid fa-bars"></i>
      </button>
      <span class="navbar-brand">@yield('title', 'Dashboard Admin')</span>
     
    </div>
  </nav>
  <main class="content">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        <ul class="mb-0">
          @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    
    @yield('content')
  </main>
</div>
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarMobile">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">
      <i class="fa-solid fa-boxes-stacked me-2"></i> Menu Admin
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  
  <div class="offcanvas-body">
    <div class="mobile-menu">
      @foreach($menus as $title => $items)
        @if($title !== 'menu')
          <h6 class="menu-title">{{ $title }}</h6>
        @endif
        @foreach($items as $item)
          <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" 
             href="{{ route(str_replace('.*', '.index', $item['route'])) }}">
            <i class="fa-solid {{ $item['icon'] }} me-2"></i> {{ $item['text'] }}
          </a>
        @endforeach
      @endforeach
      
      <div class="mt-4 pt-3 border-top">
        <a class="nav-link text-danger" href="{{ route('auth.logout') }}">
          <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
        </a>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  setTimeout(() => document.querySelectorAll('.alert').forEach(a => new bootstrap.Alert(a).close()), 5000);
  document.getElementById('desktopToggle')?.addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    sidebar.style.marginLeft = sidebar.style.marginLeft === '-260px' ? '0' : '-260px';
    mainContent.classList.toggle('expanded');
  });
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nav-link').forEach(link => {
      if (link.href === window.location.href) link.classList.add('active');
    });
  });
  document.querySelectorAll('#sidebarMobile .nav-link').forEach(link => {
    link.addEventListener('click', () => {
      bootstrap.Offcanvas.getInstance(document.getElementById('sidebarMobile')).hide();
    });
  });
</script>
@stack('js')
</body>
</html>