<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
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
<<<<<<< HEAD
        'foto',
=======
        'foto', // KOLOM FOTO DITAMBAHKAN
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        'sarpras_id',
        'sarpras_sync',
        'sarpras_last_sync'
    ];
<<<<<<< HEAD
=======

    // Relasi ke kategori
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
<<<<<<< HEAD
=======

    // Relasi ke lokasi
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id');
    }
<<<<<<< HEAD
=======

    // Relasi ke peminjaman
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'barang_id');
    }
}