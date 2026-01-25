<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\PenggunaanBahan;
use App\Models\Siswa;
use App\Models\Bahan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('guru.dashboard', [
            'totalPending' => Peminjaman::where('status', 'pending')->count(),
            'totalDipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'totalDitolak' => Peminjaman::where('status', 'ditolak')->count(),
            'totalPenggunaanBahan' => PenggunaanBahan::count(),
            'totalSiswa' => Siswa::count(),
            'totalBahan' => Bahan::count(),
        ]);
    }
}
