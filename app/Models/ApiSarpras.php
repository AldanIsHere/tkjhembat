<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ApiSarpras extends Model
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class ApiSarpras extends Model

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
{
    // Model untuk tabel `api_sarpras`
    // Digunakan jika ada integrasi dengan sistem sarpras eksternal
    protected $table = 'api_sarpras';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    protected $fillable = [
        'nama', 'base_url', 'api_key', 'api_secret', 'token', 'tipe_auth', 'aktif', 'keterangan', 'last_sync'
    ];
}
