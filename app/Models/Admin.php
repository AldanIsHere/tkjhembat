<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class Admin extends Model
{
    // Model untuk tabel `admin`
    // Digunakan untuk login, dashboard, dan manajemen data admin
    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    protected $fillable = [
        'nama', 'email', 'password', 'telepon', 'foto'
    ];
}
