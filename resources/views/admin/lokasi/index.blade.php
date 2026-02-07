@extends('layouts.admin')
@section('title', 'Manajemen Lokasi')
@section('content')
@php
use App\Models\Barang;
use App\Models\Bahan;
@endphp
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="bi bi-geo-alt me-2"></i> Manajemen Lokasi
        </h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Lokasi
        </button>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    <div class="row">
        @foreach($lokasi as $l)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card h-100 shadow-sm shadow-lg border-1">
                <div class="card-body text-center">
                    <img src="{{ $l->foto_penanggung_jawab
                        ? asset('uploads/foto_penanggung_jawab/'.$l->foto_penanggung_jawab)
                        : asset('assets/img/default-user.png') }}"
                        class="rounded-circle mb-3 border"
                        width="90" height="90"
                        style="object-fit:cover;cursor:pointer"
                        data-bs-toggle="modal"
                        data-bs-target="#modalFoto{{ $l->id }}">
                    <h6 class="fw-semibold">{{ $l->nama }}</h6>
                    @if($l->penanggung_jawab)
                    <small class="text-muted">
                        <i class="bi bi-person-badge"></i> {{ $l->penanggung_jawab }}
                    </small>
                    @endif
                </div>
                <div class="card-footer bg-white text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-outline-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalIsi{{ $l->id }}"
                            title="Lihat Isi Lokasi">
                            <i class="bi bi-box-seam"></i>
                        </button>
                        <button class="btn btn-outline-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit{{ $l->id }}"
                            title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <form action="{{ route('lokasi.destroy',$l->id) }}" method="POST"
                            onsubmit="return confirm('Hapus lokasi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</div>
@foreach($lokasi as $l)
@php
$barang = Barang::where('lokasi_id', $l->id)->get();
$bahan  = Bahan::where('lokasi_id', $l->id)->get();
@endphp
<div class="modal fade" id="modalIsi{{ $l->id }}">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    <i class="bi bi-archive me-2"></i>
                    Isi Lokasi: {{ $l->nama }}
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3">
                    <li class="nav-item">
                        <button class="nav-link active"
                                data-bs-toggle="tab"
                                data-bs-target="#barang{{ $l->id }}">
                            Barang ({{ $barang->count() }})
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#bahan{{ $l->id }}">
                            Bahan ({{ $bahan->count() }})
                        </button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="barang{{ $l->id }}">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Merk</th>
                                    <th>Spesifikasi</th>
                                    <th>Stok</th>
                                    <th>Kondisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($barang as $b)
                                <tr>
                                    <td>{{ $b->kode }}</td>
                                    <td>{{ $b->nama }}</td>
                                    <td>{{ $b->merk ?? '-' }}</td>
                                    <td>{{ $b->spesifikasi ?? '-' }}</td>
                                    <td>{{ $b->stok }} {{ $b->satuan }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $b->kondisi ?? '-' }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Tidak ada barang
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="bahan{{ $l->id }}">
                        <table class="table table-bordered table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Stok</th>
                                    <th>Satuan</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bahan as $bh)
                                <tr>
                                    <td>{{ $bh->kode }}</td>
                                    <td>{{ $bh->nama }}</td>
                                    <td>{{ $bh->stok }}</td>
                                    <td>{{ $bh->satuan }}</td>
                                    <td>{{ $bh->keterangan ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Tidak ada bahan
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>
@endforeach
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-3">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-semibold">
                    <i class="bi bi-geo-plus me-2"></i> Tambah Lokasi
                </h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('lokasi.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lokasi *</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Foto Penanggung Jawab</label>
                        <input type="file" name="foto_penanggung_jawab" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@foreach($lokasi as $l)
<div class="modal fade" id="modalEdit{{ $l->id }}">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-3">
            <form method="POST" action="{{ route('lokasi.update',$l->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header bg-light">
                    <h5 class="modal-title">Edit Lokasi</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lokasi *</label>
                        <input type="text" name="nama" value="{{ $l->nama }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Penanggung Jawab</label>
                        <input type="text" name="penanggung_jawab" value="{{ $l->penanggung_jawab }}" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control">{{ $l->keterangan }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Foto Penanggung Jawab</label>
                        <input type="file" name="foto_penanggung_jawab" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="modalFoto{{ $l->id }}">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h6 class="modal-title">{{ $l->nama }}</h6>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ $l->foto_penanggung_jawab
                    ? asset('uploads/foto_penanggung_jawab/'.$l->foto_penanggung_jawab)
                    : asset('assets/img/default-user.png') }}"
                    class="img-fluid border mb-2">
                <p class="mb-0 fw-semibold">{{ $l->penanggung_jawab }}</p>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
