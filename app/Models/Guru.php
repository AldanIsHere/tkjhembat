<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class Guru extends Model
{
    // Model untuk tabel `guru`
    // Digunakan untuk login guru, approve peminjaman, dan pengelolaan bahan
    protected $table = 'guru';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    protected $fillable = [
        'nip', 'nama', 'email', 'password', 'telepon', 'jabatan', 'foto'
    ];
}
