<?php
<<<<<<< HEAD
namespace App\Http\Controllers\Guru;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PenggunaanBahan;
=======

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class PeminjamanController extends Controller
{
    public function index()
    {
        $guruId = session('user_id');
<<<<<<< HEAD
        $peminjaman = Peminjaman::with(['siswa', 'barang'])
            ->where('setuju_id', $guruId)
            ->where('setuju_role', 'guru')
=======

        $peminjaman = Peminjaman::with(['siswa', 'barang'])
            ->where('setuju_id', $guruId)
            ->where('setuju_role', 'guru')
            ->whereNotNull('qr_validated_at')
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('guru.peminjaman.index', compact('peminjaman'));
    }
    public function show($id)
    {
<<<<<<< HEAD
        $guruId = session('user_id');  
        $peminjaman = Peminjaman::with(['siswa', 'barang', 'guru'])
            ->where('id', $id)
            ->where('setuju_id', $guruId)
            ->where('setuju_role', 'guru')
            ->firstOrFail();
        return view('guru.peminjaman.detail', compact('peminjaman'));
    }
}
=======
        $guruId = session('user_id');

        $peminjaman = Peminjaman::where('id', $id)
            ->where('setuju_id', $guruId)
            ->where('setuju_role', 'guru')
            ->firstOrFail();

        return view('guru.peminjaman.detail', compact('peminjaman'));
    }
    public function approve($id)
    {
        $guruId = session('user_id');

        DB::transaction(function () use ($id, $guruId) {

            $peminjaman = Peminjaman::where('id', $id)
                ->where('setuju_id', $guruId)
                ->where('status', 'pending')
                ->lockForUpdate()
                ->firstOrFail();

            $barang = Barang::lockForUpdate()->findOrFail($peminjaman->barang_id);

            if ($peminjaman->jumlah > $barang->stok) {
                abort(400, 'Stok barang tidak mencukupi');
            }

            $barang->decrement('stok', $peminjaman->jumlah);
            $peminjaman->update([
                'status' => 'dipinjam'
            ]);
        });

        return redirect()
            ->route('guru.peminjaman.index')
            ->with('success', 'Peminjaman disetujui & stok diperbarui.');
    }
    public function reject($id)
    {
        $guruId = session('user_id');

        $peminjaman = Peminjaman::where('id', $id)
            ->where('setuju_id', $guruId)
            ->where('status', 'pending')
            ->firstOrFail();

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        return redirect()
            ->route('guru.peminjaman.index')
            ->with('success', 'Peminjaman ditolak.');
    }
}
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
