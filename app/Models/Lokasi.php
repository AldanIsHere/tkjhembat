<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lokasi extends Model
{
    // Model untuk tabel `lokasi`
    // Digunakan untuk menyimpan lokasi barang atau bahan
    protected $table = 'lokasi';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['nama', 'penanggung_jawab', 'foto_penanggung_jawab', 'keterangan'];
}
