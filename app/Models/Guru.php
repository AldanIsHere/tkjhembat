<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    // Model untuk tabel `guru`
    // Digunakan untuk login guru, approve peminjaman, dan pengelolaan bahan
    protected $table = 'guru';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nip', 'nama', 'email', 'password', 'telepon', 'jabatan', 'foto'
    ];
}
