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