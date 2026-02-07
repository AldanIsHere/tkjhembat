<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
class ScanController extends Controller
{
    public function scanQr($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        if ($peminjaman->qr_validated_at) {
            return redirect()->route('siswa.peminjaman.scan_success', $peminjaman->id);
        }
        return view('siswa.peminjaman.scan_qr', compact('peminjaman'));
    }
    private function extractKodeUnikFromQR($qrString)
    {
        $qrString = trim($qrString);
        if (empty($qrString)) {
            return null;
        }
        if (preg_match('/\/([A-Za-z0-9.\-_]+)\.(png|jpg|jpeg|svg)$/i', $qrString, $matches)) {
            return $matches[1];
        }
        if (preg_match('/kodeunik=([A-Za-z0-9.\-_]+)(?:\/|$|\s|&)/', $qrString, $matches)) {
            return $matches[1];
        }
        if (preg_match('/^([A-Za-z0-9.\-_]+)$/', $qrString, $matches)) {
            return $matches[1];
        }
        if (preg_match('/\/([A-Za-z0-9.\-_]+)\/jenis=/', $qrString, $matches)) {
            return $matches[1];
        }
        $parsedUrl = parse_url($qrString);
        if (isset($parsedUrl['path'])) {
            $path = trim($parsedUrl['path'], '/');
            $segments = explode('/', $path);
            foreach ($segments as $segment) {
                if (strpos($segment, 'kodeunik=') !== false) {
                    if (preg_match('/kodeunik=([A-Za-z0-9.\-_]+)/', $segment, $matches)) {
                        return $matches[1];
                    }
                }
                if (preg_match('/^[A-Za-z0-9.\-_]+$/', $segment) && strlen($segment) >= 5) {
                    return $segment;
                }
            }
        }
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            if (isset($queryParams['kodeunik'])) {
                return $queryParams['kodeunik'];
            }
            foreach ($queryParams as $value) {
                if (preg_match('/^[A-Za-z0-9.\-_]+$/', $value) && strlen($value) >= 5) {
                    return $value;
                }
            }
        }
        return null;
    }
    public function validateCameraQr(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'qr_code_url' => 'required'
        ]);
        $peminjaman = Peminjaman::with('barang')->findOrFail($request->peminjaman_id);
        $kodeUnik = $this->extractKodeUnikFromQR($request->qr_code_url);
        
        if (!$kodeUnik) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat membaca kode dari QR. Pastikan QR valid.',
                'debug' => [
                    'scanned_url' => $request->qr_code_url
                ]
            ], 400);
        }
        if (!$peminjaman->barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan dalam peminjaman.'
            ], 400);
        }
        if ($peminjaman->barang->kode === $kodeUnik) {
            $peminjaman->update([
                'qr_verifikasi' => $request->qr_code_url,
                'qr_validated_at' => now()
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Validasi berhasil! QR Code sesuai.',
                'redirect_url' => route('siswa.peminjaman.scan_success', $peminjaman->id),
                'debug' => [
                    'scanned_url' => $request->qr_code_url,
                    'extracted_code' => $kodeUnik,
                    'barang_code' => $peminjaman->barang->kode
                ]
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'QR Code tidak sesuai. Kode barang tidak cocok.',
            'debug' => [
                'scanned_url' => $request->qr_code_url,
                'extracted_code' => $kodeUnik,
                'barang_code' => $peminjaman->barang->kode,
                'barang_nama' => $peminjaman->barang_nama
            ]
        ], 400);
    }
    public function scanSuccess($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);
        if (!$peminjaman->qr_validated_at) {
            return redirect()->route('siswa.peminjaman.scan_qr', $peminjaman->id);
        }
        return view('siswa.peminjaman.scan_success', compact('peminjaman'));
    }
}