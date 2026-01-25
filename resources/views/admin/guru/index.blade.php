@extends('layouts.admin')
@section('title', 'Data Guru')

@section('content')
<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-person-badge me-2"></i> Data Guru
        </h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Guru
        </button>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card">
        <div class="card-header bg-white">
            <strong>Daftar Guru</strong>
            <span class="badge bg-secondary float-end">
                Total: {{ $guru->count() }}
            </span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th width="80">Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIP</th>
                            <th>Telepon</th>
                            <th>Jabatan</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($guru as $g)
                        <tr>
                            <td class="text-center">
                                <img
                                    src="{{ $g->foto ? asset($g->foto) : asset('assets/img/default-user.png') }}"
                                    class="rounded-circle"
                                    width="45"
                                    height="45"
                                    style="object-fit:cover"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalFoto{{ $g->id }}"
                                >
                            </td>
                            <td>{{ $g->nama }}</td>
                            <td>{{ $g->email }}</td>
                            <td>{{ $g->nip ?? '-' }}</td>
                            <td>{{ $g->telepon ?? '-' }}</td>
                            <td>{{ $g->jabatan ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $g->id }}">
                                        Edit
                                    </button>
                                    <form
                                        action="{{ route('guru.destroy', $g->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Data guru belum tersedia
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
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('guru.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>

                            <label class="form-label mt-2">Email</label>
                            <input type="email" name="email" class="form-control" required>

                            <label class="form-label mt-2">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control">

                            <label class="form-label mt-2">Telepon</label>
                            <input type="text" name="telepon" class="form-control">

                            <label class="form-label mt-2">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control">

                            <label class="form-label mt-2">Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL EDIT & FOTO ================= --}}
@foreach($guru as $g)

{{-- MODAL EDIT --}}
<div class="modal fade" id="modalEdit{{ $g->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('guru.update', $g->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Guru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" value="{{ $g->nama }}" class="form-control" required>

                            <label class="form-label mt-2">Email</label>
                            <input type="email" name="email" value="{{ $g->email }}" class="form-control" required>

                            <label class="form-label mt-2">Password (opsional)</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" value="{{ $g->nip }}" class="form-control">

                            <label class="form-label mt-2">Telepon</label>
                            <input type="text" name="telepon" value="{{ $g->telepon }}" class="form-control">

                            <label class="form-label mt-2">Jabatan</label>
                            <input type="text" name="jabatan" value="{{ $g->jabatan }}" class="form-control">

                            <label class="form-label mt-2">Foto</label>
                            <input type="file" name="foto" class="form-control">
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

{{-- MODAL FOTO --}}
<div class="modal fade" id="modalFoto{{ $g->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">{{ $g->nama }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img
                    src="{{ $g->foto ? asset($g->foto) : asset('assets/img/default-user.png') }}"
                    class="img-fluid"
                    width="200"
                >
            </div>
        </div>
    </div>
</div>

@endforeach
@endsection
