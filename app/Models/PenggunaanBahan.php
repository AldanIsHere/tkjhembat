<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PenggunaanBahan extends Model
{
    // Model untuk tabel `penggunaan_bahan`
    // Digunakan untuk mencatat penggunaan bahan oleh siswa
    protected $table = 'penggunaan_bahan';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'kode', 'siswa_id', 'guru_id', 'bahan_id', 'bahan_nama', 'jumlah', 'tanggal', 'keterangan'
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
}
