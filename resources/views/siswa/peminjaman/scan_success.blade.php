@extends('layouts.siswa')
@section('title', 'QR Berhasil Divalidasi')
<<<<<<< HEAD
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <div class="rounded-circle bg-success d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-check fa-2x text-white"></i>
                        </div>
                    </div>
                    <h2 class="text-success mb-3">QR Berhasil Divalidasi!</h2>
                    <p class="text-muted mb-4">
                        Peminjaman barang <strong>{{ $peminjaman->barang_nama }}</strong> 
                        telah berhasil divalidasi dengan QR Code.
                    </p>
                    <div class="alert alert-light border mb-4">
                        <div class="row text-start">
                            <div class="col-6">
                                <small class="text-muted d-block">Kode Peminjaman</small>
                                <strong>{{ $peminjaman->kode }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Waktu Validasi</small>
                                <strong>{{ $peminjaman->qr_validated_at->format('d/m/Y H:i') }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Peminjaman Anda akan diproses oleh guru untuk persetujuan.
                        Anda dapat mengecek status di halaman daftar peminjaman.
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-list me-2"></i>Kembali ke Daftar Peminjaman
                        </a>
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.card {
    border-radius: 12px;
}
.btn-lg {
    padding: 12px 24px;
}
</style>
@endsection
=======

@section('content')
<div class="container">
    <h2>QR Berhasil Divalidasi!</h2>
    <p>Peminjaman barang Anda telah berhasil divalidasi dan siap dikirim ke guru untuk persetujuan.</p>
    <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-success">Kembali ke Daftar Peminjaman</a>

</div>
@endsection
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
