<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Kategori extends Model
{
    // Model untuk tabel `kategori`
    // Digunakan untuk mengelompokkan barang
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['nama', 'deskripsi'];
    public function barang()
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}
