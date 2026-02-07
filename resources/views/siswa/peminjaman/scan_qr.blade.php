@extends('layouts.siswa')
@section('title', 'Scan QR Barang')
@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-4">
                <h4 class="text-primary mb-2">
                    <i class="fas fa-qrcode"></i> Scan QR Barang
                </h4>
                <p class="text-muted mb-0">Scan QR Code pada barang untuk validasi peminjaman</p>
            </div>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted d-block">Barang</small>
                            <strong class="d-block">{{ $peminjaman->barang_nama }}</strong>
                        </div>
                        <div class="col-6 text-end">
                            <small class="text-muted d-block">Status</small>
                            <span class="badge bg-{{ $peminjaman->qr_validated_at ? 'success' : 'warning' }}">
                                {{ $peminjaman->qr_validated_at ? '✓ Tervalidasi' : 'Belum Validasi' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div id="scanner-container" class="position-relative">
                        <div id="reader" class="w-100 bg-dark"></div>
                        <div id="scan-overlay" class="position-absolute top-0 start-0 w-100 h-100 d-none">
                            <div class="position-absolute top-50 start-50 translate-middle" 
                                 style="width: 70%; height: 70%; border: 2px solid rgba(40, 167, 69, 0.8); border-radius: 8px;">
                                <div class="scan-line"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center py-3">
                        <div id="status" class="text-muted small">
                            Klik tombol di bawah untuk memulai scan
                        </div>
                    </div>
                    <div class="p-3 border-top">
                        <div class="d-grid gap-2">
                            <button id="start-btn" class="btn btn-primary btn-lg">
                                <i class="fas fa-camera me-2"></i> Mulai Scan
                            </button>
                            <button id="stop-btn" class="btn btn-outline-secondary btn-lg d-none">
                                <i class="fas fa-stop me-2"></i> Berhenti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="result-container" class="mt-4 d-none">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div id="result-icon" class="mb-3" style="font-size: 3rem;"></div>
                        <h5 id="result-title" class="mb-2"></h5>
                        <p id="result-message" class="text-muted"></p>
                        <div id="debug-info" class="small text-muted mt-3 d-none"></div>
                        <div class="mt-3">
                            <button id="rescan-btn" class="btn btn-outline-primary">
                                <i class="fas fa-redo me-2"></i> Scan Ulang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('siswa.peminjaman.index') }}" class="text-decoration-none">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Peminjaman
                </a>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let scanner = null;
