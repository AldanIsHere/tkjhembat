@extends('layouts.admin')
@section('title', 'Data Siswa')
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-people-fill me-2"></i> Data Siswa
        </h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah Siswa
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header bg-white">
            <strong>Daftar Siswa</strong>
            <span class="badge bg-secondary float-end">
                Total: {{ $siswa->count() }}
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="70">Foto</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Telepon</th>
                            <th width="160">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa as $s)
                        <tr>
                            <td class="text-center">
                                <img
                                    src="{{ $s->foto ? asset($s->foto) : asset('assets/img/default-user.png') }}"
                                    class="rounded-circle"
                                    width="45"
                                    height="45"
                                    style="object-fit:cover"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalFoto{{ $s->id }}"
                                >
                            </td>
                            <td>{{ $s->nama }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->nis ?? '-' }}</td>
                            <td>{{ $s->kelas ?? '-' }}</td>
                            <td>{{ $s->jurusan ?? '-' }}</td>
                            <td>{{ $s->telepon ?? '-' }}</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm">
                                    <button
                                        class="btn btn-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit{{ $s->id }}">
                                        Edit
                                    </button>
                                    <form
                                        action="{{ route('siswa.destroy', $s->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Data siswa belum tersedia
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('siswa.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Siswa</h5>
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
                            <input type="text" name="password" class="form-control" required>
                            <label class="form-label mt-2">NIS</label>
                            <input type="text" name="nis" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" class="form-control">
                            <label class="form-label mt-2">Jurusan</label>
                            <input type="text" name="jurusan" class="form-control">
                            <label class="form-label mt-2">Telepon</label>
                            <input type="text" name="telepon" class="form-control">
                            <label class="form-label mt-2">Foto</label>
                            <input type="file" name="foto" class="form-control">
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
@foreach($siswa as $s)
<div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('siswa.update', $s->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" value="{{ $s->nama }}" class="form-control" required>
                            <label class="form-label mt-2">Email</label>
                            <input type="email" name="email" value="{{ $s->email }}" class="form-control" required>
                            <label class="form-label mt-2">Password (opsional)</label>
                            <input type="text" name="password" class="form-control">
                            <label class="form-label mt-2">NIS</label>
                            <input type="text" name="nis" value="{{ $s->nis }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kelas</label>
                            <input type="text" name="kelas" value="{{ $s->kelas }}" class="form-control">
                            <label class="form-label mt-2">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ $s->jurusan }}" class="form-control">
                            <label class="form-label mt-2">Telepon</label>
                            <input type="text" name="telepon" value="{{ $s->telepon }}" class="form-control">
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
<div class="modal fade" id="modalFoto{{ $s->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">{{ $s->nama }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img
                    src="{{ $s->foto ? asset($s->foto) : asset('assets/img/default-user.png') }}"
                    class="img-fluid"
                    width="200"
                >
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection
