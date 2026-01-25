@extends('layouts.siswa')
@section('title', 'Form Peminjaman Barang')

@section('content')
<div class="container py-4">

    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-white border-0 pb-0">
                    <h4 class="fw-semibold mb-1">Form Peminjaman Barang</h4>
                    <p class="text-muted mb-0">Lengkapi data peminjaman dengan benar</p>
                </div>

                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('siswa.peminjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="barang_id" value="{{ $barang->id }}">

                        {{-- INFO BARANG --}}
                        <div class="border rounded-3 p-3 mb-4 bg-light">
                            <h6 class="fw-semibold mb-2">Informasi Barang</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">Nama Barang</small>
                                    <div class="fw-medium">{{ $barang->nama }}</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Stok</small>
                                    <div class="fw-medium">{{ $barang->stok }}</div>
                                </div>
                                <div class="col-md-3">
                                    <small class="text-muted">Kondisi</small>
                                    <div class="fw-medium">{{ $barang->kondisi }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- PILIH GURU --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Guru Tujuan Persetujuan
                            </label>
                            <select name="setuju_id" class="form-select" required>
                                <option value="">-- Pilih Guru --</option>
                                @foreach($guru as $g)
                                    <option value="{{ $g->id }}">
                                        {{ $g->nama }} ({{ $g->jabatan ?? 'Guru' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- JUMLAH --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Pinjam</label>
                            <input type="number"
                                   name="jumlah"
                                   class="form-control"
                                   min="1"
                                   max="{{ $barang->stok }}"
                                   value="1"
                                   required>
                        </div>

                        {{-- TANGGAL --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Pinjam</label>
                                <input type="date"
                                       name="tanggal_pinjam"
                                       class="form-control"
                                       value="{{ date('Y-m-d') }}"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Kembali</label>
                                <input type="date"
                                       name="tanggal_kembali"
                                       class="form-control"
                                       required>
                            </div>
                        </div>

                        {{-- CATATAN --}}
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Catatan (Opsional)</label>
                            <textarea name="catatan"
                                      rows="3"
                                      class="form-control"
                                      placeholder="Contoh: digunakan untuk praktikum jaringan..."></textarea>
                        </div>

                        {{-- SUBMIT --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('siswa.peminjaman.barang') }}"
                               class="btn btn-outline-secondary">
                                Kembali
                            </a>

                            <button type="submit" class="btn btn-success px-4">
                                Buat Peminjaman & Generate QR
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