let isScanning = false;
const elements = {
    reader: document.getElementById('reader'),
    scannerContainer: document.getElementById('scanner-container'),
    scanOverlay: document.getElementById('scan-overlay'),
    startBtn: document.getElementById('start-btn'),
    stopBtn: document.getElementById('stop-btn'),
    resultContainer: document.getElementById('result-container'),
    resultIcon: document.getElementById('result-icon'),
    resultTitle: document.getElementById('result-title'),
    resultMessage: document.getElementById('result-message'),
    debugInfo: document.getElementById('debug-info'),
    status: document.getElementById('status'),
    rescanBtn: document.getElementById('rescan-btn')
};
function initScanner() {
    try {
        scanner = new Html5Qrcode("reader");
        updateStatus('Scanner siap. Klik "Mulai Scan" untuk memulai.');
        return true;
    } catch (error) {
        showError('Gagal menginisialisasi scanner');
        return false;
    }
}
function updateStatus(message, type = 'info') {
    if (elements.status) {
        elements.status.textContent = message;
        elements.status.className = type === 'error' ? 'text-danger small' : 'text-muted small';
    }
}
async function startScanning() {
    if (isScanning) return;
    try {
        elements.startBtn.disabled = true;
        elements.startBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Menyiapkan...';
        updateStatus('Mengaktifkan kamera...');
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        };
        await scanner.start(
            { facingMode: "environment" },
            config,
            onScanSuccess,
            () => {}
        );
        isScanning = true;
        elements.startBtn.classList.add('d-none');
        elements.stopBtn.classList.remove('d-none');
        elements.scanOverlay.classList.remove('d-none');
        updateStatus('Arahkan kamera ke QR Code...', 'success');
        
    } catch (error) {
        console.error('Scanner error:', error);
        
        let message = 'Gagal mengakses kamera';
        if (error.name === 'NotAllowedError') {
            message = 'Izin kamera ditolak. Silakan izinkan akses kamera.';
        } else if (error.name === 'NotFoundError') {
            message = 'Kamera tidak ditemukan.';
        }
        
        showResult('Error', message, false);
        elements.startBtn.disabled = false;
        elements.startBtn.innerHTML = '<i class="fas fa-camera me-2"></i> Mulai Scan';
    }
}
async function stopScanning() {
    if (!isScanning || !scanner) return;
    
    try {
        await scanner.stop();
        isScanning = false;
        elements.startBtn.classList.remove('d-none');
        elements.stopBtn.classList.add('d-none');
        elements.scanOverlay.classList.add('d-none');
        elements.startBtn.disabled = false;
        elements.startBtn.innerHTML = '<i class="fas fa-camera me-2"></i> Mulai Scan';
        updateStatus('Scanner dihentikan.');
    } catch (error) {
        console.error('Stop error:', error);
    }
}
async function onScanSuccess(decodedText) {
    if (!decodedText) return;
    await scanner.pause();
    showResult('Memproses...', 'Membaca kode dari QR...', true);
    try {
        const response = await fetch("{{ route('siswa.peminjaman.scan.validate_camera') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                peminjaman_id: {{ $peminjaman->id }},
                qr_code_url: decodedText
            })
        });
        
        const data = await response.json();
        console.log('Validation response:', data);
        
        if (data.success) {
            showResult('Berhasil!', 'QR Code valid. Mengalihkan...', true, true);
            setTimeout(() => {
                window.location.href = data.redirect_url;
            }, 1500);
        } else {
            let debugInfo = '';
            if (data.debug) {
                debugInfo = `Kode yang dibaca: ${data.debug.extracted_code || 'tidak ditemukan'}<br>
                             Kode barang: ${data.debug.barang_code || 'tidak ditemukan'}`;
            }
            
            showResult('Gagal', data.message || 'QR Code tidak sesuai', false, false, debugInfo);
        }
        
    } catch (error) {
        console.error('Validation error:', error);
        showResult('Error', 'Terjadi kesalahan saat validasi', false, false);
    }
}
function showResult(title, message, isLoading = false, isSuccess = false, debug = '') {
    elements.resultContainer.classList.remove('d-none');
    
    if (isLoading) {
        elements.resultIcon.innerHTML = '<i class="fas fa-spinner fa-spin text-primary"></i>';
    } else if (isSuccess) {
        elements.resultIcon.innerHTML = '<i class="fas fa-check-circle text-success"></i>';
    } else {
        elements.resultIcon.innerHTML = '<i class="fas fa-times-circle text-danger"></i>';
    }
    elements.resultTitle.textContent = title;
    elements.resultMessage.textContent = message;
    
    if (debug) {
        elements.debugInfo.innerHTML = debug;
        elements.debugInfo.classList.remove('d-none');
    } else {
        elements.debugInfo.classList.add('d-none');
    }
    elements.scannerContainer.style.opacity = '0.3';
}
function hideResult() {
    elements.resultContainer.classList.add('d-none');
    elements.scannerContainer.style.opacity = '1';
    
    if (scanner) {
        scanner.resume();
    }
}
function showError(message) {
    elements.resultContainer.classList.remove('d-none');
    elements.resultIcon.innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i>';
    elements.resultTitle.textContent = 'Error';
    elements.resultMessage.textContent = message;
    elements.scannerContainer.style.opacity = '0.3';
}
document.addEventListener('DOMContentLoaded', function() {
    if (!initScanner()) {
        elements.startBtn.disabled = true;
    }
    elements.startBtn.addEventListener('click', startScanning);
    elements.stopBtn.addEventListener('click', stopScanning);
    elements.rescanBtn.addEventListener('click', hideResult);
    window.addEventListener('beforeunload', function() {
        if (isScanning && scanner) {
            scanner.stop();
        }
    });
});
</script>
<style>
#reader {
    height: 300px;
    border-radius: 8px 8px 0 0;
}

#reader video {
    border-radius: 8px 8px 0 0;
    object-fit: cover;
}

.scan-line {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        #28a745 50%, 
        transparent 100%);
    animation: scan 1.5s ease-in-out infinite;
}

@keyframes scan {
    0% { top: 0%; }
    50% { top: 100%; }
    100% { top: 0%; }
}

.card {
    border-radius: 12px;
}

.btn-lg {
    padding: 12px;
    font-weight: 500;
}

#scanner-container {
    transition: opacity 0.3s ease;
}

.bg-primary {
    background-color: #4361ee !important;
}

.text-primary {
    color: #4361ee !important;
}
</style>
@endsection