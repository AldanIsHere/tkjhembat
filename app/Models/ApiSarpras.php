<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ApiSarpras extends Model
{
    // Model untuk tabel `api_sarpras`
    // Digunakan jika ada integrasi dengan sistem sarpras eksternal
    protected $table = 'api_sarpras';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nama', 'base_url', 'api_key', 'api_secret', 'token', 'tipe_auth', 'aktif', 'keterangan', 'last_sync'
    ];
}
