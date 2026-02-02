<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    // Model untuk tabel `aturan`
    // Digunakan untuk aturan peminjaman (maks hari, denda, persetujuan)
    protected $table = 'aturan';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama', 'deskripsi', 'maks_hari', 'denda_hari', 'perlu_setuju', 'role_setuju', 'aktif'
    ];
}
