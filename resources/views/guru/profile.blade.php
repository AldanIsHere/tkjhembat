@extends('layouts.guru')
@section('title', 'Profil Guru')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Profil Guru</h4>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm shadow-lg border-1">
                <div class="card-body">
                    <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <img
                                src="{{ $guru->foto ? asset($guru->foto) : asset('https://via.placeholder.com/120') }}"
                                class="rounded-circle border"
                                width="120"
                                height="120"
                                style="object-fit: cover;"
                            >
                            <div class="mt-2">
                                <input type="file" name="foto" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $guru->nama }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" value="{{ $guru->nip }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ $guru->email }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ $guru->telepon }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="{{ $guru->jabatan }}">
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('guru.dashboard') }}" class="btn btn-secondary">
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
