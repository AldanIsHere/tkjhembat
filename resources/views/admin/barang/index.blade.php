@extends('layouts.admin')
@section('title', 'Manajemen Barang')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">
            <i class="bi bi-box-seam me-2"></i> Manajemen Barang
        </h4>
        
        <div class="btn-group">
            <a href="{{ route('barang.scan') }}" class="btn btn-success">
                <i class="bi bi-qr-code-scan me-1"></i> Scan QR SARPRAS
            </a>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-circle me-1"></i> Barang Lokal
            </button>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-x-circle me-2"></i>{{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <strong>Daftar Barang</strong>
                <div>
                    <span class="badge bg-primary me-2">
                        SARPRAS: {{ $barang->where('tipe', 'sarpras')->count() }}
                    </span>
                    <span class="badge bg-secondary">
                        LOKAL: {{ $barang->where('tipe', 'lokal')->count() }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="50">No</th>
                            <th width="80">Foto</th>
                            <th>Kode</th>
                            <th>Nama & Spesifikasi</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Tipe</th>
                            <th width="100">Kondisi</th>
                            <th width="80">Stok</th>
                            <th width="100">QR</th>
                            <th width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $i => $b)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td class="text-center">
                                @if($b->foto)
                                    <img src="{{ $b->foto }}" 
                                         alt="Foto {{ $b->nama }}" 
                                         class="img-thumbnail" 
                                         style="width: 60px; height: 60px; object-fit: cover;"
                                         data-bs-toggle="modal" 
                                         data-bs-target="#modalFoto{{ $b->id }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <code class="text-primary">{{ $b->kode }}</code>
                                @if($b->merk)
                                    <br><small class="text-muted">{{ $b->merk }}</small>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $b->nama }}</strong>
                                @if($b->spesifikasi)
                                <br><small class="text-muted">{{ Str::limit($b->spesifikasi, 50) }}</small>
                                @endif
                            </td>
                            <td>{{ $b->kategori->nama ?? '-' }}</td>
                            <td>{{ $b->lokasi->nama ?? '-' }}</td>
                            
                            <td class="text-center">
                                @if($b->tipe == 'sarpras')
                                    <span class="badge bg-success">SARPRAS</span>
                                    @if($b->sarpras_last_sync)
                                        <br><small class="text-muted">{{ date('d/m/Y', strtotime($b->sarpras_last_sync)) }}</small>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">LOKAL</span>
                                @endif
                            </td>
                            
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
                                <span class="badge bg-info">{{ $b->stok }}</span> {{ $b->satuan }}
                            </td>
                            
                            <td class="text-center">
                                @if($b->qr_code)
                                    @if(filter_var($b->qr_code, FILTER_VALIDATE_URL))
                                        <a href="{{ $b->qr_code }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-info"
                                           title="Lihat QR Code">
                                            <i class="bi bi-qr-code"></i>
                                        </a>
                                    @elseif(file_exists(public_path($b->qr_code)))
                                        <a href="{{ asset($b->qr_code) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-info"
                                           title="Lihat QR Code">
                                            <i class="bi bi-qr-code"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                @else
                                    @if($b->tipe == 'lokal')
                                    <form method="POST" 
                                          action="{{ route('barang.generate_qr', $b->id) }}" 
                                          class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-success" 
                                                title="Generate QR Code"
                                                onclick="return confirm('Generate QR Code untuk barang ini?')">
                                            <i class="bi bi-qr-code"></i>
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                @endif
                            </td>
                            
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit{{ $b->id }}"
                                            title="Edit Barang">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    @if($b->tipe == 'sarpras')
                                        <form method="POST" 
                                              action="{{ route('barang.sync_sarpras', $b->id) }}"
                                              class="d-inline">
                                            @csrf
                                            <button class="btn btn-info" 
                                                    title="Sinkronisasi dari SARPRAS"
                                                    onclick="return confirm('Sinkronisasi data dari SARPRAS?')">
                                                <i class="bi bi-arrow-repeat"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" 
                                          action="{{ route('barang.destroy', $b->id) }}"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" 
                                                title="Hapus Barang"
                                                onclick="return confirm('Yakin menghapus barang ini?\n{{ $b->nama }}\n{{ $b->kode }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center text-muted py-5">
                                <i class="bi bi-inbox display-6 d-block mb-3"></i>
                                <h5>Data barang belum tersedia</h5>
                                <p class="mb-0">Mulai dengan menambahkan barang lokal atau scan QR dari SARPRAS</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambah" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('barang.store') }}" class="modal-content" id="formTambah">
            @csrf
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Barang Lokal
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Barang <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="nama" 
                               id="namaBarang"
                               class="form-control" 
                               required
                               autofocus
                               oninput="
                               let kode = this.value
                                   .replace(/[^A-Za-z]/g, '')
                                   .toUpperCase()
                                   .substring(0, 5);
                               if (kode.length < 3) {
                                   kode += Math.floor(10 + Math.random() * 90);
                               }
                               let angka = Math.floor(100 + Math.random() * 900);
                               document.getElementById('kodeBarang').value = kode + angka;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kode Barang <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" 
                                   name="kode" 
                                   id="kodeBarang"
                                   class="form-control" 
                                   placeholder="Ketik nama, kode otomatis dibuat"
                                   required
                                   readonly>
                            <button type="button" 
                                    class="btn btn-outline-secondary" 
                                    onclick="
                                    let nama = document.getElementById('namaBarang').value;
                                    if (!nama) {
                                        alert('Masukkan nama barang dulu');
                                        return;
                                    }
                                    let kode = nama
                                        .replace(/[^A-Za-z]/g, '')
                                        .toUpperCase()
                                        .substring(0, 5);
                                    if (kode.length < 3) {
                                        kode += Math.floor(10 + Math.random() * 90);
                                    }
                                    let angka = Math.floor(100 + Math.random() * 900);
                                    document.getElementById('kodeBarang').value = kode + angka;"
                                    title="Generate ulang kode">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>
                        <small class="text-muted">Kode berubah realtime sesuai nama</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                        <select name="lokasi_id" class="form-select" required>
                            <option value="">-- Pilih Lokasi --</option>
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
                        <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                        <select name="kondisi" class="form-select" required>
                            <option value="baik">Baik</option>
                            <option value="rusak ringan">Rusak Ringan</option>
                            <option value="rusak berat">Rusak Berat</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="stok" 
                               class="form-control" 
                               value="1" 
                               min="1" 
                               required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Satuan <span class="text-danger">*</span></label>
                        <select name="satuan" class="form-select" required>
                            <option value="unit">Unit</option>
                            <option value="pcs">PCS</option>
                            <option value="set">Set</option>
                            <option value="buah">Buah</option>
                            <option value="lembar">Lembar</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Foto URL</label>
                        <input type="url" 
                               name="foto" 
                               class="form-control"
                               placeholder="https://example.com/foto.jpg">
                        <small class="text-muted">Opsional</small>
                    </div>
                    <input type="hidden" name="tipe" value="lokal">
                    <div class="col-12">
                        <label class="form-label">Spesifikasi</label>
                        <textarea name="spesifikasi" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="Deskripsi detail barang"></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" 
                                  class="form-control" 
                                  rows="2"
                                  placeholder="Catatan tambahan"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@foreach($barang as $b)
    <div class="modal fade" id="modalEdit{{ $b->id }}" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
            <form method="POST" action="{{ route('barang.update', $b->id) }}" class="modal-content">
                @csrf
                @method('PUT')
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil me-2"></i>Edit Barang
                        @if($b->tipe == 'sarpras')
                            <span class="badge bg-success ms-2">SARPRAS</span>
                        @else
                            <span class="badge bg-secondary ms-2">LOKAL</span>
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kode <span class="text-danger">*</span></label>
                            @if($b->tipe == 'lokal')
                                <input type="text" 
                                       name="kode" 
                                       class="form-control" 
                                       value="{{ $b->kode }}" 
                                       required
                                       oninput="
                                       this.value = this.value
                                           .replace(/[^A-Za-z0-9]/g, '')
                                           .toUpperCase()
                                           .substring(0, 10);">
                            @else
                                <input type="text" 
                                       class="form-control" 
                                       value="{{ $b->kode }}" 
                                       readonly>
                                <input type="hidden" name="kode" value="{{ $b->kode }}">
                                <small class="text-muted">Kode barang SARPRAS tidak dapat diubah</small>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipe Barang</label>
                            <input type="text" 
                                   class="form-control bg-light" 
                                   value="{{ $b->tipe == 'sarpras' ? 'SARPRAS' : 'LOKAL' }}" 
                                   readonly>
                            <input type="hidden" name="tipe" value="{{ $b->tipe }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="nama" 
                                   class="form-control" 
                                   value="{{ $b->nama }}" 
                                   required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategori as $k)
                                    <option value="{{ $k->id }}" 
                                        {{ $b->kategori_id == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <select name="lokasi_id" class="form-select" required>
                                <option value="">-- Pilih Lokasi --</option>
                                @foreach($lokasi as $l)
                                    <option value="{{ $l->id }}"
                                        {{ $b->lokasi_id == $l->id ? 'selected' : '' }}>
                                        {{ $l->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Merk</label>
                            <input type="text" 
                                   name="merk" 
                                   class="form-control" 
                                   value="{{ $b->merk }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Kondisi <span class="text-danger">*</span></label>
                            <select name="kondisi" class="form-select" required>
                                <option value="baik" {{ $b->kondisi == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="rusak ringan" {{ $b->kondisi == 'rusak ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="rusak berat" {{ $b->kondisi == 'rusak berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Stok <span class="text-danger">*</span></label>
                            <input type="number" 
                                   name="stok" 
                                   class="form-control" 
                                   value="{{ $b->stok }}" 
                                   min="0" 
                                   required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Satuan <span class="text-danger">*</span></label>
                            <select name="satuan" class="form-select" required>
                                <option value="unit" {{ $b->satuan == 'unit' ? 'selected' : '' }}>Unit</option>
                                <option value="pcs" {{ $b->satuan == 'pcs' ? 'selected' : '' }}>PCS</option>
                                <option value="set" {{ $b->satuan == 'set' ? 'selected' : '' }}>Set</option>
                                <option value="buah" {{ $b->satuan == 'buah' ? 'selected' : '' }}>Buah</option>
                                <option value="lembar" {{ $b->satuan == 'lembar' ? 'selected' : '' }}>Lembar</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Foto URL</label>
                            <input type="url" 
                                   name="foto" 
                                   class="form-control" 
                                   value="{{ $b->foto }}"
                                   placeholder="https://example.com/foto.jpg">
                            <small class="text-muted">
                                @if($b->tipe == 'sarpras')
                                    Foto barang SARPRAS akan ditimpa saat sinkronisasi
                                @else
                                    Foto untuk barang lokal
                                @endif
                            </small>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Spesifikasi</label>
                            <textarea name="spesifikasi" 
                                      class="form-control" 
                                      rows="3">{{ $b->spesifikasi }}</textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" 
                                      class="form-control" 
                                      rows="2">{{ $b->keterangan }}</textarea>
                        </div>
                        @if($b->tipe == 'sarpras')
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Informasi SARPRAS:</strong><br>
                                @if($b->sarpras_id)
                                    ID SARPRAS: {{ $b->sarpras_id }}<br>
                                @endif
                                @if($b->sarpras_last_sync)
                                    Terakhir sinkron: {{ date('d/m/Y H:i', strtotime($b->sarpras_last_sync)) }}
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-check-circle me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
    @if($b->foto)
    <div class="modal fade" id="modalFoto{{ $b->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Foto {{ $b->nama }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ $b->foto }}" 
                         alt="Foto {{ $b->nama }}" 
                         class="img-fluid rounded"
                         style="max-height: 70vh;">
                    <div class="mt-3 text-muted">
                        <small>{{ $b->kode }} - {{ $b->nama }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach

@push('styles')
<style>
.modal {
    z-index: 1060;
}

.modal-backdrop {
    z-index: 1050;
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.02);
}

.img-thumbnail {
    transition: transform 0.2s;
    cursor: pointer;
}

.img-thumbnail:hover {
    transform: scale(1.05);
}

.badge {
    font-size: 0.8em;
    padding: 0.35em 0.65em;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modalTambah')?.addEventListener('hidden.bs.modal', function() {
        document.getElementById('formTambah')?.reset();
        document.getElementById('kodeBarang').value = '';
    });
    document.getElementById('formTambah')?.addEventListener('submit', function(e) {
        const nama = this.querySelector('input[name="nama"]');
        const kode = this.querySelector('input[name="kode"]');
        const kategori = this.querySelector('select[name="kategori_id"]');
        const lokasi = this.querySelector('select[name="lokasi_id"]');
        
        if (!nama.value.trim()) {
            e.preventDefault();
            alert('Nama barang harus diisi');
            nama.focus();
            return false;
        }
        
        if (!kode.value.trim()) {
            e.preventDefault();
            alert('Kode harus digenerate. Pastikan nama barang sudah diisi.');
            nama.focus();
            return false;
        }
        
        if (!kategori.value || !lokasi.value) {
            e.preventDefault();
            alert('Kategori dan lokasi harus dipilih');
            return false;
        }
        
        return true;
    });
    document.getElementById('modalTambah')?.addEventListener('show.bs.modal', function() {
        setTimeout(() => {
            const namaInput = document.getElementById('namaBarang');
            const kodeInput = document.getElementById('kodeBarang');
            if (namaInput.value && !kodeInput.value) {
                namaInput.dispatchEvent(new Event('input'));
            }
        }, 100);
    });
});
</script>
@endpush
@endsection