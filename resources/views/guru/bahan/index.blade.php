@extends('layouts.guru')
@section('title', 'Penggunaan Bahan Siswa')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Penggunaan Bahan oleh Siswa</h4>
    </div>

    <div class="card border-1 shadow-sm shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="60">No</th>
                            <th>Kode</th>
                            <th>Siswa</th>
                            <th>Bahan</th>
                            <th width="90">Jumlah</th>
                            <th width="130">Tanggal</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penggunaan as $i => $p)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $p->kode }}</td>
                            <td>{{ $p->siswa->nama ?? '-' }}</td>
                            <td>{{ $p->bahan_nama }}</td>
                            <td class="text-center">{{ $p->jumlah }}</td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}
                            </td>
                            <td>{{ $p->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
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
