@extends('layouts.admin')
@section('title', 'Scan QR Code')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-qr-code-scan me-2"></i> Scan QR Code Barang
                    </h5>
                </div>
                
                <div class="card-body">
                    <ul class="nav nav-tabs nav-fill mb-4" id="scanTabs" role="tablist">
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button">
                                <i class="bi bi-image me-2"></i> Upload Gambar
                            </button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="webcam-tab" data-bs-toggle="tab" data-bs-target="#webcam-tab-pane" type="button">
                                <i class="bi bi-camera-video me-2"></i> Webcam Live
                            </button>
                        </li>
                    </ul>
                    
                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('warning') }}
                            <button class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    <div class="tab-content" id="scanTabsContent">              
                        <!-- Tab 1: Upload Gambar QR -->
                        <div class="tab-pane fade" id="image-tab-pane" role="tabpanel">
                            <form method="POST" action="{{ route('barang.tarik_sarpras') }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-upload me-1"></i> Pilih Gambar QR Code *
                                    </label>
                                    
                                    <div class="mb-3">
                                        <input type="file" 
                                               name="qr_image" 
                                               class="form-control" 
                                               accept="image/*"
                                               required>
                                        <div class="form-text text-muted">
                                            <i class="bi bi-info-circle me-1"></i> Format: JPG, PNG, GIF (Maks. 5MB)
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info">
                                        <i class="bi bi-lightbulb me-2"></i>
                                        <strong>Tips:</strong>
                                        <ul class="mb-0 mt-2">
                                            <li>Sistem akan membaca kode dari gambar QR Code</li>
                                            <li>Pastikan gambar QR Code jelas dan tidak blur</li>
                                            <li>Jika gagal, gunakan input manual dengan menyalin teks dari QR Code</li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-geo-alt me-1"></i> Lokasi Penempatan *
                                    </label>
                                    <select name="lokasi_id" class="form-select" required>
                                        <option value="">-- Pilih Lokasi --</option>
                                        @foreach($lokasi as $l)
                                            <option value="{{ $l->id }}">{{ $l->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <button type="button" class="btn btn-outline-secondary" onclick="switchToTextTab()">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali ke Teks
                                    </button>
                                    
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-cloud-download me-1"></i> Tarik dari SARPRAS
                                    </button>
                                </div>
                            </form>
                        </div>           
                        <!-- Tab 2: Webcam Live Scan -->
                        <div class="tab-pane fade" id="webcam-tab-pane" role="tabpanel">
                            <div class="text-center mb-4">
                                <div class="mb-4">
                                    <i class="bi bi-camera-video text-primary" style="font-size: 4rem;"></i>
                                    <h4 class="mt-3">Scanner Webcam Live</h4>
                                    <p class="text-muted">Gunakan kamera untuk scan QR Code secara langsung</p>
                                </div>
                                
                                <a href="{{ route('barang.scan_webcam') }}" class="btn btn-primary btn-lg px-5">
                                    <i class="bi bi-camera-video me-2"></i> Buka Scanner Webcam
                                </a>
                            </div>
                                                     
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong> Pastikan browser Anda mengizinkan akses kamera
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<<<<<<< HEAD
    </div>
</div>
=======
        
       

    </div>
</div>

<!-- Modal untuk hasil parsing -->
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
<div class="modal fade" id="resultModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="resultModalTitle">
                    <i class="bi bi-search me-2"></i> Hasil Parsing
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="resultModalBody">
<<<<<<< HEAD
=======
                <!-- Hasil akan diisi oleh JavaScript -->
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x me-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-primary" id="useResultBtn" onclick="useParsedResult()">
                    <i class="bi bi-check me-1"></i> Gunakan
                </button>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
<style>
.nav-tabs .nav-link {
    color: #495057;
    border: none;
    padding: 0.75rem 1rem;
    transition: all 0.3s;
}
<<<<<<< HEAD
.nav-tabs .nav-link:hover {
    background-color: rgba(13, 110, 253, 0.05);
}
=======

.nav-tabs .nav-link:hover {
    background-color: rgba(13, 110, 253, 0.05);
}

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
.nav-tabs .nav-link.active {
    color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
    border-bottom: 3px solid #0d6efd;
    font-weight: 600;
}
<<<<<<< HEAD
.tab-content {
    padding-top: 1.5rem;
}
.form-label {
    margin-bottom: 0.5rem;
}
.form-text {
    margin-top: 0.25rem;
}
.btn-group .btn {
    border-radius: 0.375rem !important;
}
=======

.tab-content {
    padding-top: 1.5rem;
}

.form-label {
    margin-bottom: 0.5rem;
}

.form-text {
    margin-top: 0.25rem;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
}

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
.alert {
    border-radius: 0.5rem;
    border: none;
}
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
.card {
    border-radius: 0.75rem;
    border: none;
}
<<<<<<< HEAD
.card-header {
    border-radius: 0.75rem 0.75rem 0 0 !important;
}
=======

.card-header {
    border-radius: 0.75rem 0.75rem 0 0 !important;
}

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
.code-example {
    background-color: #f8f9fa;
    border-left: 4px solid #0d6efd;
    padding: 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
}
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
.badge {
    font-size: 0.75em;
    padding: 0.35em 0.65em;
}
</style>
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
<script>
function resetTextForm() {
    document.getElementById('qrInput').value = '';
    document.getElementById('qrInput').focus();
}

function switchToTextTab() {
    const textTab = document.getElementById('text-tab');
    if (textTab) {
        textTab.click();
    }
}
function testQRText() {
    const qrString = document.getElementById('qrInput').value.trim();
<<<<<<< HEAD
=======
    
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    if (!qrString) {
        alert('Masukkan kode QR terlebih dahulu');
        return;
    }
<<<<<<< HEAD
=======
    
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    showParsingResult(qrString, 'text');
}
function showParsingResult(qrText, sourceType) {
    // Kirim ke server untuk parsing
    fetch('{{ route("barang.validate_qr") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ qr_string: qrText })
    })
    .then(response => response.json())
    .then(data => {
        let resultHtml = '';
<<<<<<< HEAD
=======
        
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        if (data.success) {
            resultHtml = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>QR Code Berhasil Dibaca!</strong>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Teks QR:</label>
                    <div class="p-2 bg-light rounded">
                        <code style="word-break: break-all;">${qrText}</code>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Kode yang diekstrak:</label>
                    <div class="p-2 bg-light rounded">
                        <strong>${data.kode}</strong>
                    </div>
                </div>
            `;
<<<<<<< HEAD
=======
            
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            if (data.exists) {
                resultHtml += `
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Barang Sudah Ada di Database!</strong><br>
                        Nama: ${data.barang.nama}<br>
                        Lokasi: ${data.barang.lokasi}<br>
                        <small>${data.message}</small>
                    </div>
                `;
            } else {
                resultHtml += `
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Barang belum ada di database lokal.</strong><br>
                        <small>${data.message}</small>
                    </div>
                `;
            }
        } else {
            resultHtml = `
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle me-2"></i>
                    <strong>QR Code Tidak Valid!</strong><br>
                    ${data.message}
                </div>
                
                <div class="mt-3">
                    <strong>Teks yang dibaca:</strong>
                    <div class="p-2 bg-light rounded mt-2">
                        <code>${qrText.substring(0, 200)}${qrText.length > 200 ? '...' : ''}</code>
                    </div>
                </div>
            `;
        }
<<<<<<< HEAD
        document.getElementById('resultModalBody').innerHTML = resultHtml;
        document.getElementById('resultModalTitle').textContent = 'Hasil Parsing QR';
=======
        
        document.getElementById('resultModalBody').innerHTML = resultHtml;
        document.getElementById('resultModalTitle').textContent = 'Hasil Parsing QR';
        
>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        if (data.success && !data.exists) {
            document.getElementById('useResultBtn').classList.remove('d-none');
        } else {
            document.getElementById('useResultBtn').classList.add('d-none');
        }
        
        const modal = new bootstrap.Modal(document.getElementById('resultModal'));
        modal.show();
    })
    .catch(error => {
        document.getElementById('resultModalBody').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-x-circle me-2"></i>
                <strong>Error!</strong><br>
                ${error.message}
            </div>
        `;
        const modal = new bootstrap.Modal(document.getElementById('resultModal'));
        modal.show();
    });
}
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
function useParsedResult() {
    document.getElementById('qrInput').value = document.getElementById('qrInput').value;
    const modal = bootstrap.Modal.getInstance(document.getElementById('resultModal'));
    modal.hide();
}
document.addEventListener('DOMContentLoaded', function() {
    const tabTriggers = document.querySelectorAll('#scanTabs button[data-bs-toggle="tab"]');
    tabTriggers.forEach(tabTriggerEl => {
        tabTriggerEl.addEventListener('shown.bs.tab', function(event) {
            const targetId = event.target.getAttribute('data-bs-target');
            
            if (targetId === '#text-tab-pane') {
                setTimeout(() => {
                    document.getElementById('qrInput').focus();
                }, 100);
            } else if (targetId === '#manual-tab-pane') {
                setTimeout(() => {
                    const manualInput = document.querySelector('input[name="manual_kode"]');
                    if (manualInput) manualInput.focus();
                }, 100);
            }
        });
    });
});
</script>
@endsection