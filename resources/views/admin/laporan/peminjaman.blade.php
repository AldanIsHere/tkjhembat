@extends('layouts.admin')
@section('title', 'Laporan Peminjaman')

@php
    $statusConfig = [
        'pending'      => ['color' => 'warning', 'icon' => 'bi-clock', 'label' => 'Pending'],
        'disetujui'    => ['color' => 'primary', 'icon' => 'bi-check-square', 'label' => 'Disetujui'],
        'dipinjam'     => ['color' => 'info', 'icon' => 'bi-box-arrow-in-right', 'label' => 'Dipinjam'],
        'dikembalikan' => ['color' => 'success', 'icon' => 'bi-check-circle', 'label' => 'Dikembalikan'],
        'ditolak'      => ['color' => 'danger', 'icon' => 'bi-x-circle', 'label' => 'Ditolak'],
    ];

    $getStatusConfig = function ($status) use ($statusConfig) {
        return $statusConfig[$status] ?? [
            'color' => 'secondary',
            'icon'  => 'bi-question-circle',
            'label' => ucfirst($status)
        ];
    };
@endphp

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-clipboard-data me-2"></i>
            Laporan Peminjaman Barang
        </h4>

        <div class="d-flex gap-2">
            <a href="{{ request()->fullUrlWithQuery(['export' => 'excel']) }}"
               class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </a>

            <button onclick="window.print()" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-printer me-1"></i> Cetak
            </button>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        @foreach($statusConfig as $key => $cfg)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                {{ $cfg['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Mulai</label>
                    <input type="date"
                           name="start_date"
                           class="form-control"
                           value="{{ request('start_date') }}"
                           onchange="this.form.submit()">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Tanggal Akhir</label>
                    <input type="date"
                           name="end_date"
                           class="form-control"
                           value="{{ request('end_date') }}"
                           onchange="this.form.submit()">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('admin.laporan.peminjaman') }}"
                       class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Kode</th>
                        <th>Siswa</th>
                        <th>Barang</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-center">Status</th>
                        <th>Guru</th>
                        <th class="text-center">Tanggal Pinjam</th>
                        <th class="text-center">Tanggal Kembali</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($peminjaman as $p)
                    @php $status = $getStatusConfig($p->status); @endphp
                    <tr>
                        <td>{{ $p->kode }}</td>

                        <td>
                            {{ $p->siswa->nama ?? '-' }}<br>
                            <small class="text-muted">{{ $p->siswa->nis ?? '' }}</small>
                        </td>

                        <td>
                            {{ $p->barang->nama ?? $p->barang_nama }}<br>
                            <small class="text-muted">{{ $p->barang->kode ?? '' }}</small>
                        </td>

                        <td class="text-center">{{ $p->jumlah }}</td>

                        <td class="text-center">
                            <span class="badge bg-{{ $status['color'] }}">
                                <i class="bi {{ $status['icon'] }} me-1"></i>
                                {{ $status['label'] }}
                            </span>
                        </td>

                        <td>
                            {{ $p->guru->nama ?? 'Belum ditangani' }}
                        </td>

                        <td class="text-center">
                            {{ $p->tanggal_pinjam }}<br>
                            <small class="text-muted">{{ $p->jam_pinjam }}</small>
                        </td>

                        <td class="text-center">
                            @if($p->tanggal_kembali)
                                {{ $p->tanggal_kembali }}<br>
                                <small class="text-muted">{{ $p->jam_kembali }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Tidak ada data peminjaman
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
