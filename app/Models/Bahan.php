<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Bahan extends Model
{
    // Model untuk tabel `bahan`
    // Digunakan untuk pengelolaan bahan
    protected $table = 'bahan';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'kode', 'nama', 'stok', 'satuan', 'lokasi_id', 'keterangan', 'sarpras_id', 'sarpras_sync', 'sarpras_last_sync'
    ];
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
}
