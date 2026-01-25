@extends('layouts.admin')
@section('title', 'Manajemen Barang')

@php
$satuanOptions = [
    'unit' => 'Unit',
    'pcs'  => 'PCS',
    'set'  => 'Set'
];

$kondisiOptions = [
    'baik'        => 'Baik',
    'rusak ringan'=> 'Rusak Ringan',
    'rusak berat' => 'Rusak Berat'
];
@endphp

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-box-seam me-2"></i> Manajemen Barang
        </h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Barang
        </button>
    </div>

    {{-- ALERT --}}
    @foreach(['success','error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }} alert-dismissible fade show">
                {{ session($msg) }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- TABLE --}}
    <div class="card">
        <div class="card-header bg-white">
            <strong>Daftar Barang</strong>
            <span class="badge bg-secondary float-end">
                Total: {{ $barang->count() }}
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Merk</th>
                            <th>Kondisi</th>
                            <th>Stok</th>
                            <th>QR</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $b)
                        <tr>
                            <td>{{ $b->kode }}</td>
                            <td>
                                <strong>{{ $b->nama }}</strong><br>
                                <small class="text-muted">{{ $b->spesifikasi }}</small>
                            </td>
                            <td>{{ $b->kategori->nama ?? '-' }}</td>
                            <td>{{ $b->lokasi->nama ?? '-' }}</td>
                            <td>{{ $b->merk ?? '-' }}</td>
                            <td class="text-center">
                                @if($b->kondisi == 'baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif($b->kondisi == 'rusak ringan')
                                    <span class="badge bg-warning text-dark">Rusak Ringan</span>
                                @else
                                    <span class="badge bg-danger">Rusak Berat</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $b->stok }} {{ $b->satuan }}
                            </td>
                            <td class="text-center">
                                @if($b->qr_code)
                                    <img src="{{ asset($b->qr_code) }}" width="45"
                                         data-bs-toggle="modal"
                                         data-bs-target="#modalQR{{ $b->id }}"
                                         style="cursor:pointer">
                                @else
                                    <form method="POST" action="{{ route('barang.generate_qr',$b->id) }}">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-qr-code"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-warning"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $b->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" action="{{ route('barang.destroy',$b->id) }}"
                                          onsubmit="return confirm('Hapus barang ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Data barang belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL TAMBAH ================= --}}
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('barang.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Barang *</label>
                        <input type="text" name="nama" id="namaBarang" class="form-control" required
                               oninput="
                               let kode=this.value.replace(/[^A-Za-z]/g,'').toUpperCase().substring(0,5);
                               document.getElementById('kodeBarang').value=
                               kode+'-'+Math.floor(1000+Math.random()*9000)">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kode Barang *</label>
                        <input type="text" name="kode" id="kodeBarang" class="form-control" readonly required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kategori *</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lokasi *</label>
                        <select name="lokasi_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($lokasi as $l)
                                <option value="{{ $l->id }}">{{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Merk</label>
                        <input type="text" name="merk" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kondisi *</label>
                        <select name="kondisi" class="form-select" required>
                            @foreach($kondisiOptions as $v=>$l)
                                <option value="{{ $v }}">{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Stok *</label>
                        <input type="number" name="stok" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Satuan *</label>
                        <select name="satuan" class="form-select" required>
                            @foreach($satuanOptions as $v=>$l)
                                <option value="{{ $v }}">{{ $l }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Spesifikasi</label>
                        <textarea name="spesifikasi" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ================= MODAL EDIT ================= --}}
@foreach($barang as $b)
<div class="modal fade" id="modalEdit{{ $b->id }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('barang.update',$b->id) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode</label>
                        <input class="form-control" value="{{ $b->kode }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama *</label>
                        <input name="nama" class="form-control" value="{{ $b->nama }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Kategori *</label>
                        <select name="kategori_id" class="form-select" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ $b->kategori_id==$k->id?'selected':'' }}>
                                    {{ $k->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lokasi *</label>
                        <select name="lokasi_id" class="form-select" required>
                            @foreach($lokasi as $l)
                                <option value="{{ $l->id }}" {{ $b->lokasi_id==$l->id?'selected':'' }}>
                                    {{ $l->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Merk</label>
                        <input name="merk" class="form-control" value="{{ $b->merk }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Kondisi *</label>
                        <select name="kondisi" class="form-select" required>
                            @foreach($kondisiOptions as $v=>$l)
                                <option value="{{ $v }}" {{ $b->kondisi==$v?'selected':'' }}>
                                    {{ $l }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Stok *</label>
                        <input type="number" name="stok" class="form-control" value="{{ $b->stok }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Satuan *</label>
                        <select name="satuan" class="form-select" required>
                            @foreach($satuanOptions as $v=>$l)
                                <option value="{{ $v }}" {{ $b->satuan==$v?'selected':'' }}>
                                    {{ $l }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Spesifikasi</label>
                        <textarea name="spesifikasi" class="form-control" rows="3">{{ $b->spesifikasi }}</textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-warning">
                    <i class="bi bi-arrow-repeat me-1"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- ================= MODAL QR ================= --}}
@foreach($barang as $b)
@if($b->qr_code)
<div class="modal fade" id="modalQR{{ $b->id }}">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-header">
                <h6 class="modal-title">{{ $b->nama }}</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img src="{{ asset($b->qr_code) }}" class="img-fluid mb-2">
                <div>{{ $b->kode }}</div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach
@endsection
