<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    // Model untuk tabel `admin`
    // Digunakan untuk login, dashboard, dan manajemen data admin
    protected $table = 'admin';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'nama', 'email', 'password', 'telepon', 'foto'
    ];
}
