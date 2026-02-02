@extends('layouts.siswa')
@section('title', 'Profil Siswa')

@section('content')
<div class="container-fluid">
    <h4 class="mb-3">Profil Siswa</h4>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm shadow-lg border-1">
                <div class="card-body">
                    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-center mb-4">
                            <img
                                src="{{ $user->foto ? asset($user->foto) : asset('https://via.placeholder.com/120') }}"
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
                                <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIS</label>
                                <input type="text" class="form-control" value="{{ $user->nis }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon</label>
                                <input type="text" name="telepon" class="form-control" value="{{ $user->telepon }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" name="kelas" class="form-control" value="{{ $user->kelas }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control" value="{{ $user->jurusan }}">
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
