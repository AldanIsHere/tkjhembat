<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Inventaris Sekolah</title>
    
    <!-- Bootstrap 5 & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #4a90e2;
            --secondary: #50e3c2;
            --dark: #0d3b66;
            --light: #f8f9fa;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            max-width: 1000px;
            min-height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .login-left {
            background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
            color: white;
            padding: 40px;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        }

        .app-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .app-subtitle {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateX(5px);
        }

        .feature-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--secondary), #3bc9b0);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.2rem;
        }

        .login-right {
            padding: 40px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title {
            font-size: 1.6rem;
            color: var(--dark);
            font-weight: 600;
            margin-bottom: 10px;
            position: relative;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            border-radius: 2px;
        }

        .login-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        .form-control {
            height: 50px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 10px 15px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(74, 144, 226, 0.3);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 0.85rem;
        }

        .glass-alert {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .login-container {
                max-width: 95%;
            }
            .login-left, .login-right {
                padding: 30px;
            }
            .login-left {
                min-height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="row g-0 h-100">
            <!-- Left Panel -->
            <div class="col-md-6 login-left">
                <div class="h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h1 class="app-title">Sistem Inventaris Sekolah</h1>
                        <p class="app-subtitle">Platform pengelolaan barang, bahan, dan peminjaman</p>
                        
                        <div class="mt-4">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <strong>Keamanan Multi-Level</strong><br>
                                    <small>Autentikasi untuk Admin, Guru, dan Siswa</small>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-qrcode"></i>
                                </div>
                                <div>
                                    <strong>Peminjaman QR Code</strong><br>
                                    <small>Validasi cepat dan aman dengan QR Code</small>
                                </div>
                            </div>
                            
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <div>
                                    <strong>Monitoring Real-time</strong><br>
                                    <small>Pantau status aset secara real-time</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-4">
                        <a href="/" class="text-white opacity-75 text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Right Panel -->
            <div class="col-md-6 login-right">
                <div class="login-header">
                    <h2 class="login-title">Selamat Datang</h2>
                    <p class="login-description">Masuk ke akun Anda untuk mengelola inventaris</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success glass-alert alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <div>{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error') || $errors->any())
                    <div class="alert alert-danger glass-alert alert-dismissible fade show" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div>{{ session('error') ?? $errors->first() }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('auth.login') }}" method="POST" onsubmit="showLoading(this)">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}"
                               placeholder="contoh@email.com"
                               required>
                        @error('email')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Password</label>
                        <div class="position-relative">
                            <input type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   placeholder="••••••••"
                                   required
                                   id="passwordInput">
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>

                    <div class="login-footer">
                        <p class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Pilih peran Anda saat memasukkan kredensial
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function showLoading(form) {
            if (form.checkValidity()) {
                const btn = form.querySelector('button[type="submit"]');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';
                btn.disabled = true;
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);
            }
        }

        // Auto-dismiss alerts after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 150);
            });
        }, 5000);

        // Simple form validation enhancement
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    if (this.classList.contains('is-invalid')) {
                        this.classList.remove('is-invalid');
                    }
                });
            });
        });
    </script>
</body>
</html>