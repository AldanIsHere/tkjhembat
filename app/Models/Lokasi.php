<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class Lokasi extends Model
{
    // Model untuk tabel `lokasi`
    // Digunakan untuk menyimpan lokasi barang atau bahan
    protected $table = 'lokasi';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['nama', 'penanggung_jawab', 'foto_penanggung_jawab', 'keterangan'];
}
