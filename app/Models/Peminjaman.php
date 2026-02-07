<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Peminjaman extends Model
{
    // Model untuk tabel `peminjaman`
    // Digunakan untuk menyimpan transaksi peminjaman barang
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'kode', 'peminjam_id', 'peminjam_role', 'setuju_id', 'setuju_role',
        'barang_id', 'barang_nama', 'jumlah', 'tanggal_pinjam', 'tanggal_kembali', 'harus_kembali',
        'status', 'alasan', 'denda', 'kondisi_pinjam', 'kondisi_kembali',
        'qr_verifikasi', 'qr_code_short', 'qr_validated_at',
        'sarpras_status', 'sarpras_ref', 'sarpras_response', 'sarpras_checked_at', 'catatan'
    ];
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'harus_kembali' => 'date',
        'qr_validated_at' => 'datetime',
        'sarpras_checked_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'peminjam_id');
    }
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'setuju_id');
    }
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
    protected function qrValidatedAt(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (empty($value)) {
                    return null;
                }
                if (!$value instanceof \Carbon\Carbon) {
                    try {
                        return \Carbon\Carbon::parse($value);
                    } catch (\Exception $e) {
                        return null;
                    }
                }
                return $value;
            },
            set: function ($value) {
                if ($value instanceof \Carbon\Carbon) {
                    return $value->toDateTimeString();
                }
                return $value;
            }
        );
    }
    protected static function boot()
    {
        parent::boot();
        static::updating(function ($peminjaman) {
            if ($peminjaman->qr_validated_at && $peminjaman->isDirty('qr_validated_at')) {
                $peminjaman->status = 'dipinjam';
            }
        });
    }
}