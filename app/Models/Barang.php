<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Barang extends Model
{
    // Model untuk tabel `barang`
    // Digunakan untuk pengelolaan barang dan QR
    protected $table = 'barang';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'kode',
        'nama',
        'merk',
        'spesifikasi',
        'kategori_id',
        'stok',
        'satuan',
        'kondisi',
        'lokasi_id',
        'keterangan',
        'tipe',
        'qr_code',
        'foto',
        'sarpras_id',
        'sarpras_sync',
        'sarpras_last_sync'
    ];
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }
}