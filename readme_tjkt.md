# Sistem Manajemen Sarpras TJKT
Sistem manajemen sarana dan prasarana berbasis web untuk sekolah dengan fitur lengkap peminjaman barang, penggunaan bahan praktikum, dan pemindaian QR Code.

## Teknologi yang Digunakan
**Backend**
- Laravel 11
- PHP 8.2 atau lebih tinggi

**Frontend**
- Bootstrap 5
- Font Awesome Icons
- JavaScript Native

**QR Code & Scanning**
- html5-qrcode - untuk pemindaian webcam barang sarpras (admin)
- simplesoftwareio/simple-qrcode - untuk pembuatan QR Code
- chillerlan/php-qrcode - untuk pemrosesan QR Code
- khanamiryan/qrcode-detector-decoder - untuk deteksi QR Code

## Persyaratan Sistem
### Persyaratan Server
- PHP versi 8.2 atau lebih tinggi
- Composer
- Node.js & npm
- MySQL versi 5.7 atau lebih tinggi / MariaDB versi 10.2 atau lebih tinggi
- Web Server (Apache/Nginx)

### Ekstensi PHP yang Diperlukan
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- GD
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML

## Panduan Instalasi
### Langkah 1: Clone Repository
```bash
git clone [repository-url]
cd tjkt
```

### Langkah 2: Instalasi Dependensi
```bash
composer install
npm install
```

### Langkah 3: Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

### Langkah 4: Konfigurasi Database
Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tjkt
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 5: Import Database
Import database dari file `tjkt.sql` yang tersedia:
- Menggunakan MySQL CLI:
```bash
mysql -u username -p tjkt < tjkt.sql
```
- Alternatif: Gunakan phpMyAdmin, HeidiSQL, atau tools database lainnya.

### Langkah 6: Pengaturan Permission Folder
**Linux/Mac:**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```
**Windows:** Pastikan folder berikut memiliki permission write:
- storage
- bootstrap/cache
- public/uploads

### Langkah 7: Kompilasi Assets
```bash
npm run build
```

### Langkah 8: Menjalankan Server
**Mode Development:**
```bash
php artisan serve
npm run dev
```
**Mode Production:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Langkah 9: Mengakses Aplikasi
- Development: http://localhost:8000
- Production: Sesuaikan dengan domain atau alamat server Anda

## Struktur Projek
```
tjkt/
├── app/                 # Logika aplikasi
│   ├── Http/           # Controller dan Middleware
│   ├── Models/         # Model Eloquent
│   └── Providers/      # Service Provider
├── public/             # Asset publik
│   └── uploads/        # File upload (QR Code, foto)
├── resources/          # View dan Assets
│   ├── views/         # Template Blade
│   │   ├── admin/     # Panel admin
│   │   ├── guru/      # Interface guru
│   │   ├── siswa/     # Interface siswa
│   │   └── auth/      # Halaman autentikasi
│   ├── js/            # File JavaScript
│   └── css/           # File CSS
├── routes/             # Definisi route
└── database/           # Migrasi dan seeder database
```

## Fitur Utama
### Panel Administrator
- Manajemen barang sarana dan prasarana
- Manajemen kategori dan lokasi barang
- Manajemen data guru dan siswa
- Laporan peminjaman dan penggunaan
- Pemindaian QR Code menggunakan webcam

### Modul Guru
- Dashboard monitoring
- Manajemen peminjaman barang
- Pengelolaan penggunaan bahan praktikum
- Profil dan pengaturan akun

### Modul Siswa
- Peminjaman barang sarana dan prasarana
- Penggunaan bahan praktikum
- Verifikasi melalui pemindaian QR Code
- Riwayat transaksi dan peminjaman

## Pemecahan Masalah
### Masalah: Error saat Composer Install
```bash
composer update --no-scripts
composer install
```

### Masalah: Error saat Build npm
```bash
npm ci
npm run build
```

### Masalah: QR Code Scan Tidak Berfungsi
- Pastikan menggunakan HTTPS atau localhost
- Izinkan akses kamera pada browser
- Periksa console log browser untuk pesan error

### Masalah: Upload File Gagal
```bash
# Pastikan folder uploads dapat ditulis
chmod -R 775 public/uploads
```

## Informasi Tambahan
- Database Backup: File `tjkt.sql` berisi struktur dan data awal
- Struktur Proyek: File `struktur.txt` dan `struktur_projek.txt` berisi detail struktur proyek
- Backup Lengkap: File `tjkt.zip` berisi backup lengkap proyek

## Lisensi
Proprietary - Untuk penggunaan internal sekolah.

