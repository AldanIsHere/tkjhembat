<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * LIST PEMINJAMAN GURU (KHUSUS MILIK GURU INI)
     */
    public function index()
    {
        $guruId = session('user_id');

        $peminjaman = Peminjaman::with(['siswa', 'barang'])
            ->where('setuju_id', $guruId)          // 🔑 KUNCI UTAMA
            ->where('setuju_role', 'guru')
            ->whereNotNull('qr_validated_at')
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        return view('guru.peminjaman.index', compact('peminjaman'));
    }

    /**
     * DETAIL PEMINJAMAN (AMAN)
     */
    public function show($id)
    {
        $guruId = session('user_id');

        $peminjaman = Peminjaman::where('id', $id)
            ->where('setuju_id', $guruId)
            ->where('setuju_role', 'guru')
            ->firstOrFail();

        return view('guru.peminjaman.detail', compact('peminjaman'));
    }

    /**
     * APPROVE
     */
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

            // ❗ CEK STOK ULANG (AMAN)
            if ($peminjaman->jumlah > $barang->stok) {
                abort(400, 'Stok barang tidak mencukupi');
            }

            // ✅ KURANGI STOK
            $barang->decrement('stok', $peminjaman->jumlah);

            // ✅ UPDATE STATUS
            $peminjaman->update([
                'status' => 'dipinjam'
            ]);
        });

        return redirect()
            ->route('guru.peminjaman.index')
            ->with('success', 'Peminjaman disetujui & stok diperbarui.');
    }

    /**
     * REJECT
     */
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
