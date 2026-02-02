@extends('layouts.siswa')
@section('title', 'QR Berhasil Divalidasi')

@section('content')
<div class="container">
    <h2>QR Berhasil Divalidasi!</h2>
    <p>Peminjaman barang Anda telah berhasil divalidasi dan siap dikirim ke guru untuk persetujuan.</p>
    <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-success">Kembali ke Daftar Peminjaman</a>

</div>
@endsection
