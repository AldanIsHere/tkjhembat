@extends('layouts.admin')
@section('title','Manajemen Bahan')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-box-seam me-2"></i> Manajemen Bahan
        </h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addBahan">
            <i class="bi bi-plus-circle me-1"></i> Tambah Bahan
        </button>
    </div>

    {{-- ALERT --}}
    @foreach (['success','error'] as $msg)
        @if(session($msg))
            <div class="alert alert-{{ $msg=='success'?'success':'danger' }} alert-dismissible fade show">
                {{ session($msg) }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endforeach

    {{-- TABLE --}}
    <div class="card">
        <div class="card-header bg-white">
            <strong>Daftar Bahan</strong>
            <span class="badge bg-secondary float-end">
                Total: {{ $bahan->count() }}
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="140">Kode</th>
                            <th>Nama</th>
                            <th width="90">Stok</th>
                            <th width="90">Satuan</th>
                            <th>Lokasi</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bahan as $b)
                            <tr>
                                <td>{{ $b->kode }}</td>
                                <td>{{ $b->nama }}</td>
                                <td class="text-center">{{ $b->stok }}</td>
                                <td class="text-center">{{ $b->satuan }}</td>
                                <td>{{ $b->lokasi->nama ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-warning"
                                                data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $b->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form action="{{ route('bahan.destroy',$b->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger"
                                                    onclick="return confirm('Hapus bahan ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            {{-- MODAL EDIT --}}
                            <div class="modal fade" id="edit{{ $b->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <form method="POST"
                                          action="{{ route('bahan.update',$b->id) }}"
                                          class="modal-content">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Bahan</h5>
                                            <button class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Kode</label>
                                                    <input class="form-control" value="{{ $b->kode }}" disabled>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama</label>
                                                    <input name="nama" class="form-control" value="{{ $b->nama }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Stok</label>
                                                    <input type="number" name="stok" class="form-control" value="{{ $b->stok }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Satuan</label>
                                                    <input name="satuan" class="form-control" value="{{ $b->satuan }}" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label">Lokasi</label>
                                                    <select name="lokasi_id" class="form-select" required>
                                                        @foreach($lokasi as $l)
                                                            <option value="{{ $l->id }}"
                                                                {{ $b->lokasi_id==$l->id?'selected':'' }}>
                                                                {{ $l->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">Keterangan</label>
                                                    <textarea name="keterangan" class="form-control">{{ $b->keterangan }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button class="btn btn-success">
                                                <i class="bi bi-save me-1"></i> Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Data bahan belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ADD --}}
<div class="modal fade" id="addBahan" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST" action="{{ route('bahan.store') }}" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Tambah Bahan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Kode</label>
                        <input name="kode" id="kodeBahan" class="form-control" readonly required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input name="nama" id="namaBahan" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Satuan</label>
                        <input name="satuan" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Lokasi</label>
                        <select name="lokasi_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($lokasi as $l)
                                <option value="{{ $l->id }}">{{ $l->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT GENERATE KODE REALTIME (TIDAK DIUBAH) --}}
<script>
document.getElementById('namaBahan').addEventListener('input', function () {
    let nama = this.value.trim();

    if (nama.length === 0) {
        document.getElementById('kodeBahan').value = '';
        return;
    }

    let singkatan = nama
        .split(' ')
        .filter(w => w.length > 0)
        .map(w => w[0])
        .join('')
        .toUpperCase();

    let random = Math.floor(1000 + Math.random() * 9000);

    document.getElementById('kodeBahan').value = singkatan + '-' + random;
});
</script>
@endsection
