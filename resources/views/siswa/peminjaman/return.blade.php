@extends('layouts.siswa')
@section('title', 'Pengembalian Barang')
<<<<<<< HEAD
@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Form Pengembalian Barang</h4>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3">
                        Barang: <strong>{{ $peminjaman->barang_nama }}</strong>
                    </h6>
                    <form action="{{ route('siswa.peminjaman.return.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $peminjaman->id }}">
=======

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Form Pengembalian Barang</h4>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">
                <div class="card-body">

                    <h6 class="mb-3">
                        Barang: <strong>{{ $peminjaman->barang_nama }}</strong>
                    </h6>

                    <form action="{{ route('siswa.peminjaman.return.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $peminjaman->id }}">

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
                        <div class="mb-3">
                            <label for="kondisi_kembali" class="form-label">
                                Kondisi Barang Saat Dikembalikan
                            </label>
                            <input
                                type="text"
                                name="kondisi_kembali"
                                id="kondisi_kembali"
                                class="form-control"
                                value="Baik"
                                required
                            >
                        </div>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">
                                Kembalikan Barang
                            </button>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
                            <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
<<<<<<< HEAD
                </div>
            </div>
        </div>
    </div>
=======

                </div>
            </div>

        </div>
    </div>

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
</div>
@endsection
