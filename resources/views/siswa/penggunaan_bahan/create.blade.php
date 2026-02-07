@extends('layouts.siswa')
@section('title', 'Form Penggunaan Bahan')

@section('content')
<div class="container">
    <h4 class="mb-3">Form Penggunaan Bahan</h4>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    <form action="{{ route('siswa.penggunaan_bahan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Bahan</label>
            <select name="bahan_id" class="form-select" required>
                <option value="">-- Pilih Bahan --</option>
                @foreach($bahan as $b)
                    <option value="{{ $b->id }}">
                        {{ $b->nama }} (Stok: {{ $b->stok }} {{ $b->satuan ?? '' }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Guru Tujuan</label>
            <select name="guru_id" class="form-select" required>
                <option value="">-- Pilih Guru --</option>
                @foreach($guru as $g)
                    <option value="{{ $g->id }}">{{ $g->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Jumlah Digunakan</label>
            <input type="number" name="jumlah" class="form-control" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control" rows="3"></textarea>
        </div>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        <button class="btn btn-success">
            <i class="bi bi-check-circle"></i> Simpan
        </button>
        <a href="{{ route('siswa.penggunaan_bahan.index') }}" class="btn btn-secondary">
            Kembali
        </a>
    </form>
</div>
@endsection
