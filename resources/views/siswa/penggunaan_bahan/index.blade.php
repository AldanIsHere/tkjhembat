@extends('layouts.siswa')
@section('title', 'Penggunaan Bahan')
<<<<<<< HEAD
@section('content')
<div class="container-fluid">
=======

@section('content')
<div class="container-fluid">

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Riwayat Penggunaan Bahan</h4>

        <a href="{{ route('siswa.penggunaan_bahan.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Gunakan Bahan
        </a>
    </div>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    <div class="card shadow-sm shadow-lg bordedr-1">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Kode</th>
                            <th>Bahan</th>
                            <th>Guru</th>
                            <th width="90">Jumlah</th>
                            <th width="140">Tanggal</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penggunaan as $p)
                        <tr>
                            <td>{{ $p->kode }}</td>
                            <td>{{ $p->bahan_nama }}</td>
                            <td>{{ $p->guru->nama ?? '-' }}</td>
                            <td class="text-center">{{ $p->jumlah }}</td>
                            <td class="text-center">{{ $p->tanggal }}</td>
                            <td class="text-center">
                                <a href="{{ route('siswa.penggunaan_bahan.detail', $p->id) }}"
                                   class="btn btn-info btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data penggunaan bahan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
