@extends('layouts.siswa')
@section('title', 'Detail Penggunaan Bahan')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Detail Penggunaan Bahan</h4>

    <div class="card shadow-sm shadow-lg border-1">
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th width="200">Kode</th>
                    <td>: {{ $penggunaan->kode }}</td>
                </tr>
                <tr>
                    <th>Bahan</th>
                    <td>: {{ $penggunaan->bahan_nama }}</td>
                </tr>
                <tr>
                    <th>Guru Tujuan</th>
                    <td>: {{ $penggunaan->guru->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>: {{ $penggunaan->jumlah }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>: {{ $penggunaan->tanggal }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>: {{ $penggunaan->keterangan ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <a href="{{ route('siswa.penggunaan_bahan.index') }}" class="btn btn-secondary mt-3">
        Kembali
    </a>

</div>
@endsection
