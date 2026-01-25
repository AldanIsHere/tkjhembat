<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PenggunaanBahan;

class PenggunaanBahanController extends Controller
{
    public function index()
    {
        // Ambil hanya penggunaan bahan yang ditujukan ke guru login (opsional)
        // kalau mau semua, hapus where guru_id
        $penggunaan = PenggunaanBahan::with(['siswa', 'bahan', 'guru'])
            ->where('guru_id', session('user_id'))
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('guru.bahan.index', compact('penggunaan'));
    }
}
