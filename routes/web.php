<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\LokasiController;
use App\Http\Controllers\Admin\AturanController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswa;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\BahanController;
use App\Http\Controllers\Admin\ApiSarprasController;

use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\Guru\PeminjamanController as GuruPeminjaman;
use App\Http\Controllers\Guru\PenggunaanBahanController as GuruPenggunaanBahan;
use App\Http\Controllers\Guru\GuruProfileController;

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Siswa\ProfilController;
use App\Http\Controllers\Siswa\PeminjamanController as SiswaPeminjaman;
use App\Http\Controllers\Siswa\ScanController;
use App\Http\Controllers\Siswa\PenggunaanBahanController as SiswaPenggunaanBahan;

// HALAMAN WELCOME
Route::get('/', function () {
    return view('welcome');
});

// ======================= AUTH =========================
Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'registerForm'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');




// ======================= ADMIN ========================
Route::prefix('admin')->group(function() {
    Route::get('dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
    Route::resource('barang', BarangController::class);
    Route::post('barang/{id}/generate-qr', [BarangController::class, 'generateQr'])
    ->name('barang.generate_qr');

    Route::resource('bahan', BahanController::class);
    Route::resource('api-sarpras', ApiSarprasController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('lokasi', LokasiController::class);
    Route::resource('aturan', AturanController::class);
    Route::resource('guru', GuruController::class);
    Route::resource('siswa', AdminSiswa::class);
    Route::get('laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('admin.laporan.peminjaman');
    
    Route::get('laporan/bahan', [LaporanController::class, 'bahan'])->name('admin.laporan.bahan');

    

});



// ======================= GURU =========================
Route::prefix('guru')->name('guru.')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [GuruDashboard::class, 'index'])
        ->name('dashboard');

    // ================= PEMINJAMAN =================
    Route::get('/peminjaman', [GuruPeminjaman::class, 'index'])
        ->name('peminjaman.index');

    Route::get('/peminjaman/{id}', [GuruPeminjaman::class, 'show'])
        ->name('peminjaman.show');

    Route::post('/peminjaman/{id}/approve', [GuruPeminjaman::class, 'approve'])
        ->name('peminjaman.approve');

    Route::post('/peminjaman/{id}/reject', [GuruPeminjaman::class, 'reject'])
        ->name('peminjaman.reject');

    // ================= PENGGUNAAN BAHAN =================
    Route::get('/penggunaan-bahan', [GuruPenggunaanBahan::class, 'index'])
        ->name('penggunaan_bahan.index');

         // ================= PROFIL GURU =================
    Route::get('/profile', [GuruProfileController::class, 'index'])
        ->name('profile');

    Route::get('/profile/edit', [GuruProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/update', [GuruProfileController::class, 'update'])
        ->name('profile.update');

});



// ======================= SISWA =======================
Route::prefix('siswa')->group(function() {
    Route::get('dashboard', [SiswaDashboard::class, 'index'])->name('siswa.dashboard');
    Route::get('profile', [ProfilController::class, 'index'])->name('siswa.profile');
    Route::get('profile/edit', [ProfilController::class, 'edit'])->name('siswa.profile.edit');
    Route::post('profile/update', [ProfilController::class, 'update'])->name('siswa.profile.update');

    // PEMINJAMAN
    Route::get('peminjaman', [SiswaPeminjaman::class, 'index'])->name('siswa.peminjaman.index');
    Route::get('peminjaman/barang', [SiswaPeminjaman::class, 'barang'])->name('siswa.peminjaman.barang');
    Route::get('peminjaman/create/{barang_id}', [SiswaPeminjaman::class, 'create'])->name('siswa.peminjaman.create');
    Route::post('peminjaman/store', [SiswaPeminjaman::class, 'store'])->name('siswa.peminjaman.store');
    Route::get('peminjaman/detail/{id}', [SiswaPeminjaman::class, 'detail'])->name('siswa.peminjaman.detail');

    // SCAN & VALIDASI QR
    Route::get('peminjaman/scan/{id}', [ScanController::class, 'scanQr'])
        ->name('siswa.peminjaman.scan_qr');

    Route::post('peminjaman/scan/validate', [ScanController::class, 'validateQr'])
    ->name('siswa.peminjaman.scan.validate'); // <-- ini nama route POST yang benar



    // PENGEMBALIAN
    Route::get('peminjaman/return/{id}', [SiswaPeminjaman::class, 'returnForm'])->name('siswa.peminjaman.return');
    Route::post('peminjaman/return/store', [SiswaPeminjaman::class, 'returnStore'])->name('siswa.peminjaman.return.store');

    // PENGGUNAAN BAHAN
    Route::get('penggunaan_bahan', [SiswaPenggunaanBahan::class, 'index'])->name('siswa.penggunaan_bahan.index');
    Route::get('penggunaan_bahan/create', [SiswaPenggunaanBahan::class, 'create'])->name('siswa.penggunaan_bahan.create');
    Route::post('penggunaan_bahan/store', [SiswaPenggunaanBahan::class, 'store'])->name('siswa.penggunaan_bahan.store');
    Route::get('penggunaan_bahan/detail/{id}', [SiswaPenggunaanBahan::class, 'detail'])->name('siswa.penggunaan_bahan.detail');
});
