@extends('layouts.siswa')
@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Daftar Peminjaman</h4>

        <a href="{{ route('siswa.peminjaman.barang') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Pinjam Baru
        </a>
    </div>

    {{-- FILTER STATUS --}}
    <div class="mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Semua Status --</option>
                    <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="disetujui" {{ ($status ?? '') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="dipinjam" {{ ($status ?? '') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="dikembalikan" {{ ($status ?? '') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="ditolak" {{ ($status ?? '') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
        </form>
    </div>

    <div class="card shadow-sm shadow-lg bordedr-1">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Kode</th>
                            <th>Barang</th>
                            <th width="80">Jumlah</th>
                            <th width="130">Status</th>
                            <th width="140">Tanggal Pinjam</th>
                            <th width="220">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $p)
                        <tr>
                            <td>{{ $p->kode }}</td>
                            <td>{{ $p->barang_nama }}</td>
                            <td class="text-center">{{ $p->jumlah }}</td>
                            <td class="text-center">
                                <span class="badge bg-{{ 
                                    $p->status == 'pending' ? 'warning' :
                                    ($p->status == 'dipinjam' ? 'success' :
                                    ($p->status == 'dikembalikan' ? 'primary' :
                                    ($p->status == 'ditolak' ? 'danger' : 'secondary')))
                                }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="text-center">{{ $p->tanggal_pinjam }}</td>
                            <td class="text-center">
                                <a href="{{ route('siswa.peminjaman.detail', $p->id) }}"
                                   class="btn btn-info btn-sm mb-1">
                                    Detail
                                </a>

                                @if($p->status == 'pending' && !$p->qr_validated_at)
                                    <a href="{{ route('siswa.peminjaman.scan_qr', $p->id) }}"
                                       class="btn btn-warning btn-sm mb-1">
                                        Scan QR
                                    </a>
                                @endif

                                @if($p->status == 'dipinjam')
                                    <a href="{{ route('siswa.peminjaman.return', $p->id) }}"
                                       class="btn btn-success btn-sm mb-1">
                                        Kembalikan
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada data peminjaman
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
