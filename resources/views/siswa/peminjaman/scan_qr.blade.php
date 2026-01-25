@extends('layouts.siswa')
@section('title', 'Scan QR')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Scan & Validasi QR Peminjaman</h4>

    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card mb-3">
                <div class="card-body text-center">

                    @if($qr_svg)
                        <p class="mb-2">QR Code 4 digit Anda</p>

                        <div class="d-flex justify-content-center my-3">
                            {!! $qr_svg !!}
                        </div>

                        <p class="mb-0">
                            <strong>Kode QR:</strong>
                            <span class="badge bg-secondary">
                                {{ $peminjaman->qr_code_short }}
                            </span>
                        </p>
                    @else
                        <div class="alert alert-danger mb-0">
                            QR Code tidak tersedia.
                        </div>
                    @endif

                </div>
            </div>

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('siswa.peminjaman.scan.validate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peminjaman_id" value="{{ $peminjaman->id }}">

                        <div class="mb-3">
                            <label for="qr_code_input" class="form-label">
                                Masukkan 4 Digit Kode QR
                            </label>
                            <input
                                type="text"
                                name="qr_code_input"
                                id="qr_code_input"
                                class="form-control text-center"
                                maxlength="4"
                                required
                                placeholder="Contoh: 1234"
                            >
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Validasi QR
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <a href="{{ route('siswa.peminjaman.index') }}" class="btn btn-secondary mt-3 w-100">
                Kembali
            </a>

        </div>
    </div>

</div>
@endsection
