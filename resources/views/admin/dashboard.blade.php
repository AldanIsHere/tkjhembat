@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h3 class="fw-semibold">
        <i class="bi bi-speedometer2"></i> Dashboard Admin
    </h3>
    <p class="text-muted mb-0">Ringkasan data sistem inventaris</p>
</div>

<div class="row g-4">
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card shadow-sm shadow-lg border-1">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-primary fs-2">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Barang</div>
                    <h4 class="mb-0 fw-bold">{{ $totalBarang }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card shadow-sm shadow-lg border-1">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-success fs-2">
                    <i class="bi bi-arrow-left-right"></i>
                </div>
                <div>
                    <div class="text-muted small">Peminjaman</div>
                    <h4 class="mb-0 fw-bold">{{ $totalPeminjaman }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card shadow-sm shadow-lg border-1">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-info fs-2">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <div class="text-muted small">Siswa</div>
                    <h4 class="mb-0 fw-bold">{{ $totalSiswa }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card shadow-sm shadow-lg border-1">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-warning fs-2">
                    <i class="bi bi-person-badge"></i>
                </div>
                <div>
                    <div class="text-muted small">Guru</div>
                    <h4 class="mb-0 fw-bold">{{ $totalGuru }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card shadow-sm shadow-lg border-1">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-secondary fs-2">
                    <i class="bi bi-droplet-half"></i>
                </div>
                <div>
                    <div class="text-muted small">Bahan</div>
                    <h4 class="mb-0 fw-bold">{{ $totalBahan }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
        <div class="card shadow-sm shadow-lg border-1">
            <div class="card-body d-flex align-items-center">
                <div class="me-3 text-danger fs-2">
                    <i class="bi bi-clipboard-check"></i>
                </div>
                <div>
                    <div class="text-muted small">Pemakaian Bahan</div>
                    <h4 class="mb-0 fw-bold">{{ $totalPenggunaanBahan }}</h4>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
