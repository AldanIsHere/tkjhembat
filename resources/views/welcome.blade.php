<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Sekolah</title>

    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #4a90e2;
            --secondary: #50e3c2;
            --accent: #f39c12;
            --dark: #0d3b66;
            --light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .hero {
            min-height: 85vh;
            background: linear-gradient(135deg, 
                rgba(74, 144, 226, 0.9) 0%,
                rgba(80, 227, 194, 0.85) 50%,
                rgba(13, 59, 102, 0.9) 100%),
                url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .stat-card {
            padding: 2rem 1.5rem;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary) 100%);
            color: white;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--secondary);
        }

        .stat-card:hover {
            transform: scale(1.05);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
        }

        .role-card {
            padding: 2.5rem 2rem;
            border-radius: 20px;
            background: white;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }

        .role-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .btn-modern {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .floating-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 8px 25px rgba(74, 144, 226, 0.4);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .floating-btn:hover {
            transform: scale(1.1);
            background: var(--dark);
        }

        @media (max-width: 768px) {
            .hero {
                min-height: 70vh;
            }
            
            .stat-card {
                padding: 1.5rem 1rem;
            }
            
            .role-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

<!-- Floating Login Button -->
<a href="{{ route('auth.login') }}" class="floating-btn" title="Login">
    <i class="fas fa-right-to-bracket"></i>
</a>

<!-- Hero Section -->
<section class="hero d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center hero-content">
                <h1 class="display-4 fw-bold text-white mb-4">Sistem Inventaris Sekolah</h1>
                <p class="lead text-light mb-5 opacity-90">
                    Platform pengelolaan barang, bahan, dan peminjaman untuk siswa, guru, dan admin secara terpusat
                </p>
                <a href="{{ route('auth.login') }}" class="btn btn-modern btn-light px-5 py-3">
                    <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
@php
    use App\Models\Barang;
    use App\Models\Bahan;
    use App\Models\Lokasi;
    use App\Models\Siswa;
    use App\Models\Guru;
    use App\Models\Aturan;

    $stats = [
        'barang' => Barang::count(),
        'bahan' => Bahan::count(),
        'lokasi' => Lokasi::count(),
        'siswa' => Siswa::count(),
        'guru' => Guru::count(),
        'aturan' => Aturan::where('aktif', 1)->count()
    ];
@endphp

<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach([
                ['icon' => 'boxes-stacked', 'value' => $stats['barang'], 'label' => 'Barang', 'color' => 'linear-gradient(135deg, #4a90e2, #3b78c1)'],
                ['icon' => 'flask', 'value' => $stats['bahan'], 'label' => 'Bahan', 'color' => 'linear-gradient(135deg, #50e3c2, #3bc9b0)'],
                ['icon' => 'map-marker-alt', 'value' => $stats['lokasi'], 'label' => 'Lokasi', 'color' => 'linear-gradient(135deg, #f39c12, #e67e22)'],
                ['icon' => 'user-graduate', 'value' => $stats['siswa'], 'label' => 'Siswa', 'color' => 'linear-gradient(135deg, #9b59b6, #8e44ad)'],
                ['icon' => 'chalkboard-teacher', 'value' => $stats['guru'], 'label' => 'Guru', 'color' => 'linear-gradient(135deg, #e74c3c, #c0392b)'],
                ['icon' => 'shield-alt', 'value' => $stats['aturan'], 'label' => 'Aturan Aktif', 'color' => 'linear-gradient(135deg, #2ecc71, #27ae60)']
            ] as $item)
            <div class="col-md-4 col-lg-2 col-6">
                <div class="stat-card text-center" style="background: {{ $item['color'] }}">
                    <div class="stat-icon">
                        <i class="fas fa-{{ $item['icon'] }}"></i>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $item['value'] }}</h3>
                    <small class="opacity-90">{{ $item['label'] }}</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row g-4">
            @foreach([
                ['icon' => 'qrcode', 'title' => 'QR Code System', 'desc' => 'Validasi peminjaman dengan QR Code', 'color' => '#4a90e2'],
                ['icon' => 'clipboard-check', 'title' => 'Approval Flow', 'desc' => 'Sistem persetujuan fleksibel', 'color' => '#50e3c2'],
                ['icon' => 'chart-line', 'title' => 'Real-time Monitoring', 'desc' => 'Laporan real-time penggunaan', 'color' => '#f39c12']
            ] as $feature)
            <div class="col-md-4">
                <div class="glass-card p-4 h-100">
                    <div class="feature-icon" style="background: {{ $feature['color'] }}">
                        <i class="fas fa-{{ $feature['icon'] }}"></i>
                    </div>
                    <h5 class="fw-bold mb-3">{{ $feature['title'] }}</h5>
                    <p class="text-muted mb-0">{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Roles Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach([
                ['icon' => 'user-shield', 'title' => 'Admin', 'desc' => 'Kelola sistem dan monitoring', 'color' => '#4a90e2', 'btn' => 'primary'],
                ['icon' => 'chalkboard-teacher', 'title' => 'Guru', 'desc' => 'Setujui peminjaman', 'color' => '#50e3c2', 'btn' => 'success'],
                ['icon' => 'user-graduate', 'title' => 'Siswa', 'desc' => 'Pinjam dan gunakan alat', 'color' => '#f39c12', 'btn' => 'warning']
            ] as $role)
            <div class="col-md-4">
                <div class="role-card text-center">
                    <div class="mb-4">
                        <i class="fas fa-{{ $role['icon'] }} fa-3x" style="color: {{ $role['color'] }}"></i>
                    </div>
                    <h4 class="fw-bold mb-3">{{ $role['title'] }}</h4>
                    <p class="text-muted mb-4">{{ $role['desc'] }}</p>
                    <a href="{{ route('auth.login') }}" class="btn btn-modern btn-{{ $role['btn'] }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="fw-bold mb-4">
                    <i class="fas fa-school me-2"></i>Inventaris Sekolah
                </h5>
                <p class="text-light opacity-75 small">
                    Platform pengelolaan inventaris sekolah yang modern dan efisien.
                </p>
            </div>
            
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Akses Cepat</h6>
                <div class="d-flex flex-column">
                    <a href="/" class="text-light opacity-75 mb-2 text-decoration-none">
                        <i class="fas fa-home me-2"></i>Beranda
                    </a>
                    <a href="{{ route('auth.login') }}" class="text-light opacity-75 mb-2 text-decoration-none">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </a>
                </div>
            </div>
            
            <div class="col-md-4">
                <h6 class="fw-bold mb-3">Kontak</h6>
                <p class="text-light opacity-75 small mb-1">
                    <i class="fas fa-envelope me-2"></i>inventaris@sekolah.id
                </p>
            </div>
        </div>
        
        <hr class="opacity-25 my-4">
        
        <div class="text-center pt-3">
            <p class="small opacity-75 mb-0">
                © {{ date('Y') }} Sistem Inventaris Sekolah • Built with Laravel
            </p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Simple animations
    document.addEventListener('DOMContentLoaded', function() {
        // Add scroll animation
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        document.querySelectorAll('.stat-card, .glass-card, .role-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            observer.observe(card);
        });
    });
</script>
</body>
</html>