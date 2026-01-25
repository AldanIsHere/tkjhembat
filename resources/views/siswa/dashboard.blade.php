@extends('layouts.siswa')
@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Selamat Datang {{ session('user_name') }}</h1>
    <p>Ini adalah halaman dashboard siswa.</p>

    <div class="mt-4">
        <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-primary">Lihat Peminjaman</a>
        <a href="{{ route('siswa.profile') }}" class="btn btn-secondary">Profil Saya</a>
    </div>
</div>
@endsection
