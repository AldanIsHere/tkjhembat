<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bahan;
use App\Models\Lokasi;

class BahanController extends Controller
{
    public function index()
    {
        $bahan  = Bahan::with('lokasi')->orderBy('id', 'desc')->get();
        $lokasi = Lokasi::orderBy('nama')->get();

        return view('admin.bahan.index', compact('bahan', 'lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'      => 'required|unique:bahan,kode',
            'nama'      => 'required',
            'stok'      => 'required|numeric|min:0',
            'satuan'    => 'required',
            'lokasi_id' => 'required',
        ]);

        Bahan::create([
            'kode'      => $request->kode,
            'nama'      => $request->nama,
            'stok'      => $request->stok,
            'satuan'    => $request->satuan,
            'lokasi_id' => $request->lokasi_id,
            'keterangan'=> $request->keterangan,

            // OPSIONAL SARPRAS
            'sarpras_id'        => $request->sarpras_id,
            'sarpras_sync'      => $request->sarpras_sync,
            'sarpras_last_sync' => $request->sarpras_last_sync,
        ]);

        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $bahan = Bahan::findOrFail($id);

        $request->validate([
            'nama'      => 'required',
            'stok'      => 'required|numeric|min:0',
            'satuan'    => 'required',
            'lokasi_id' => 'required',
        ]);

        $bahan->update([
            'nama'      => $request->nama,
            'stok'      => $request->stok,
            'satuan'    => $request->satuan,
            'lokasi_id' => $request->lokasi_id,
            'keterangan'=> $request->keterangan,

            // OPSIONAL SARPRAS
            'sarpras_id'        => $request->sarpras_id,
            'sarpras_sync'      => $request->sarpras_sync,
            'sarpras_last_sync' => $request->sarpras_last_sync,
        ]);

        return redirect()->back()->with('success', 'Bahan berhasil diperbarui');
    }

    public function destroy($id)
    {
        Bahan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Bahan berhasil dihapus');
    }
}
