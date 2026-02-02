<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    // Model untuk tabel `peminjaman`
    // Digunakan untuk menyimpan transaksi peminjaman barang
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kode', 'peminjam_id', 'peminjam_role', 'setuju_id', 'setuju_role',
        'barang_id', 'barang_nama', 'jumlah', 'tanggal_pinjam', 'tanggal_kembali', 'harus_kembali',
        'status', 'alasan', 'denda', 'kondisi_pinjam', 'kondisi_kembali',
        'qr_verifikasi', 'qr_code_short', 'qr_validated_at',
        'sarpras_status', 'sarpras_ref', 'sarpras_response', 'sarpras_checked_at', 'catatan'
    ];

    // Relasi ke siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'peminjam_id');
    }

    // Relasi ke guru
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'setuju_id');
    }

    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
