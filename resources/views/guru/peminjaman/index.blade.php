@extends('layouts.guru')
@section('title', 'Daftar Peminjaman')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Peminjaman Siswa</h4>
        <div class="text-muted">
            Total: {{ $peminjaman->count() }} peminjaman
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Kode</th>
                            <th>Siswa</th>
                            <th>Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal Pinjam</th>
                            <th class="text-center">QR Valid</th>
                            <th class="text-center" width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $p)
                        <tr>
                            <td class="text-center">{{ $p->kode }}</td>
                            <td>{{ $p->siswa->nama ?? '-' }}</td>
                            <td>{{ $p->barang_nama }}</td>
                            <td class="text-center">{{ $p->jumlah }}</td>
                            <td class="text-center">
                                @if($p->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($p->status == 'dipinjam')
                                    <span class="badge bg-success">Dipinjam</span>
                                @elseif($p->status == 'dikembalikan')
                                    <span class="badge bg-info">Dikembalikan</span>
                                @elseif($p->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($p->tanggal_pinjam)) }}</td>
                            <td class="text-center">
                                @if($p->qr_validated_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> {{ date('d/m/Y', strtotime($p->qr_validated_at)) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Belum</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('guru.peminjaman.show', $p->id) }}"
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                Belum ada siswa yang memilih Anda sebagai guru tujuan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($peminjaman->count() > 0)
            <div class="mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-warning">Pending: {{ $peminjaman->where('status', 'pending')->count() }}</span>
                            <span class="badge bg-success">Dipinjam: {{ $peminjaman->where('status', 'dipinjam')->count() }}</span>
                            <span class="badge bg-info">Dikembalikan: {{ $peminjaman->where('status', 'dikembalikan')->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection