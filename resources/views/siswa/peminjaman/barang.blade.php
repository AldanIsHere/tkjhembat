@extends('layouts.siswa')
@section('title', 'Daftar Barang')

@section('content')
<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Daftar Barang Tersedia</h4>
            <small class="text-muted">Pilih barang yang ingin dipinjam</small>
        </div>
        <div class="badge bg-light text-dark border px-3 py-2 rounded-pill">
            <i class="fas fa-boxes me-1"></i> {{ count($barang) }} Barang
        </div>
    </div>

    {{-- GRID BARANG --}}
    <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 g-4">

        @forelse($barang as $b)
        <div class="col">
            <div class="card h-100 rounded-4 overflow-hidden barang-card shadow-sm shadow-lg">

                {{-- CARD HEADER --}}
                <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-normal small">
                            {{ $b->kode }}
                        </span>
                        <div class="text-end">
                            <div class="h5 mb-0 fw-bold">{{ $b->stok }}</div>
                            <small class="text-muted small">Stok</small>
                        </div>
                    </div>
                </div>

                {{-- CARD BODY --}}
                <div class="card-body d-flex flex-column pt-2 pb-3">

                    {{-- NAMA BARANG --}}
                    <h6 class="fw-bold text-dark mb-1 line-clamp-2" title="{{ $b->nama }}">
                        {{ $b->nama }}
                    </h6>

                    {{-- MERK --}}
                    @if($b->merk)
                        <div class="mb-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25">
                                {{ $b->merk }}
                            </span>
                        </div>
                    @endif

                    {{-- SPESIFIKASI --}}
                    @if($b->spesifikasi)
                        <div class="mb-3">
                            <small class="text-muted d-block mb-1">Spesifikasi</small>
                            <div class="text-secondary small line-clamp-3" title="{{ $b->spesifikasi }}">
                                {{ $b->spesifikasi }}
                            </div>
                        </div>
                    @endif

                    {{-- KONDISI --}}
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Kondisi</small>
                        <span class="badge py-1 px-2 rounded-1 fw-normal 
                            @if($b->kondisi == 'Baik') bg-success bg-opacity-10 text-success border border-success border-opacity-25
                            @elseif($b->kondisi == 'Rusak Ringan') bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25
                            @elseif($b->kondisi == 'Rusak Berat') bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25
                            @else bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25
                            @endif">
                            {{ $b->kondisi ?? 'Tidak Diketahui' }}
                        </span>
                    </div>

                </div>

                {{-- CARD FOOTER --}}
                <div class="card-footer bg-white border-top-0 pt-0">
                    @if($b->stok > 0)
                        <a href="{{ route('siswa.peminjaman.create', $b->id) }}"
                           class="btn btn-primary w-100 rounded-2 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-cart-plus"></i>
                            Pinjam Barang
                        </a>
                    @else
                        <button class="btn btn-light w-100 rounded-2 fw-semibold text-muted" disabled>
                            <i class="fas fa-times-circle me-1"></i>
                            Stok Habis
                        </button>
                    @endif
                </div>

                {{-- STATUS INDICATOR --}}
                <div class="position-absolute top-0 end-0 mt-3 me-3">
                    @if($b->stok > 0)
                        <span class="badge bg-success bg-opacity-90 text-white rounded-pill px-2 py-1 small shadow-sm">
                            <i class="fas fa-check-circle me-1"></i> Tersedia
                        </span>
                    @else
                        <span class="badge bg-danger bg-opacity-90 text-white rounded-pill px-2 py-1 small shadow-sm">
                            <i class="fas fa-times-circle me-1"></i> Habis
                        </span>
                    @endif
                </div>

            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="fas fa-box-open text-muted fa-3x"></i>
                    </div>
                    <h5 class="fw-bold text-muted mb-2">Tidak ada barang tersedia</h5>
                    <p class="text-muted mb-0">Silakan coba lagi nanti</p>
                </div>
            </div>
        </div>
        @endforelse

    </div>

</div>
@endsection

@push('styles')
<style>
/* ================= CARD DEPTH ================= */
.barang-card {
    border: 1px solid rgba(0,0,0,0.08);
    background: linear-gradient(135deg, #ffffff 0%, #fafbfc 100%);
    box-shadow: 0 4px 14px rgba(0,0,0,0.08);
    transition: all 0.25s ease;
    position: relative;
}

.barang-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    border-color: rgba(13,110,253,0.2);
}

/* ================= TEXT CLAMP ================= */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.8em;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ================= BUTTON ================= */
.btn-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    border: none;
}

.btn-primary:hover {
    box-shadow: 0 6px 16px rgba(13,110,253,0.35);
    transform: translateY(-1px);
}
</style>
@endpush
