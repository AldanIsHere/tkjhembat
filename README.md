<<<<<<< HEAD
TJKT - Sistem Manajemen Sarpras
Sistem manajemen sarana dan prasarana untuk sekolah berbasis web dengan fitur peminjaman barang, penggunaan bahan, dan pemindaian QR Code.

🛠 Tech Stack
Backend:

Laravel 11

PHP 8.2+

Frontend:

Bootstrap 5

Font Awesome Icons

JavaScript (Vanilla)

QR Code & Scanning:

html5-qrcode - untuk scan webcam barang sarpras admin

simplesoftwareio/simple-qrcode - untuk generate QR Code

chillerlan/php-qrcode - untuk processing QR Code

khanamiryan/qrcode-detector-decoder - untuk deteksi QR Code

📋 Requirements
Server Requirements:

PHP ≥ 8.2

Composer

Node.js & npm

MySQL ≥ 5.7 / MariaDB ≥ 10.2

Web Server (Apache/Nginx)

PHP Extensions:

BCMath

Ctype

cURL

DOM

Fileinfo

GD

JSON

Mbstring

OpenSSL

PCRE

PDO

Tokenizer

XML

Installation
1. Clone Repository
bash
git clone [repository-url]
cd tjkt
2. Install Dependencies
bash
composer install
npm install
3. Environment Setup
bash
cp .env.example .env
php artisan key:generate
4. Database Configuration
Edit file .env dan sesuaikan konfigurasi database:

env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tjkt
DB_USERNAME=root
DB_PASSWORD=
5. Import Database
Import database dari file tjkt.sql yang tersedia:

bash
mysql -u username -p tjkt < tjkt.sql
Atau gunakan phpMyAdmin/HeidiSQL untuk import file SQL.

6. Folder Permissions
bash
# Untuk Linux/Mac
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Untuk Windows, pastikan folder berikut writable:
# - storage
# - bootstrap/cache
# - public/uploads
7. Asset Compilation
bash
npm run build
8. Server Setup
Development:

bash
php artisan serve
npm run dev
Production:

bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
9. Access Application
Buka browser dan akses:

Development: http://localhost:8000

Production: sesuaikan dengan domain/server Anda

Project Structure
text
tjkt/
├── app/                 # Application logic
│   ├── Http/           # Controllers & Middleware
│   ├── Models/         # Eloquent Models
│   └── Providers/      # Service Providers
├── public/             # Public assets
│   └── uploads/        # Uploaded files (QR, photos)
├── resources/          # Views & Assets
│   ├── views/         # Blade templates
│   │   ├── admin/     # Admin panel views
│   │   ├── guru/      # Teacher views
│   │   ├── siswa/     # Student views
│   │   └── auth/      # Authentication views
│   ├── js/            # JavaScript files
│   └── css/           # CSS files
├── routes/             # Route definitions
└── database/           # Database migrations & seeders
🔧 Fitur Utama
Admin Panel
Manajemen Barang Sarpras

Manajemen Kategori & Lokasi

Manajemen Guru & Siswa

Laporan Peminjaman & Penggunaan

Scan QR Code via Webcam

Guru
Dashboard monitoring

Manajemen peminjaman barang

Penggunaan bahan praktikum

Profil dan pengaturan

Siswa
Peminjaman barang sarpras

Penggunaan bahan praktikum

Scan QR Code untuk verifikasi

Riwayat transaksi

Troubleshooting
Issue: Composer install error

bash
composer update --no-scripts
composer install
Issue: npm build error

bash
npm ci
npm run build
Issue: QR Code scan tidak berfungsi

Pastikan menggunakan HTTPS atau localhost

Izinkan akses kamera di browser

Periksa console log browser untuk error

Issue: Upload file gagal

bash
# Pastikan folder uploads writable
chmod -R 775 public/uploads
📄 License
Proprietary - Untuk penggunaan internal sekolah
=======
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
