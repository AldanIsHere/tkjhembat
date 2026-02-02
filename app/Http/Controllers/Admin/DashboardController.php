<?php
/*
 untuk disini si dashboard pakai syntax bawaan laravel, yaitu Count() untuk menghitung total data yang dimiliki sebuah tabel berdasarkan model yang ada.
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Bahan;
use App\Models\PenggunaanBahan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalPeminjaman = Peminjaman::count();
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalBahan = Bahan::count();
        $totalPenggunaanBahan = PenggunaanBahan::count();

        return view('admin.dashboard', compact(
            'totalBarang',
            'totalPeminjaman',
            'totalSiswa',
            'totalGuru',
            'totalBahan',
            'totalPenggunaanBahan'
        ));
    }
}
