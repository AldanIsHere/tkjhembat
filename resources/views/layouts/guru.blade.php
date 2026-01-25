<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Guru Panel') - Inventaris TKJT</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  
  @stack('css')

  <style>
    :root {
      --sidebar-bg: #fc9a05;
      --primary-btn: #111828;
      --sidebar-text: #eaeef9;
      --active-bg: rgba(17, 24, 40, 0.2);
    }
    
    body { background: #f8fafc; font-family: system-ui, -apple-system, sans-serif; }
    
    /* Sidebar */
    .sidebar { width: 260px; background: var(--sidebar-bg); min-height: 100vh; position: fixed; z-index: 1000; transition: all 0.3s; box-shadow: 3px 0 15px rgba(252, 154, 5, 0.2); }
    .sidebar-header { padding: 25px 20px; border-bottom: 1px solid rgba(234, 238, 249, 0.3); }
    .sidebar-brand { color: white; font-weight: 700; font-size: 1.3rem; text-decoration: none; display: flex; align-items: center; }
    .sidebar-brand i { background: white; color: var(--sidebar-bg); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 1.2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .sidebar-subtitle { color: white; opacity: 0.9; font-size: 0.85rem; margin-top: 5px; margin-left: 52px; }
    .sidebar-menu { padding: 20px 15px; overflow-y: auto; max-height: calc(100vh - 120px); }
    .sidebar-menu::-webkit-scrollbar { width: 5px; }
    .sidebar-menu::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3); border-radius: 10px; }
    
    .menu-title { color: white; opacity: 0.8; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px 8px; margin: 0; font-weight: 600; }
    .nav-link { color: var(--sidebar-text); padding: 14px 20px; margin: 4px 10px; border-radius: 10px; transition: all 0.2s; display: flex; align-items: center; background: rgba(255, 255, 255, 0.1); text-decoration: none; }
    .nav-link i { width: 22px; font-size: 1.1rem; margin-right: 12px; opacity: 0.9; }
    .nav-link:hover { background: rgba(255, 255, 255, 0.2); color: white; transform: translateX(8px); }
    .nav-link.active { background: white; color: var(--sidebar-bg); font-weight: 700; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .nav-link.active i { color: var(--sidebar-bg); opacity: 1; }
    
    /* Main Content */
    .main-content { margin-left: 260px; width: calc(100% - 260px); min-height: 100vh; display: flex; flex-direction: column; transition: margin-left 0.3s; }
    .main-content.expanded { margin-left: 0; width: 100%; }
    
    /* Navbar */
    .navbar { background: white; box-shadow: 0 2px 20px rgba(0,0,0,0.05); padding: 15px 25px; border-bottom: 1px solid #e2e8f0; }
    .navbar-brand { font-weight: 700; color: #1e293b; font-size: 1.2rem; }
    .menu-toggle { color: #475569; background: #f1f5f9; border: none; border-radius: 10px; padding: 10px 14px; transition: all 0.2s; }
    .menu-toggle:hover { background: #e2e8f0; transform: rotate(90deg); }
    
    .user-info { margin-right: 15px; padding: 8px 15px; background: #f1f5f9; border-radius: 8px; font-size: 0.9rem; }
    .user-info strong { color: var(--sidebar-bg); }
    
    /* Content Area */
    .content { flex: 1; padding: 30px; background: #f8fafc; }
    
    /* Cards */
    .card { border-radius: 15px; border: none; box-shadow: 0 5px 25px rgba(0,0,0,0.05); background: white; transition: all 0.3s; overflow: hidden; }
    .card:hover { box-shadow: 0 10px 35px rgba(0,0,0,0.1); transform: translateY(-3px); }
    .card-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 20px 30px; border-radius: 15px 15px 0 0 !important; font-weight: 700; color: #1e293b; font-size: 1.1rem; }
    .card-body { padding: 30px; }
    
    /* Alerts */
    .alert { border-radius: 12px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); padding: 16px 20px; }
    .alert i { margin-right: 10px; }
    
    /* Mobile Sidebar */
    .offcanvas-header { background: var(--sidebar-bg); color: white; border-bottom: 1px solid rgba(255, 255, 255, 0.2); padding: 20px; }
    .offcanvas-body { background: var(--sidebar-bg); padding: 0; }
    .mobile-menu { padding: 20px; }
    .mobile-menu .nav-link { color: var(--sidebar-text); padding: 14px 18px; margin-bottom: 8px; border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.2); background: rgba(255, 255, 255, 0.1); text-decoration: none; display: flex; align-items: center; }
    .mobile-menu .nav-link i { margin-right: 12px; font-size: 1.1rem; width: 24px; }
    .mobile-menu .nav-link:hover, .mobile-menu .nav-link.active { background: white; color: var(--sidebar-bg); border-color: white; font-weight: 600; }
    .mobile-menu .menu-title { color: white; opacity: 0.9; padding: 20px 18px 10px; margin: 0; font-size: 0.8rem; }
    
    /* Tables */
    .table { border-radius: 10px; overflow: hidden; margin: 0; }
    .table thead th { background: #f8fafc; color: #475569; font-weight: 700; border-bottom: 2px solid #e2e8f0; padding: 18px; font-size: 0.95rem; }
    .table tbody td { padding: 16px 18px; vertical-align: middle; border-color: #f1f5f9; }
    .table-hover tbody tr:hover { background: #f8fafc; }
    
    @media (max-width: 992px) {
      .main-content { margin-left: 0; width: 100%; }
    }
    
    @media (max-width: 768px) {
      .content { padding: 20px 15px; }
      .card-body { padding: 20px; }
    }
  </style>
</head>
<body>
<!-- Desktop Sidebar -->
<div class="sidebar d-none d-lg-block">
  <div class="sidebar-header">
    <a href="{{ route('guru.dashboard') }}" class="sidebar-brand">
      <i class="fa-solid fa-chalkboard-user"></i>
      <div>
        Guru Panel
      </div>
    </a>
  </div>
  
  <div class="sidebar-menu">
    @php
      $menus = [
        ['route' => 'guru.dashboard', 'icon' => 'fa-gauge-high', 'text' => 'Dashboard'],
        ['route' => 'guru.peminjaman.*', 'icon' => 'fa-handshake', 'text' => 'Peminjaman'],
        ['route' => 'guru.penggunaan_bahan.*', 'icon' => 'fa-flask-vial', 'text' => 'Penggunaan Bahan'],
        ['route' => 'guru.profile', 'icon' => 'fa-user-gear', 'text' => 'Profil Saya']
      ];
    @endphp
    
    @foreach($menus as $item)
      <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" 
         href="{{ route(str_replace('.*', '.index', $item['route'])) }}">
        <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['text'] }}
      </a>
    @endforeach
    
    <div class="mt-4 pt-3 border-top border-white border-opacity-25">
      <a class="nav-link text-danger" href="{{ route('auth.logout') }}">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </a>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="main-content">
  <nav class="navbar">
    <div class="container-fluid px-0">
      <button class="btn menu-toggle d-lg-none me-3" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <button class="btn menu-toggle d-none d-lg-block me-3" id="desktopToggle">
        <i class="fa-solid fa-bars"></i>
      </button>
      <span class="navbar-brand">@yield('title', 'Dashboard Guru')</span>
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

<!-- Mobile Sidebar -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarMobile">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title">
      <i class="fa-solid fa-chalkboard-user"></i> Menu Guru
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  
  <div class="offcanvas-body">
    <div class="mobile-menu">
      @foreach($menus as $item)
        <a class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}" 
           href="{{ route(str_replace('.*', '.index', $item['route'])) }}">
          <i class="fa-solid {{ $item['icon'] }} me-2"></i> {{ $item['text'] }}
        </a>
      @endforeach
      
      <div class="mt-4 pt-3 border-top border-white border-opacity-25">
        <a class="nav-link text-danger" href="{{ route('auth.logout') }}">
          <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
        </a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Auto-dismiss alerts
  setTimeout(() => document.querySelectorAll('.alert').forEach(a => new bootstrap.Alert(a).close()), 5000);
  
  // Desktop sidebar toggle
  document.getElementById('desktopToggle')?.addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    sidebar.style.marginLeft = sidebar.style.marginLeft === '-260px' ? '0' : '-260px';
    mainContent.classList.toggle('expanded');
  });
  
  // Active menu indicator
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nav-link').forEach(link => {
      if (link.href === window.location.href) link.classList.add('active');
    });
  });
  
  // Close mobile sidebar on link click
  document.querySelectorAll('#sidebarMobile .nav-link').forEach(link => {
    link.addEventListener('click', () => {
      bootstrap.Offcanvas.getInstance(document.getElementById('sidebarMobile')).hide();
    });
  });
  
  // Rotate hamburger icon on click
  document.querySelectorAll('.menu-toggle').forEach(toggle => {
    toggle.addEventListener('click', function() {
      this.classList.toggle('rotated');
    });
  });
</script>

@stack('js')
</body>
</html>