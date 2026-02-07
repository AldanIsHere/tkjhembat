<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Log extends Model
{
    // Model untuk tabel `log`
    // Digunakan untuk mencatat aksi pengguna (audit trail)
    protected $table = 'log';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'user_role', 'aksi', 'tabel', 'id_data',
        'data_lama', 'data_baru', 'keterangan', 'ip_address', 'user_agent'
    ];
}
