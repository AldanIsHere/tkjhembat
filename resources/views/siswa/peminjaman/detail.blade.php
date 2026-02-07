@extends('layouts.guru')
@section('title', 'Detail Peminjaman')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Detail Peminjaman</h4>
        <a href="{{ route('guru.peminjaman.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                Informasi detail peminjaman untuk monitoring. Sistem berjalan tanpa persetujuan guru.
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3 border-bottom pb-2">Informasi Peminjaman</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Kode Peminjaman</th>
                            <td>{{ $peminjaman->kode }}</td>
                        </tr>
                        <tr>
                            <th>Nama Siswa</th>
                            <td>{{ $peminjaman->siswa->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Barang</th>
                            <td>{{ $peminjaman->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah</th>
                            <td>{{ $peminjaman->jumlah }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($peminjaman->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($peminjaman->status == 'dipinjam')
                                    <span class="badge bg-success">Dipinjam</span>
                                @elseif($peminjaman->status == 'dikembalikan')
                                    <span class="badge bg-info">Dikembalikan</span>
                                @elseif($peminjaman->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-3 border-bottom pb-2">Waktu & Validasi</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Tanggal Pinjam</th>
                            <td>{{ date('d/m/Y', strtotime($peminjaman->tanggal_pinjam)) }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Kembali</th>
                            <td>{{ date('d/m/Y', strtotime($peminjaman->tanggal_kembali)) }}</td>
                        </tr>
                        <tr>
                            <th>Harus Kembali</th>
                            <td>{{ date('d/m/Y', strtotime($peminjaman->harus_kembali)) }}</td>
                        </tr>
                        <tr>
                            <th>QR Validasi</th>
                            <td>
                                @if($peminjaman->qr_validated_at)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> {{ date('d/m/Y H:i', strtotime($peminjaman->qr_validated_at)) }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Belum divalidasi</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ date('d/m/Y H:i', strtotime($peminjaman->created_at)) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($peminjaman->catatan)
            <div class="row mt-3">
                <div class="col-12">
                    <h5 class="mb-3 border-bottom pb-2">Catatan</h5>
                    <div class="border p-3 bg-light rounded">
                        {{ $peminjaman->catatan }}
                    </div>
                </div>
            </div>
            @endif    
            @if($peminjaman->kondisi_kembali)
            <div class="row mt-3">
                <div class="col-12">
                    <h5 class="mb-3 border-bottom pb-2">Kondisi Pengembalian</h5>
                    <div class="alert alert-warning">
                        <strong>Kondisi Saat Kembali:</strong> {{ $peminjaman->kondisi_kembali }}
                        <br>
                        <small class="text-muted">
                            Kondisi saat pinjam: {{ $peminjaman->kondisi_pinjam ?? 'Baik' }}
                        </small>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection