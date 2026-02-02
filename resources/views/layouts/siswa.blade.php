<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard Siswa') — Inventaris TKJT</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  @stack('styles')
  <style>
    :root {
      --sidebar-bg: #0039c5;
      --primary-btn: #8aadd8;
      --sidebar-text: #eaeef9;
      --active-bg: rgba(138, 173, 216, 0.3);
    }
    
    body { background: #f8fafc; font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; }
    
    /* Sidebar */
    .sidebar { width: 240px; background: var(--sidebar-bg); min-height: 100vh; position: fixed; z-index: 1000; box-shadow: 3px 0 15px rgba(0, 57, 197, 0.2); }
    .sidebar-header { padding: 25px 20px; border-bottom: 1px solid rgba(234, 238, 249, 0.2); }
    .sidebar-brand { color: white; font-weight: 700; font-size: 1.3rem; text-decoration: none; display: flex; align-items: center; }
    .sidebar-brand i { background: rgba(255, 255, 255, 0.1); color: var(--sidebar-text); width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: 1.1rem; border: 1px solid rgba(255, 255, 255, 0.2); }
    .sidebar-subtitle { color: var(--sidebar-text); opacity: 0.8; font-size: 0.8rem; margin-top: 5px; margin-left: 48px; }
    .sidebar-menu { padding: 20px 15px; }
    
    .menu-title { color: var(--sidebar-text); opacity: 0.7; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px 8px; margin: 0; font-weight: 600; }
    .nav-link { color: var(--sidebar-text); padding: 12px 20px; margin: 4px 10px; border-radius: 8px; transition: all 0.2s; display: flex; align-items: center; }
    .nav-link i { width: 20px; font-size: 1rem; margin-right: 12px; opacity: 0.9; }
    .nav-link:hover { background: rgba(255, 255, 255, 0.1); color: white; transform: translateX(5px); text-decoration: none; }
    .nav-link.active { background: var(--active-bg); color: white; font-weight: 600; border-left: 4px solid var(--primary-btn); }
    .nav-link.active i { color: var(--primary-btn); }
    
    /* Main Content */
    .main-content { margin-left: 240px; width: calc(100% - 240px); min-height: 100vh; display: flex; flex-direction: column; }
    
    /* Navbar */
    .navbar { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05); padding: 15px 25px; border-bottom: 1px solid #e2e8f0; }
    .navbar-brand { font-weight: 700; color: #1e293b; font-size: 1.1rem; }
    .menu-toggle { color: #475569; background: #f1f5f9; border: none; border-radius: 8px; padding: 8px 12px; transition: all 0.2s; }
    .menu-toggle:hover { background: #e2e8f0; }
    .btn-logout { background: var(--primary-btn); color: #111828; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 600; transition: all 0.2s; }
    .btn-logout:hover { background: #7a9bc9; color: #111828; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(138, 173, 216, 0.3); }
    .btn-logout i { margin-right: 6px; }
    .user-info { margin-right: 15px; padding: 6px 12px; background: #f1f5f9; border-radius: 6px; font-size: 0.85rem; }
    .user-info strong { color: var(--sidebar-bg); }
    
    /* Content Area */
    .content { flex: 1; padding: 25px; background: #f8fafc; }
    
    /* Cards */
    .card { border-radius: 12px; border: none; box-shadow: 0 5px 20px rgba(0,0,0,0.04); background: white; transition: all 0.3s; overflow: hidden; }
    .card:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.08); transform: translateY(-2px); }
    .card-header { background: white; border-bottom: 1px solid #e2e8f0; padding: 18px 25px; border-radius: 12px 12px 0 0 !important; font-weight: 600; color: #1e293b; }
    .card-body { padding: 25px; }
    
    /* Alerts */
    .alert { border-radius: 10px; border: none; box-shadow: 0 5px 15px rgba(0,0,0,0.05); padding: 15px 20px; }
    .alert i { margin-right: 10px; }
    
    /* Mobile Sidebar */
    .offcanvas-header { background: var(--sidebar-bg); color: white; border-bottom: 1px solid rgba(255, 255, 255, 0.2); padding: 20px; }
    .offcanvas-body { background: var(--sidebar-bg); padding: 0; }
    .mobile-menu { padding: 20px; }
    .mobile-menu .nav-link { color: var(--sidebar-text); padding: 12px 18px; margin-bottom: 8px; border-radius: 8px; background: rgba(255, 255, 255, 0.1); text-decoration: none; display: flex; align-items: center; }
    .mobile-menu .nav-link i { margin-right: 12px; font-size: 1rem; width: 20px; }
    .mobile-menu .nav-link:hover, .mobile-menu .nav-link.active { background: var(--active-bg); color: white; font-weight: 600; border-left: 4px solid var(--primary-btn); }
    /* Tables */
    .table { border-radius: 8px; overflow: hidden; margin: 0; }
    .table thead th { background: #f8fafc; color: #475569; font-weight: 600; border-bottom: 2px solid #e2e8f0; padding: 15px; font-size: 0.9rem; }
    .table tbody td { padding: 14px 15px; vertical-align: middle; border-color: #f1f5f9; }
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
<div class="sidebar d-none d-lg-block">
  <div class="sidebar-header">
    <a href="{{ route('siswa.dashboard') }}" class="sidebar-brand">
      <i class="fa-solid fa-user-graduate"></i>
      <div>
        Panel Siswa
      </div>
    </a>
  </div>
  <div class="sidebar-menu">
    @php
      $menus = [
        ['route' => 'siswa.dashboard', 'icon' => 'fa-gauge-high', 'text' => 'Dashboard'],
        ['route' => 'siswa.peminjaman.index', 'icon' => 'fa-boxes-stacked', 'text' => 'Peminjaman'],
        ['route' => 'siswa.penggunaan_bahan.index', 'icon' => 'fa-flask-vial', 'text' => 'Penggunaan Bahan'],
        ['route' => 'siswa.profile', 'icon' => 'fa-user-circle', 'text' => 'Profil Siswa']
      ];
    @endphp
    @foreach($menus as $item)
      <a class="nav-link {{ request()->routeIs($item['route']) || request()->is('siswa/' . str_replace('*', '', $item['route'])) ? 'active' : '' }}" 
         href="{{ route($item['route'] === 'siswa.profil' ? 'siswa.profil' : str_replace('*', 'index', $item['route'])) }}">
        <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['text'] }}
      </a>
    @endforeach
  </div>
</div>
<div class="main-content">
  <nav class="navbar">
    <div class="container-fluid px-0">
      <button class="btn menu-toggle d-lg-none me-3" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
        <i class="fa-solid fa-bars"></i>
      </button>
      <span class="navbar-brand">@yield('title', 'Dashboard Siswa')</span>
      <div class="d-flex align-items-center">
        <form method="GET" action="{{ route('auth.logout') }}" class="d-inline ms-2">
          @csrf
          <button class="btn btn-logout">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
          </button>
        </form>
      </div>
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
      <i class="fa-solid fa-user-graduate me-2"></i> Menu Siswa
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <div class="mobile-menu">
      @foreach($menus as $item)
        <a class="nav-link {{ request()->routeIs($item['route']) || request()->is('siswa/' . str_replace('*', '', $item['route'])) ? 'active' : '' }}" 
           href="{{ route($item['route'] === 'siswa.profil' ? 'siswa.profil' : str_replace('*', 'index', $item['route'])) }}">
          <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['text'] }}
        </a>
      @endforeach
      <form method="GET" action="{{ route('auth.logout') }}" class="mt-2">
        @csrf
        <button class="btn w-100" style="background: #8aadd8; color: #111828; font-weight: 600; padding: 10px;">
          <i class="fa-solid fa-right-from-bracket me-2"></i> Keluar Akun
        </button>
      </form>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  setTimeout(() => document.querySelectorAll('.alert').forEach(a => new bootstrap.Alert(a).close()), 5000);
  document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const mobileLinks = document.querySelectorAll('#sidebarMobile .nav-link');
    mobileLinks.forEach(link => {
      if (link.href.includes(currentPath)) {
        link.classList.add('active');
      }
    });
  });
</script>
@stack('scripts')
</body>
</html>