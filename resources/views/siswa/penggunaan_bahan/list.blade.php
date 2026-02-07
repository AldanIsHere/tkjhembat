@extends('layouts.siswa')
@section('title', 'Daftar Bahan & Stok')
<<<<<<< HEAD
@section('content')
<div class="container">
    <h2>Daftar Bahan Tersedia</h2>
=======

@section('content')
<div class="container">
    <h2>Daftar Bahan Tersedia</h2>

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Bahan</th>
                <th>Stok</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bahan as $b)
            <tr>
                <td>{{ $b->kode }}</td>
                <td>{{ $b->nama }}</td>
                <td>{{ $b->stok }}</td>
                <td>{{ $b->kondisi }}</td>
                <td>
                    @if($b->stok > 0)
                        <a href="{{ route('siswa.penggunaan_bahan.create', $b->id) }}" class="btn btn-primary btn-sm">Gunakan</a>
                    @else
                        <span class="badge bg-danger">Habis</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
