@extends('layouts.guru')
@section('title', 'Detail Peminjaman')

@section('content')
<div class="container">
    <h2>Detail Peminjaman</h2>
    <table class="table table-bordered mt-3">
        <tr><th>Kode</th><td>{{ $peminjaman->kode }}</td></tr>
        <tr><th>Siswa</th><td>{{ $peminjaman->siswa->nama ?? '-' }}</td></tr>
        <tr><th>Barang</th><td>{{ $peminjaman->barang_nama }}</td></tr>
        <tr><th>Jumlah</th><td>{{ $peminjaman->jumlah }}</td></tr>
        <tr><th>Status</th><td>{{ ucfirst($peminjaman->status) }}</td></tr>
        <tr><th>QR Valid</th>
            <td>{{ $peminjaman->qr_validated_at ?? 'Belum' }}</td>
        </tr>
    </table>
    <a href="{{ route('guru.peminjaman.index') }}" class="btn btn-secondary">
        Kembali
    </a>
</div>
@endsection
