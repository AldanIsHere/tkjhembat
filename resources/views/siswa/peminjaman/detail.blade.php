@extends('layouts.siswa')
@section('title', 'Detail Peminjaman')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Detail Peminjaman</h4>

    <div class="card shadow-sm shadow-lg border-1">
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tr>
                    <th width="220">Kode</th>
                    <td>: {{ $peminjaman->kode }}</td>
                </tr>
                <tr>
                    <th>Barang</th>
                    <td>: {{ $peminjaman->barang_nama }}</td>
                </tr>
                <tr>
                    <th>Jumlah</th>
                    <td>: {{ $peminjaman->jumlah }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        : <span class="badge bg-{{ 
                            $peminjaman->status == 'pending' ? 'warning' :
                            ($peminjaman->status == 'dipinjam' ? 'success' :
                            ($peminjaman->status == 'dikembalikan' ? 'primary' :
                            ($peminjaman->status == 'ditolak' ? 'danger' : 'secondary')))
                        }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tanggal Pinjam</th>
                    <td>: {{ $peminjaman->tanggal_pinjam }}</td>
                </tr>
                <tr>
                    <th>Harus Kembali</th>
                    <td>: {{ $peminjaman->harus_kembali }}</td>
                </tr>
                <tr>
                    <th>Kondisi Saat Dipinjam</th>
                    <td>: {{ $peminjaman->kondisi_pinjam }}</td>
                </tr>
                <tr>
                    <th>Kondisi Saat Dikembalikan</th>
                    <td>: {{ $peminjaman->kondisi_kembali ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status QR</th>
                    <td>
                        :
                        @if($peminjaman->qr_validated_at)
                            <span class="badge bg-success">
                                Sudah divalidasi ({{ $peminjaman->qr_validated_at }})
                            </span>
                        @else
                            <span class="badge bg-warning text-dark">
                                Belum divalidasi
                            </span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-secondary mt-3">
        Kembali
    </a>

</div>
@endsection
