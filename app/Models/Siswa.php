<?php
<<<<<<< HEAD
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
=======

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class Siswa extends Model
{
    // Model untuk tabel `siswa`
    // Digunakan untuk login siswa, daftar peminjaman, profil, dan penggunaan bahan
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    public $timestamps = true;
<<<<<<< HEAD
    protected $fillable = [
        'nis', 'nama', 'email', 'password', 'kelas', 'jurusan', 'telepon', 'foto'
    ];
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'peminjam_id');
    }    public function penggunaanBahan()
=======

    protected $fillable = [
        'nis', 'nama', 'email', 'password', 'kelas', 'jurusan', 'telepon', 'foto'
    ];

    // Relasi ke peminjaman siswa
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'peminjam_id');
    }

    // Relasi ke penggunaan bahan
    public function penggunaanBahan()
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    {
        return $this->hasMany(PenggunaanBahan::class, 'siswa_id');
    }
}
