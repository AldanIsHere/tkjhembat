<?php
 /*
    untuk export excel disini yang dipakai teknik manipulasi header,tapi jeleknya kadang lebar tabel di excel gak beraturan dan harus benerin di excel manual
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PenggunaanBahan;

class LaporanController extends Controller
{
  public function peminjaman(Request $request)
    {
        $status = $request->query('status');

        $query = Peminjaman::with(['barang', 'siswa', 'guru'])
            ->orderBy('tanggal_pinjam', 'desc');

        if ($status) {
            $query->where('status', $status);
        }

        $peminjaman = $query->get();
        if ($request->query('export') === 'excel') {

            /*
             misal button export di klik, paksa header menamai file ke format .xls(excel) dan masukkan semua data terkait ke dalam excel
             */
            $filename = 'laporan_peminjaman_' . date('Ymd_His') . '.xls';

            $headers = [
                "Content-Type"        => "application/vnd.ms-excel",
                "Content-Disposition" => "attachment; filename=\"$filename\"",
                "Pragma"              => "no-cache",
                "Expires"             => "0",
            ];

            $content = '
            <table border="1">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Siswa</th>
                        <th>NIS</th>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Guru</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($peminjaman as $p) {
                $content .= '
                    <tr>
                        <td>'.$p->kode.'</td>
                        <td>'.($p->siswa->nama ?? '-').'</td>
                        <td>'.($p->siswa->nis ?? '-').'</td>
                        <td>'.($p->barang->nama ?? $p->barang_nama).'</td>
                        <td>'.$p->jumlah.'</td>
                        <td>'.$p->status.'</td>
                        <td>'.($p->guru->nama ?? '-').'</td>
                        <td>'.$p->tanggal_pinjam.'</td>
                        <td>'.($p->tanggal_kembali ?? '-').'</td>
                    </tr>';
            }

            $content .= '</tbody></table>';

            return response($content, 200, $headers);
        }

        return view('admin.laporan.peminjaman', compact('peminjaman', 'status'));
    }

    public function bahan(Request $request)
    {
        $penggunaanBahan = PenggunaanBahan::with(['siswa', 'guru', 'bahan'])
            ->orderBy('tanggal', 'desc')
            ->get();
        if ($request->query('export') === 'excel') {
            /*
             misal button export di klik, paksa header menamai file ke format .xls(excel) dan masukkan semua data terkait ke dalam excel
             */
            $filename = 'laporan_penggunaan_bahan_' . date('Ymd_His') . '.xls';

            $headers = [
                "Content-Type"        => "application/vnd.ms-excel",
                "Content-Disposition" => "attachment; filename=\"$filename\"",
                "Pragma"              => "no-cache",
                "Expires"             => "0",
            ];

            $content = '
            <table border="1">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Siswa</th>
                        <th>Guru</th>
                        <th>Bahan</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($penggunaanBahan as $b) {
                $content .= '
                    <tr>
                        <td>'.$b->kode.'</td>
                        <td>'.($b->siswa->nama ?? '-').'</td>
                        <td>'.($b->guru->nama ?? '-').'</td>
                        <td>'.($b->bahan->nama ?? $b->bahan_nama ?? '-').'</td>
                        <td>'.$b->jumlah.'</td>
                        <td>'.$b->tanggal.'</td>
                        <td>'.($b->keterangan ?? '-').'</td>
                    </tr>';
            }

            $content .= '</tbody></table>';

            return response($content, 200, $headers);
        }
        return view('admin.laporan.bahan', compact('penggunaanBahan'));
    }

}
