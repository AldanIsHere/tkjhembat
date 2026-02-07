@extends('layouts.admin')
@section('title', 'Laporan Penggunaan Bahan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-clipboard-check me-2"></i>
            Laporan Penggunaan Bahan
        </h4>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        <div class="d-flex gap-2">
            <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
               class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </a>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Siswa</th>
                        <th>Guru</th>
                        <th>Bahan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Tanggal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penggunaanBahan as $b)
                        <tr>
                            <td>{{ $b->kode }}</td>
                            <td>{{ $b->siswa->nama ?? '-' }}</td>
                            <td>{{ $b->guru->nama ?? '-' }}</td>
                            <td>{{ $b->bahan->nama ?? $b->bahan_nama ?? '-' }}</td>
                            <td class="text-center">{{ $b->jumlah }}</td>
                            <td class="text-center">{{ $b->tanggal }}</td>
                            <td>{{ $b->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data penggunaan bahan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
</div>
@endsection
