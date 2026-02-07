<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class Log extends Model
{
    // Model untuk tabel `log`
    // Digunakan untuk mencatat aksi pengguna (audit trail)
    protected $table = 'log';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    protected $fillable = [
        'user_id', 'user_role', 'aksi', 'tabel', 'id_data',
        'data_lama', 'data_baru', 'keterangan', 'ip_address', 'user_agent'
    ];
}
