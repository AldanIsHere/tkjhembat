<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PenggunaanBahan;
use App\Models\Bahan;
use App\Models\Guru;

class PenggunaanBahanController extends Controller
{
    // ===============================
    // LIST PENGGUNAAN BAHAN
    // ===============================
    public function index()
    {
        $penggunaan = PenggunaanBahan::with(['bahan', 'guru'])
            ->where('siswa_id', session('user_id'))
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('siswa.penggunaan_bahan.index', compact('penggunaan'));
    }

    // ===============================
    // FORM CREATE
    // ===============================
    public function create()
    {
        $bahan = Bahan::where('stok', '>', 0)->orderBy('nama')->get();
        $guru  = Guru::orderBy('nama')->get();

        return view('siswa.penggunaan_bahan.create', compact('bahan', 'guru'));
    }

    // ===============================
    // SIMPAN DATA + POTONG STOK
    // ===============================
    public function store(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required|exists:bahan,id',
            'guru_id'  => 'required|exists:guru,id',
            'jumlah'   => 'required|numeric|min:1',
            'tanggal'  => 'required|date',
        ]);

        DB::transaction(function () use ($request) {

            $bahan = Bahan::lockForUpdate()->findOrFail($request->bahan_id);

            // CEK STOK
            if ($bahan->stok < $request->jumlah) {
                abort(400, 'Stok bahan tidak mencukupi');
            }

            // SIMPAN PENGGUNAAN
            PenggunaanBahan::create([
                'kode'       => 'PBH-' . date('YmdHis'),
                'siswa_id'   => session('user_id'),
                'guru_id'    => $request->guru_id,
                'bahan_id'   => $bahan->id,
                'bahan_nama' => $bahan->nama,
                'jumlah'     => $request->jumlah,
                'tanggal'    => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            // POTONG STOK
            $bahan->decrement('stok', $request->jumlah);
        });

        return redirect()
            ->route('siswa.penggunaan_bahan.index')
            ->with('success', 'Penggunaan bahan berhasil dicatat & stok diperbarui');
    }

    // ===============================
    // DETAIL
    // ===============================
    public function detail($id)
    {
        $penggunaan = PenggunaanBahan::with(['bahan', 'guru', 'siswa'])
            ->where('siswa_id', session('user_id'))
            ->findOrFail($id);

        return view('siswa.penggunaan_bahan.detail', compact('penggunaan'));
    }
}
