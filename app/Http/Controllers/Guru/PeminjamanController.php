<?php
namespace App\Http\Controllers\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PenggunaanBahan;
class PeminjamanController extends Controller
{
    public function index()
    {
        $guruId = session('user_id');
        $peminjaman = Peminjaman::with(['siswa', 'barang'])
            ->where('setuju_id', $guruId)
            ->where('setuju_role', 'guru')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('guru.peminjaman.index', compact('peminjaman'));
    }
    public function show($id)
    {
        $guruId = session('user_id');  
        $peminjaman = Peminjaman::with(['siswa', 'barang', 'guru'])
            ->where('id', $id)
            ->where('setuju_id', $guruId)
            ->where('setuju_role', 'guru')
            ->firstOrFail();
        return view('guru.peminjaman.detail', compact('peminjaman'));
    }
}