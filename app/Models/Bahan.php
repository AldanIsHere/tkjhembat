<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class Bahan extends Model
{
    // Model untuk tabel `bahan`
    // Digunakan untuk pengelolaan bahan
    protected $table = 'bahan';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
    protected $fillable = [
        'kode', 'nama', 'stok', 'satuan', 'lokasi_id', 'keterangan', 'sarpras_id', 'sarpras_sync', 'sarpras_last_sync'
    ];
=======

    protected $fillable = [
        'kode', 'nama', 'stok', 'satuan', 'lokasi_id', 'keterangan', 'sarpras_id', 'sarpras_sync', 'sarpras_last_sync'
    ];

    // Relasi ke lokasi
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
