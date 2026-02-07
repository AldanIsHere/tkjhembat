<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class PenggunaanBahan extends Model
{
    // Model untuk tabel `penggunaan_bahan`
    // Digunakan untuk mencatat penggunaan bahan oleh siswa
    protected $table = 'penggunaan_bahan';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
    protected $fillable = [
        'kode', 'siswa_id', 'guru_id', 'bahan_id', 'bahan_nama', 'jumlah', 'tanggal', 'keterangan'
    ];
=======

    protected $fillable = [
        'kode', 'siswa_id', 'guru_id', 'bahan_id', 'bahan_nama', 'jumlah', 'tanggal', 'keterangan'
    ];

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id');
    }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }
}
