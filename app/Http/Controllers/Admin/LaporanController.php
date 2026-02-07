<?php
<<<<<<< HEAD
/*
=======
 /*
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    untuk export excel disini yang dipakai teknik manipulasi header,tapi jeleknya kadang lebar tabel di excel gak beraturan dan harus benerin di excel manual
 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\PenggunaanBahan;
<<<<<<< HEAD
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function peminjaman(Request $request)
    {
        $status = $request->query('status');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $query = Peminjaman::with(['barang', 'siswa', 'guru'])
            ->orderBy('tanggal_pinjam', 'desc');
        if ($status && in_array($status, ['pending', 'disetujui', 'dipinjam', 'dikembalikan', 'ditolak'])) {
            $query->where('status', $status);
        }
        if ($start_date) {
            $query->whereDate('tanggal_pinjam', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('tanggal_pinjam', '<=', $end_date);
        }
        if (!$start_date && $end_date) {
            $query->whereDate('tanggal_pinjam', '=', $end_date);
        }
        if ($start_date && !$end_date) {
            $query->whereDate('tanggal_pinjam', '>=', $start_date);
        }
        $peminjaman = $query->get();
        $total_peminjaman = $peminjaman->count();
        $total_dipinjam = $peminjaman->where('status', 'dipinjam')->count();
        $total_dikembalikan = $peminjaman->where('status', 'dikembalikan')->count();
        $total_pending = $peminjaman->where('status', 'pending')->count();
        if ($request->query('export') === 'excel') {
            $filename = 'laporan_peminjaman_' . date('Ymd_His') . '.xls';
=======

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

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            $headers = [
                "Content-Type"        => "application/vnd.ms-excel",
                "Content-Disposition" => "attachment; filename=\"$filename\"",
                "Pragma"              => "no-cache",
                "Expires"             => "0",
            ];
<<<<<<< HEAD
            $filter_info = '';
            if ($status) {
                $filter_info .= "Status: $status | ";
            }
            if ($start_date) {
                $filter_info .= "Dari: $start_date | ";
            }
            if ($end_date) {
                $filter_info .= "Sampai: $end_date | ";
            }
            $content = '
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Laporan Peminjaman</title>
            </head>
            <body>
                <h2>Laporan Peminjaman Barang</h2>
                <p>'.($filter_info ? 'Filter: ' . rtrim($filter_info, ' | ') : 'Semua Data').'</p>
                <p>Total Data: '.$total_peminjaman.'</p>
                <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Siswa</th>
                            <th>NIS</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Guru</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Harus Kembali</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            $no = 1;
            foreach ($peminjaman as $p) {
                $content .= '
                    <tr>
                        <td>'.$no++.'</td>
                        <td>'.htmlspecialchars($p->kode ?? '-').'</td>
                        <td>'.htmlspecialchars($p->siswa->nama ?? '-').'</td>
                        <td>'.htmlspecialchars($p->siswa->nis ?? '-').'</td>
                        <td>'.htmlspecialchars($p->barang->nama ?? $p->barang_nama).'</td>
                        <td>'.$p->jumlah.'</td>
                        <td>'.$p->status.'</td>
                        <td>'.htmlspecialchars($p->guru->nama ?? '-').'</td>
                        <td>'.$p->tanggal_pinjam.'</td>
                        <td>'.($p->tanggal_kembali ?? '-').'</td>
                        <td>'.$p->harus_kembali.'</td>
                    </tr>';
            }
            $content .= '</tbody></table></body></html>';
            return response($content, 200, $headers);
        }
        return view('admin.laporan.peminjaman', compact(
            'peminjaman', 
            'status', 
            'start_date', 
            'end_date',
            'total_peminjaman',
            'total_dipinjam',
            'total_dikembalikan',
            'total_pending'
        ));
    }
    public function bahan(Request $request)
    {
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $query = PenggunaanBahan::with(['siswa', 'guru', 'bahan'])
            ->orderBy('tanggal', 'desc');
        if ($start_date) {
            $query->whereDate('tanggal', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('tanggal', '<=', $end_date);
        }
        if (!$start_date && $end_date) {
            $query->whereDate('tanggal', '=', $end_date);
        }
        if ($start_date && !$end_date) {
            $query->whereDate('tanggal', '>=', $start_date);
        }
        $penggunaanBahan = $query->get();
        if ($request->query('export') === 'excel') {
            $filename = 'laporan_penggunaan_bahan_' . date('Ymd_His') . '.xls';
=======

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

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            $headers = [
                "Content-Type"        => "application/vnd.ms-excel",
                "Content-Disposition" => "attachment; filename=\"$filename\"",
                "Pragma"              => "no-cache",
                "Expires"             => "0",
            ];
<<<<<<< HEAD
            $filter_info = '';
            if ($start_date) {
                $filter_info .= "Dari: $start_date | ";
            }
            if ($end_date) {
                $filter_info .= "Sampai: $end_date | ";
            }
            $content = '
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Laporan Penggunaan Bahan</title>
            </head>
            <body>
                <h2>Laporan Penggunaan Bahan</h2>
                <p>'.($filter_info ? 'Filter: ' . rtrim($filter_info, ' | ') : 'Semua Data').'</p>
                <p>Total Data: '.$penggunaanBahan->count().'</p>
                <table border="1" cellpadding="5" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
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
            $no = 1;
            foreach ($penggunaanBahan as $b) {
                $content .= '
                    <tr>
                        <td>'.$no++.'</td>
                        <td>'.htmlspecialchars($b->kode ?? '-').'</td>
                        <td>'.htmlspecialchars($b->siswa->nama ?? '-').'</td>
                        <td>'.htmlspecialchars($b->guru->nama ?? '-').'</td>
                        <td>'.htmlspecialchars($b->bahan->nama ?? $b->bahan_nama ?? '-').'</td>
                        <td>'.$b->jumlah.'</td>
                        <td>'.$b->tanggal.'</td>
                        <td>'.htmlspecialchars($b->keterangan ?? '-').'</td>
                    </tr>';
            }
            $content .= '</tbody></table></body></html>';
            return response($content, 200, $headers);
        }
        return view('admin.laporan.bahan', compact('penggunaanBahan', 'start_date', 'end_date'));
    }
}
=======

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
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
