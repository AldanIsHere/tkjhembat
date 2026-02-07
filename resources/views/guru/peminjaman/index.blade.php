@extends('layouts.guru')
@section('title', 'Daftar Peminjaman')
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Peminjaman Siswa</h4>
<<<<<<< HEAD
        <div class="text-muted">
            Total: {{ $peminjaman->count() }} peminjaman
        </div>
=======
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
<<<<<<< HEAD
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
=======
    <div class="card border-1 shadow-sm shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Kode</th>
                            <th>Siswa</th>
                            <th>Barang</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal Pinjam</th>
                            <th width="180">Aksi</th>
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
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
<<<<<<< HEAD
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
=======
                                <span class="badge 
                                    bg-{{ $p->status == 'pending' ? 'warning' : ($p->status == 'dipinjam' ? 'success' : 'danger') }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $p->tanggal_pinjam }}</td>
                            <td class="text-center">
                                <a href="{{ route('guru.peminjaman.show', $p->id) }}"
                                   class="btn btn-info btn-sm mb-1">
                                    Detail
                                </a>
                                @if($p->status == 'pending')
                                    <form action="{{ route('guru.peminjaman.approve', $p->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm mb-1">
                                            Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('guru.peminjaman.reject', $p->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm mb-1">
                                            Tolak
                                        </button>
                                    </form>
                                @endif
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
                            </td>
                        </tr>
                        @empty
                        <tr>
<<<<<<< HEAD
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                Belum ada siswa yang memilih Anda sebagai guru tujuan
=======
                            <td colspan="7" class="text-center text-muted py-4">
                                Tidak ada peminjaman untuk Anda
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
<<<<<<< HEAD
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
=======
        </div>
    </div>
</div>
@endsection
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
