<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    // Model untuk tabel `siswa`
    // Digunakan untuk login siswa, daftar peminjaman, profil, dan penggunaan bahan
    protected $table = 'siswa';
    protected $primaryKey = 'id';
    public $timestamps = true;

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
    {
        return $this->hasMany(PenggunaanBahan::class, 'siswa_id');
    }
}
