@extends('layouts.admin')
@section('title', 'API Sarpras')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">
            <i class="bi bi-link-45deg me-2"></i> API Sarpras
        </h4>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-circle me-1"></i> Tambah API
        </button>
    </div>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Base URL</th>
                        <th>Tipe Auth</th>
                        <th>Status</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($apiSarpras as $a)
                        <tr>
                            <td>{{ $a->nama }}</td>
                            <td>{{ $a->base_url }}</td>
                            <td>{{ strtoupper($a->tipe_auth) }}</td>
                            <td>
                                @if($a->aktif)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $a->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <form action="{{ route('api-sarpras.destroy',$a->id) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus API ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data API belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('api-sarpras.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah API Sarpras</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nama *</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Base URL *</label>
                        <input type="text" name="base_url" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">API Key</label>
                        <input type="text" name="api_key" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">API Secret</label>
                        <input type="text" name="api_secret" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Token</label>
                        <input type="text" name="token" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tipe Auth *</label>
                        <select name="tipe_auth" class="form-select" required>
                            <option value="api_key">API Key</option>
                            <option value="token">Token</option>
                            <option value="basic">Basic</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="aktif" class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="2"></textarea>
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
@foreach($apiSarpras as $a)
<div class="modal fade" id="modalEdit{{ $a->id }}">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="{{ route('api-sarpras.update',$a->id) }}">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit API Sarpras</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nama</label>
                        <input name="nama" class="form-control" value="{{ $a->nama }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Base URL</label>
                        <input name="base_url" class="form-control" value="{{ $a->base_url }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">API Key</label>
                        <input name="api_key" class="form-control" value="{{ $a->api_key }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">API Secret</label>
                        <input name="api_secret" class="form-control" value="{{ $a->api_secret }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Token</label>
                        <input name="token" class="form-control" value="{{ $a->token }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tipe Auth</label>
                        <select name="tipe_auth" class="form-select">
                            <option value="api_key" {{ $a->tipe_auth=='api_key'?'selected':'' }}>API Key</option>
                            <option value="token" {{ $a->tipe_auth=='token'?'selected':'' }}>Token</option>
                            <option value="basic" {{ $a->tipe_auth=='basic'?'selected':'' }}>Basic</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="aktif" class="form-select">
                            <option value="1" {{ $a->aktif?'selected':'' }}>Aktif</option>
                            <option value="0" {{ !$a->aktif?'selected':'' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Keterangan</label>
                        <textarea name="keterangan" class="form-control">{{ $a->keterangan }}</textarea>
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
