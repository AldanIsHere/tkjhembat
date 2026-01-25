<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class BarangController extends Controller
{
    public function index()
    {
        $barang   = Barang::with(['kategori','lokasi'])->orderBy('created_at','DESC')->get();
        $kategori = Kategori::orderBy('nama')->get();
        $lokasi   = Lokasi::orderBy('nama')->get();

        return view('admin.barang.index', compact('barang','kategori','lokasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode'        => 'required',
            'nama'        => 'required|string|max:191',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi_id'   => 'required|exists:lokasi,id',
            'merk'        => 'nullable|string|max:191',
            'spesifikasi' => 'nullable|string',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string',
            'kondisi'     => 'nullable|string|max:100',
            'tipe'        => 'nullable|string|max:50',
            'qr_code_file'=> 'nullable|mimes:svg'
        ]);

        $qrPath = null;

        if ($request->hasFile('qr_code_file')) {
            $filename = time().'-'.Str::slug($request->kode).'.svg';
            $request->file('qr_code_file')
                    ->move(public_path('uploads/qr_barang'), $filename);
            $qrPath = 'uploads/qr_barang/'.$filename;
        }

        Barang::create([
            'kode'        => $request->kode,
            'nama'        => $request->nama,
            'kategori_id' => $request->kategori_id,
            'lokasi_id'   => $request->lokasi_id,
            'merk'        => $request->merk,
            'spesifikasi' => $request->spesifikasi,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
            'kondisi'     => $request->kondisi ?? 'Baik',
            'tipe'        => $request->tipe,
            'qr_code'     => $qrPath
        ]);

        return back()->with('success','Barang berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama'        => 'required|string|max:191',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi_id'   => 'required|exists:lokasi,id',
            'merk'        => 'nullable|string|max:191',
            'spesifikasi' => 'nullable|string',
            'stok'        => 'required|integer|min:0',
            'satuan'      => 'required|string',
            'kondisi'     => 'nullable|string|max:100',
            'tipe'        => 'nullable|string|max:50'
        ]);

        $barang->update([
            'nama'        => $request->nama,
            'kategori_id' => $request->kategori_id,
            'lokasi_id'   => $request->lokasi_id,
            'merk'        => $request->merk,
            'spesifikasi' => $request->spesifikasi,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
            'kondisi'     => $request->kondisi,
            'tipe'        => $request->tipe
        ]);

        return back()->with('success','Barang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->qr_code && file_exists(public_path($barang->qr_code))) {
            unlink(public_path($barang->qr_code));
        }

        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus');
    }
    public function generateQr($id)
    {
        $barang = Barang::findOrFail($id);

        // QR hanya boleh dibuat jika belum ada
        if ($barang->qr_code) {
            return back()->with('error', 'QR Code sudah ada');
        }

        $filename = 'qr-' . $barang->kode . '.svg';
        $path = public_path('uploads/qr_barang');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        QrCode::format('svg')
            ->size(250)
            ->generate($barang->kode, $path . '/' . $filename);

        $barang->update([
            'qr_code' => 'uploads/qr_barang/' . $filename
        ]);

        return back()->with('success', 'QR Code berhasil dibuat');
    }
}
