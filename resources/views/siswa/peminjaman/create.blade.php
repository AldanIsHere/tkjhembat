@extends('layouts.siswa')
@section('title', 'Form Peminjaman Barang')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-1">Form Peminjaman Barang</h4>
                    <p class="text-muted mb-0">Lengkapi data peminjaman dengan benar</p>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('siswa.peminjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                        <div class="border p-3 mb-4 bg-light">
                            <h6 class="fw-bold mb-2">Informasi Barang</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Nama Barang</small>
                                    <div class="fw-bold">{{ $barang->nama }}</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Stok Tersedia</small>
                                    <div class="fw-bold">{{ $barang->stok }}</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Kondisi</small>
                                    <div class="fw-bold">{{ $barang->kondisi }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Sistem Tanpa Persetujuan</strong><br>
                            Peminjaman akan langsung aktif setelah QR Code barang berhasil divalidasi.
                            Guru yang dipilih hanya untuk informasi/monitoring.
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">
                                Guru Tujuan (Untuk Informasi)
                            </label>
                            <select name="setuju_id" class="form-select" required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}">
                                        {{ $g->nama }} ({{ $g->jabatan ?? 'Guru' }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hanya untuk informasi, tidak memerlukan persetujuan</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Jumlah Pinjam</label>
                            <input type="number"
                                   name="jumlah"
                                   class="form-control"
                                   min="1"
                                   max="{{ $barang->stok }}"
                                   value="1"
                                   required>
                            <small class="text-muted">Maksimal: {{ $barang->stok }} unit</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Pinjam</label>
                                <input type="date"
                                       name="tanggal_pinjam"
                                       class="form-control"
                                       value="{{ date('Y-m-d') }}"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tanggal Kembali</label>
                                <input type="date"
                                       name="tanggal_kembali"
                                       class="form-control"
                                       required>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan (Opsional)</label>
                            <textarea name="catatan"
                                      rows="3"
                                      class="form-control"
                                      placeholder="Contoh: digunakan untuk praktikum jaringan..."></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('siswa.peminjaman.barang') }}"
                               class="btn btn-outline-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-success px-4">
                                Buat Peminjaman & Generate QR
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const today = new Date().toISOString().split('T')[0];
    const tanggalPinjam = document.querySelector('input[name="tanggal_pinjam"]');
    const tanggalKembali = document.querySelector('input[name="tanggal_kembali"]');
    tanggalPinjam.min = today;
    tanggalPinjam.addEventListener('change', function() {
        tanggalKembali.min = this.value;
        if (tanggalKembali.value < this.value) {
            tanggalKembali.value = this.value;
        }
    });
    const nextWeek = new Date();
    nextWeek.setDate(nextWeek.getDate() + 7);
    tanggalKembali.value = nextWeek.toISOString().split('T')[0];
    tanggalKembali.min = today;
});
</script>
@endsection