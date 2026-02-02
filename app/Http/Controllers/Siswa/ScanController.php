<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;

class ScanController extends Controller
{
    public function scanQr($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $qr_path = public_path($peminjaman->qr_verifikasi);
        if (file_exists($qr_path)) {
            $qr_svg = file_get_contents($qr_path);
        } else {
            $qr_svg = null;
        }

        return view('siswa.peminjaman.scan_qr', compact('peminjaman', 'qr_svg'));
    }
    public function validateQr(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required',
            'qr_code_input' => 'required|digits:4'
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);

        if ($peminjaman->qr_code_short == $request->qr_code_input) {
            $peminjaman->update([
                'qr_validated_at' => now()
            ]);

            return view('siswa.peminjaman.scan_success', compact('peminjaman'));

        } else {
            return back()->with('error', 'QR tidak valid!');
        }
    }
}
