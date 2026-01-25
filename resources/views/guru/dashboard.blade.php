@extends('layouts.guru')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h2>Selamat datang, {{ session('user_name') }}</h2>
    <p>Ini adalah panel guru untuk mengelola peminjaman dan penggunaan bahan.</p>

    <div class="row mt-4">
        <div class="col-md-6 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Peminjaman</h5>
                    <p class="card-text">Lihat semua peminjaman siswa.</p>
                    <a href="{{ route('guru.peminjaman.index') }}" class="btn btn-light">Lihat Peminjaman</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Penggunaan Bahan</h5>
                    <p class="card-text">Kelola penggunaan bahan siswa.</p>
                    <a href="{{ route('guru.penggunaan_bahan.index') }}" class="btn btn-light">Lihat Bahan</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
