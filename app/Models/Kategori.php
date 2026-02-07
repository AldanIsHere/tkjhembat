<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class Kategori extends Model
{
    // Model untuk tabel `kategori`
    // Digunakan untuk mengelompokkan barang
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
    protected $fillable = ['nama', 'deskripsi'];
=======

    protected $fillable = ['nama', 'deskripsi'];

    // Relasi ke barang
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
