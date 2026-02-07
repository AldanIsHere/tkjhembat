<?php
<<<<<<< HEAD
namespace App\Http\Controllers\Guru;
use App\Http\Controllers\Controller;
use App\Models\PenggunaanBahan;
=======

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PenggunaanBahan;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class PenggunaanBahanController extends Controller
{
    public function index()
    {
        $penggunaan = PenggunaanBahan::with(['siswa', 'bahan', 'guru'])
            ->where('guru_id', session('user_id'))
            ->orderBy('tanggal', 'desc')
            ->get();
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        return view('guru.bahan.index', compact('penggunaan'));
    }
}
