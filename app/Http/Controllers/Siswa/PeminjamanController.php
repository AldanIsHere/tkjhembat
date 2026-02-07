<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $siswaId = session('user_id');
        $status  = $request->query('status');
        $query = Peminjaman::where('peminjam_id', $siswaId);
        if ($status) {
            $query->where('status', $status);
        }
        $peminjaman = $query
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();
        return view('siswa.peminjaman.index', compact('peminjaman', 'status'));
    }
    public function barang()
    {
        $barang = Barang::where('stok', '>', 0)->get();
        return view('siswa.peminjaman.barang', compact('barang'));
    }
    public function create($barang_id)
    {
        $barang = Barang::findOrFail($barang_id);
        $guru   = Guru::orderBy('nama')->get(); 
        return view('siswa.peminjaman.create', compact('barang', 'guru'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'barang_id'        => 'required|exists:barang,id',
            'setuju_id'        => 'required|exists:guru,id',
            'jumlah'           => 'required|numeric|min:1',
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam',
            'catatan'          => 'nullable|string'
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        if ($request->jumlah > $barang->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia!');
        }
        DB::transaction(function () use ($request, $barang) {
            $barang->decrement('stok', $request->jumlah);
            $qr_short = rand(1000, 9999);
            $qr_filename = 'uploads/qr_verifikasi/PMJ-' . time() . '-' . $qr_short . '.svg';
            $qr_path = public_path($qr_filename);
            $dir = dirname($qr_path);
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            QrCode::format('svg')->size(200)->generate($qr_short, $qr_path);
            $peminjaman = Peminjaman::create([
                'kode'            => 'PMJ-' . time(),
                'peminjam_id'     => session('user_id'),
                'peminjam_role'   => 'siswa',
                'setuju_id'       => $request->setuju_id,    
                'setuju_role'     => 'guru',                 
                'barang_id'       => $barang->id,
                'barang_nama'     => $barang->nama,
                'jumlah'          => $request->jumlah,
                'tanggal_pinjam'  => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'harus_kembali'   => $request->tanggal_kembali,
                'status'          => 'pending', 
                'catatan'         => $request->catatan,
                'qr_code_short'   => $qr_short,
                'qr_verifikasi'   => $qr_filename
            ]);
            session(['last_peminjaman_id' => $peminjaman->id]);
        });
        return redirect()
            ->route('siswa.peminjaman.scan_qr', session('last_peminjaman_id'))
            ->with('success', 'Peminjaman berhasil dibuat! Silakan scan QR Code barang.');
    }
    public function detail($id)
    {
        $peminjaman = Peminjaman::with('guru')->findOrFail($id);
        return view('siswa.peminjaman.detail', compact('peminjaman'));
    }
    public function returnForm($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('siswa.peminjaman.return', compact('peminjaman'));
    }
    public function returnStore(Request $request)
    {
        DB::transaction(function () use ($request) {
            $peminjaman = Peminjaman::lockForUpdate()->findOrFail($request->id);
            
            if ($peminjaman->status !== 'dipinjam') {
                abort(400, 'Status peminjaman tidak valid');
            }
            
            $barang = Barang::lockForUpdate()->findOrFail($peminjaman->barang_id);
            $barang->increment('stok', $peminjaman->jumlah);
            $peminjaman->update([
                'status' => 'dikembalikan',
                'kondisi_kembali' => $request->kondisi_kembali,
                'tanggal_kembali' => now()->format('Y-m-d')
            ]);
        });
        return redirect()
            ->route('siswa.peminjaman.index')
            ->with('success', 'Barang berhasil dikembalikan & stok diperbarui.');
    }
}