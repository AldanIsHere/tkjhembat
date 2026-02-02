@extends('layouts.admin')
@section('title', 'Manajemen Aturan')

@php
    $roleOptions = ['admin' => 'Admin', 'guru' => 'Guru', 'kepsek' => 'Kepala Sekolah'];
@endphp

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-shield-check me-2"></i> Manajemen Aturan
        </h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Aturan
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-light">
            <strong>Daftar Aturan Sistem</strong>
            <span class="float-end">
                Total: {{ $aturan->count() }} Aturan
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Aturan</th>
                            <th>Status</th>
                            <th>Maks Hari</th>
                            <th>Denda / Hari</th>
                            <th>Persetujuan</th>
                            <th width="180" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($aturan as $a)
                        <tr>
                            <td>
                                <strong>{{ $a->nama }}</strong>
                                @if($a->deskripsi)
                                    <div class="text-muted small">{{ Str::limit($a->deskripsi, 80) }}</div>
                                @endif
                            </td>
                            <td>
                                @if($a->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                {{ $a->maks_hari ? $a->maks_hari.' hari' : '-' }}
                            </td>
                            <td>
                                {{ $a->denda_hari ? 'Rp '.number_format($a->denda_hari,0,',','.') : '-' }}
                            </td>
                            <td>
                                @if($a->perlu_setuju)
                                    Ya ({{ $a->role_setuju }})
                                @else
                                    Tidak
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $a->id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('aturan.destroy', $a->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus aturan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada aturan sistem
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Aturan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('aturan.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Aturan</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="aktif" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Maks Hari</label>
                            <input type="number" name="maks_hari" class="form-control" min="1">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Denda / Hari</label>
                            <input type="number" name="denda_hari" class="form-control" min="0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="perlu_setuju" id="perluSetuju"
                                       value="1"
                                       onchange="document.getElementById('roleSetuju').classList.toggle('d-none', !this.checked)">
                                <label class="form-check-label" for="perluSetuju">
                                    Perlu Persetujuan
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 d-none" id="roleSetuju">
                            <label class="form-label">Role Persetujuan</label>
                            <select name="role_setuju" class="form-select">
                                @foreach($roleOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
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
@foreach($aturan as $a)
<div class="modal fade" id="modalEdit{{ $a->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Aturan</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('aturan.update', $a->id) }}">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Aturan</label>
                            <input type="text" name="nama" value="{{ $a->nama }}" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="aktif" class="form-select">
                                <option value="1" {{ $a->aktif ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$a->aktif ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Maks Hari</label>
                            <input type="number" name="maks_hari" value="{{ $a->maks_hari }}" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Denda / Hari</label>
                            <input type="number" name="denda_hari" value="{{ $a->denda_hari }}" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="perlu_setuju" value="1"
                                       {{ $a->perlu_setuju ? 'checked' : '' }}
                                       onchange="document.getElementById('roleSetujuEdit{{ $a->id }}').classList.toggle('d-none', !this.checked)">
                                <label class="form-check-label">
                                    Perlu Persetujuan
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3 {{ $a->perlu_setuju ? '' : 'd-none' }}"
                             id="roleSetujuEdit{{ $a->id }}">
                            <label class="form-label">Role Persetujuan</label>
                            <select name="role_setuju" class="form-select">
                                @foreach($roleOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $a->role_setuju == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3">{{ $a->deskripsi }}</textarea>
                        </div>
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
@endforeach
@endsection
