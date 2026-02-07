<!-- 
 
untuk di scan kamera ini metode nya sama kaya yang ada di controller Admin Barang, kita baca dulu hasil dari isi gambar qr yang di scan setelah itu kita filter/parsing, hapus url yang gak perlu lalu ambil si kode unik dari isi url qr yang di scan, setelah itu hasil dari parsing kita masukkin ke method get api lalu tembak ke api pakai method GET.



-->
@extends('layouts.admin')
@section('title', 'Scan QR Code via Webcam')
<style>
    #scanner-container {
        position: relative;
        width: 100%;
        max-width: 640px;
        margin: 0 auto;
    }
    #reader {
        width: 100%;
        height: auto;
        border-radius: 8px;
        border: 3px solid #dee2e6;
    }
    #scan-region {
        position: absolute;
        top: 20%;
        left: 20%;
        width: 60%;
        height: 60%;
        border: 3px dashed #0d6efd;
        border-radius: 8px;
        pointer-events: none;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { border-color: #0d6efd; }
        50% { border-color: #ffc107; }
        100% { border-color: #0d6efd; }
    }
    #result-overlay {
        position: absolute;
        bottom: 20px;
        left: 0;
        width: 100%;
        background: rgba(0,0,0,0.8);
        color: white;
        padding: 15px;
        border-radius: 0 0 8px 8px;
        display: none;
    }
    .scan-animation {
        position: absolute;
        top: 20%;
        left: 20%;
        width: 60%;
        height: 2px;
        background: #0d6efd;
        animation: scan 2s linear infinite;
    } 
    @keyframes scan {
        0% { top: 20%; }
        50% { top: 80%; }
        100% { top: 20%; }
    }
    .qr-data-box {
        max-height: 200px;
        overflow-y: auto;
        font-size: 12px;
    }
    .hidden {
        display: none !important;
    }
    .scanner-active {
        border: 3px solid #28a745 !important;
        box-shadow: 0 0 20px rgba(40, 167, 69, 0.3);
    }
    #scanner-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 100;
    }
</style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-camera-video me-2"></i> Scan QR Code via Webcam (Realtime)
                    </h5>
                </div>
                <div class="card-body">
                    <div id="scanner-container" class="mb-4">
                        <div id="reader"></div>
                        <div id="scanner-loading" class="hidden">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div class="mt-2 text-muted">Initializing camera...</div>
                        </div>
                        <div id="scan-region" class="hidden">
                            <div class="scan-animation"></div>
                        </div>
                        <div id="result-overlay">
                            <div id="result-content"></div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-success" id="start-btn">
                                    <i class="bi bi-camera-video me-1"></i> Start Camera
                                </button>
                                <button type="button" class="btn btn-danger hidden" id="stop-btn">
                                    <i class="bi bi-camera-video-off me-1"></i> Stop Camera
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-primary" id="switch-camera">
                                    <i class="bi bi-arrow-left-right me-1"></i> Switch Camera
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="toggle-flash" disabled>
                                    <i class="bi bi-lightbulb me-1"></i> Flash
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info mb-3">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Tips:</strong> Jika QR Code tidak terbaca, gunakan input manual di bawah atau salin teks QR Code di halaman sebelumnya.
                    </div>
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0">Hasil Scan</h6>
                        </div>
                        <div class="card-body">
                            <form id="scan-form" method="POST" action="{{ route('barang.tarik_sarpras') }}">
                                @csrf
                                
                                <div class="row mb-3">
                                    <div class="col-md-8">
                                        <label class="form-label">Kode Barang</label>
                                        <div class="input-group">
                                            <input type="text" 
                                                   name="qr_string" 
                                                   id="kode-barang" 
                                                   class="form-control" 
                                                   readonly
                                                   placeholder="Kode akan terisi otomatis setelah scan">
                                            <button type="button" class="btn btn-outline-secondary" id="manual-input-btn">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                        <div class="form-text">
                                            Kode diekstrak dari QR Code
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Lokasi *</label>
                                        <select name="lokasi_id" class="form-select" required>
                                            <option value="">-- Pilih Lokasi --</option>
                                            @foreach($lokasi as $l)
                                                <option value="{{ $l->id }}">{{ $l->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div id="parsing-result" class="hidden">
                                        <h6>Hasil Parsing:</h6>
                                        <div class="p-3 bg-light rounded">
                                            <div id="parsing-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div id="item-details" class="hidden">
                                        <h6>Detail Barang:</h6>
                                        <div class="p-3 bg-light rounded">
                                            <div id="detail-content"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" id="reset-btn">
                                        <i class="bi bi-arrow-clockwise me-1"></i> Reset
                                    </button>
                                    <div>                            
                                        <button type="submit" class="btn btn-success" id="submit-btn" disabled>
                                            <i class="bi bi-cloud-download me-1"></i> Tarik dari SARPRAS
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#debug-info">
                            <i class="bi bi-bug me-1"></i> Debug Info
                        </button>
                        
                        <div class="collapse mt-2" id="debug-info">
                            <div class="card card-body">
                                <h6>Status Scanner:</h6>
                                <div id="scanner-status" class="text-muted">Belum diinisialisasi</div>
                                
                                <h6 class="mt-2">Data QR Terakhir:</h6>
                                <div id="last-qr-data" class="qr-data-box p-2 bg-dark text-light rounded"></div>
                                
                                <h6 class="mt-2">Log:</h6>
                                <div id="log-container" class="qr-data-box p-2 bg-light rounded" style="height: 100px; overflow-y: auto;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="parsingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="parsingModalTitle">Hasil Parsing QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="parsingModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="useParsedResultBtn">Gunakan Kode</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="manualInputModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Manual QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tempelkan teks QR Code:</label>
                    <textarea id="manual-qr-input" class="form-control" rows="4" 
                              placeholder="Contoh: https://keeply.aryajaka.site/kodeunik=1.1.112.BMW-01/jenis=kendaraan
atau langsung kodenya: 1.1.112.BMW-01"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="processManualQR()">Proses</button>
            </div>
        </div>
    </div>
</div>
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrCode = null;
let isScanning = false;
let currentCameraId = null;
let cameras = [];
let lastScannedText = '';
const elements = {
    reader: document.getElementById('reader'),
    startBtn: document.getElementById('start-btn'),
    stopBtn: document.getElementById('stop-btn'),
    switchBtn: document.getElementById('switch-camera'),
    flashBtn: document.getElementById('toggle-flash'),
    resetBtn: document.getElementById('reset-btn'),
    testParsingBtn: document.getElementById('test-parsing-btn'),
    submitBtn: document.getElementById('submit-btn'),
    kodeInput: document.getElementById('kode-barang'),
    manualInputBtn: document.getElementById('manual-input-btn'),
    resultOverlay: document.getElementById('result-overlay'),
    resultContent: document.getElementById('result-content'),
    parsingResult: document.getElementById('parsing-result'),
    parsingContent: document.getElementById('parsing-content'),
    itemDetails: document.getElementById('item-details'),
    detailContent: document.getElementById('detail-content'),
    lastQrData: document.getElementById('last-qr-data'),
    logContainer: document.getElementById('log-container'),
    scannerStatus: document.getElementById('scanner-status'),
    scannerLoading: document.getElementById('scanner-loading'),
    scanRegion: document.getElementById('scan-region')
};
function addLog(message, type = 'info') {
    const timestamp = new Date().toLocaleTimeString();
    const logEntry = document.createElement('div');
    logEntry.innerHTML = `<small>[${timestamp}] ${message}</small>`;
    logEntry.className = type === 'error' ? 'text-danger' : type === 'success' ? 'text-success' : 'text-muted';
    if (elements.logContainer) {
        elements.logContainer.appendChild(logEntry);
        elements.logContainer.scrollTop = elements.logContainer.scrollHeight;
    }
    console.log(`[${type.toUpperCase()}] ${message}`);
}
function updateScannerStatus(status, isError = false) {
    if (elements.scannerStatus) {
        elements.scannerStatus.textContent = status;
        elements.scannerStatus.className = isError ? 'text-danger' : 'text-success';
    }
}
function showResultOverlay(message, isSuccess = true) {
    if (elements.resultOverlay && elements.resultContent) {
        elements.resultOverlay.style.display = 'block';
        elements.resultContent.innerHTML = `
            <div class="${isSuccess ? 'text-success' : 'text-danger'}">
                <i class="bi ${isSuccess ? 'bi-check-circle' : 'bi-x-circle'} me-2"></i>
                <strong>${message}</strong>
            </div>
        `;
        setTimeout(() => {
            elements.resultOverlay.style.display = 'none';
        }, 3000);
    }
}
function setExampleQR(type) {
    let exampleText = '';
    if (type === 'url') {
        exampleText = 'https://keeply.aryajaka.site/kodeunik=1.1.112.BMW-01/jenis=kendaraan';
    } else if (type === 'kode') {
        exampleText = '1.1.112.BMW-01';
    }
    processScannedQR(exampleText);
    addLog(`Contoh QR di-set: ${type}`, 'info');
}
function processScannedQR(qrText) {
    if (!qrText || qrText === lastScannedText) {
        return;
    }
    lastScannedText = qrText;
    if (elements.lastQrData) {
        elements.lastQrData.textContent = qrText;
    }
    showResultOverlay('QR Code terdeteksi! Memproses...', true);
    addLog(`QR terdeteksi: ${qrText.substring(0, 100)}${qrText.length > 100 ? '...' : ''}`, 'success');
    validateAndParseQR(qrText);
}
async function validateAndParseQR(qrText) {
    try {
        addLog('Mengirim QR ke server untuk parsing...');
        
        const response = await fetch('{{ route("barang.validate_webcam_qr") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ qr_data: qrText })
        });
        
        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }
        const data = await response.json();
        addLog('Response dari server diterima', 'success');
        
        if (data.success) {
            if (elements.kodeInput) {
                elements.kodeInput.value = data.kode;
            }
            
            showParsingResult(data, qrText);
            if (elements.submitBtn) {
                if (data.exists) {
                    elements.submitBtn.disabled = true;
                    elements.submitBtn.innerHTML = '<i class="bi bi-x-circle me-1"></i> Barang Sudah Ada';
                } else if (data.sarpras_data) {
                    elements.submitBtn.disabled = false;
                    elements.submitBtn.innerHTML = '<i class="bi bi-cloud-download me-1"></i> Tarik dari SARPRAS';
                } else {
                    elements.submitBtn.disabled = true;
                    elements.submitBtn.innerHTML = '<i class="bi bi-exclamation-triangle me-1"></i> Tidak di SARPRAS';
                }
            }
            
        } else {
            showParsingError(data.message, qrText);
        }
    } catch (error) {
        console.error('Validation error:', error);
        addLog(`Error validasi: ${error.message}`, 'error');
        showResultOverlay('Gagal memvalidasi QR', false);
    }
}
function showParsingResult(data, qrText) {
    if (elements.parsingResult) {
        elements.parsingResult.classList.remove('hidden');
    }
    
    let html = '';
    
    if (data.exists) {
        html = `
            <div class="alert alert-warning mb-2">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Barang Sudah Ada di Database!</strong>
            </div>
            <table class="table table-sm table-bordered">
                <tr><th width="30%">Nama Barang</th><td>${data.barang.nama}</td></tr>
                <tr><th>Kode</th><td><code>${data.barang.kode}</code></td></tr>
                <tr><th>Lokasi</th><td>${data.barang.lokasi}</td></tr>
                <tr><th>Kondisi</th><td>${data.barang.kondisi}</td></tr>
            </table>
            <div class="text-muted small mt-2">
                <i class="bi bi-info-circle me-1"></i>
                ${data.message}
            </div>
        `;
        if (elements.itemDetails) {
            elements.itemDetails.classList.remove('hidden');
            elements.detailContent.innerHTML = `
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Barang ini sudah terdaftar di sistem.
                </div>
            `;
        }
        
    } else {
        html = `
            <div class="alert alert-success mb-2">
                <i class="bi bi-check-circle me-2"></i>
                <strong>Kode Valid - Barang Baru!</strong>
            </div>
            <table class="table table-sm table-bordered">
                <tr><th width="30%">Kode Barang</th><td><code>${data.kode}</code></td></tr>
                <tr><th>Teks QR Asli</th><td><small class="text-muted">${qrText.substring(0, 100)}${qrText.length > 100 ? '...' : ''}</small></td></tr>
                <tr><th>Status SARPRAS</th><td>
                    ${data.sarpras_data ? 
                        '<span class="badge bg-success">✓ Tersedia di SARPRAS</span>' : 
                        '<span class="badge bg-warning">✗ Tidak ditemukan di SARPRAS</span>'}
                </td></tr>
            </table>
            <div class="text-muted small mt-2">
                <i class="bi bi-info-circle me-1"></i>
                ${data.message}
            </div>
        `;
        if (data.sarpras_data && elements.itemDetails) {
            elements.itemDetails.classList.remove('hidden');
            elements.detailContent.innerHTML = `
                <div class="alert alert-info">
                    <i class="bi bi-cloud-check me-2"></i>
                    Data ditemukan di SARPRAS Pusat
                </div>
                <table class="table table-sm">
                    <tr><th>Nama Barang</th><td>${data.sarpras_data.namaBarang || '-'}</td></tr>
                    <tr><th>Merk</th><td>${data.sarpras_data.merk || '-'}</td></tr>
                    <tr><th>Spesifikasi</th><td>${data.sarpras_data.spesifikasi || '-'}</td></tr>
                </table>
            `;
        } else if (elements.itemDetails) {
            elements.itemDetails.classList.add('hidden');
        }
    }
    
    if (elements.parsingContent) {
        elements.parsingContent.innerHTML = html;
    }
}
function showParsingError(message, qrText) {
    if (elements.parsingResult) {
        elements.parsingResult.classList.remove('hidden');
    }
    
    if (elements.parsingContent) {
        elements.parsingContent.innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-x-circle me-2"></i>
                <strong>QR Code Tidak Valid!</strong>
            </div>
            <div class="mb-2">
                <strong>Teks QR:</strong>
                <div class="p-2 bg-light rounded mt-1">
                    <code style="word-break: break-all;">${qrText.substring(0, 200)}${qrText.length > 200 ? '...' : ''}</code>
                </div>
            </div>
            <div class="text-danger small">
                <i class="bi bi-exclamation-triangle me-1"></i>
                ${message}
            </div>
        `;
    }
    if (elements.kodeInput) elements.kodeInput.value = '';
    if (elements.submitBtn) {
        elements.submitBtn.disabled = true;
        elements.submitBtn.innerHTML = '<i class="bi bi-cloud-download me-1"></i> Tarik dari SARPRAS';
    }
    if (elements.itemDetails) elements.itemDetails.classList.add('hidden');
}
async function initializeScanner() {
    try {
        addLog('Menginisialisasi QR scanner...');
        updateScannerStatus('Menginisialisasi...');
        if (typeof Html5Qrcode === 'undefined') {
            throw new Error('HTML5 QR Code library tidak terload');
        }
        html5QrCode = new Html5Qrcode("reader");
        addLog('HTML5 QR Scanner diinisialisasi', 'success');
        try {
            cameras = await Html5Qrcode.getCameras();
            if (cameras && cameras.length > 0) {
                addLog(`Ditemukan ${cameras.length} kamera`, 'success');
                updateScannerStatus(`Siap (${cameras.length} kamera ditemukan)`);
                if (cameras.length > 1 && elements.switchBtn) {
                    elements.switchBtn.disabled = false;
                }
            } else {
                addLog('Tidak ada kamera yang ditemukan', 'warning');
                updateScannerStatus('Tidak ada kamera', true);
            }
        } catch (cameraError) {
            addLog(`Tidak bisa mendapatkan daftar kamera: ${cameraError.message}`, 'warning');
        }
        if (elements.startBtn) {
            elements.startBtn.disabled = false;
        }
        if (elements.scannerLoading) {
            elements.scannerLoading.classList.add('hidden');
        }
        return true;
    } catch (error) {
        console.error('Scanner initialization error:', error);
        addLog(`Error inisialisasi scanner: ${error.message}`, 'error');
        updateScannerStatus(`Error: ${error.message}`, true);
        alert(`Tidak dapat menginisialisasi scanner: ${error.message}\n\nPastikan:\n1. Browser mendukung camera API\n2. Izinkan akses kamera\n3. Gunakan HTTPS (untuk production)`);
        return false;
    }
}
async function startScanning() {
    if (isScanning || !html5QrCode) {
        return;
    }
    try {
        addLog('Memulai scanning...');
        updateScannerStatus('Memulai kamera...');
        if (elements.scannerLoading) {
            elements.scannerLoading.classList.remove('hidden');
        }
        if (elements.startBtn) {
            elements.startBtn.disabled = true;
            elements.startBtn.classList.add('hidden');
        }
        if (elements.stopBtn) {
            elements.stopBtn.classList.remove('hidden');
            elements.stopBtn.disabled = false;
        }
        if (elements.scanRegion) {
            elements.scanRegion.classList.remove('hidden');
        }
        const config = {
            fps: 10,
            qrbox: { width: 250, height: 250 },
            aspectRatio: 1.777778,
            disableFlip: false
        };
        const cameraId = currentCameraId || (cameras.length > 0 ? cameras[0].id : { facingMode: "environment" });  
        await html5QrCode.start(
            cameraId,
            config,
            onScanSuccess,  
            onScanFailure  
        );
        isScanning = true;
        addLog('Scanning dimulai', 'success');
        updateScannerStatus('Scanning aktif - Arahkan ke QR Code');
        if (elements.scannerLoading) {
            elements.scannerLoading.classList.add('hidden');
        }
        if (elements.reader) {
            elements.reader.classList.add('scanner-active');
        }
        
    } catch (error) {
        console.error('Start scanning error:', error);
        addLog(`Error memulai scanning: ${error.message}`, 'error');
        updateScannerStatus(`Error: ${error.message}`, true);
        if (elements.startBtn) {
            elements.startBtn.disabled = false;
            elements.startBtn.classList.remove('hidden');
        }
        if (elements.stopBtn) {
            elements.stopBtn.classList.add('hidden');
        }
        if (elements.scannerLoading) {
            elements.scannerLoading.classList.add('hidden');
        }
        alert(`Tidak dapat memulai kamera: ${error.message}\n\nPastikan izinkan akses kamera.`);
    }
}
async function stopScanning() {
    if (!isScanning || !html5QrCode) {
        return;
    }
    try {
        addLog('Menghentikan scanning...');
        await html5QrCode.stop();
        isScanning = false;
        if (elements.startBtn) {
            elements.startBtn.disabled = false;
            elements.startBtn.classList.remove('hidden');
        }
        if (elements.stopBtn) {
            elements.stopBtn.classList.add('hidden');
        }
        if (elements.scanRegion) {
            elements.scanRegion.classList.add('hidden');
        }
        if (elements.reader) {
            elements.reader.classList.remove('scanner-active');
        }
        addLog('Scanning dihentikan', 'info');
        updateScannerStatus('Scanning dihentikan');
    } catch (error) {
        console.error('Stop scanning error:', error);
        addLog(`Error menghentikan scanning: ${error.message}`, 'error');
    }
}
async function switchCamera() {
    if (!isScanning || cameras.length < 2) {
        return;
    }
    try {
        addLog('Berganti kamera...');
        await stopScanning();
        const currentIndex = cameras.findIndex(cam => cam.id === currentCameraId);
        const nextIndex = (currentIndex + 1) % cameras.length;
        currentCameraId = cameras[nextIndex].id;
        addLog(`Berganti ke kamera: ${cameras[nextIndex].label || 'Kamera ' + (nextIndex + 1)}`, 'info');
        setTimeout(startScanning, 500);
    } catch (error) {
        console.error('Switch camera error:', error);
        addLog(`Error berganti kamera: ${error.message}`, 'error');
    }
}
function onScanSuccess(decodedText, decodedResult) {
    processScannedQR(decodedText);
}
function onScanFailure(error) {
    if (error && !error.message?.includes('No QR code found')) {
        console.debug('Scan error:', error);
    }
}
function openManualInput() {
    const modal = new bootstrap.Modal(document.getElementById('manualInputModal'));
    modal.show();
    setTimeout(() => {
        document.getElementById('manual-qr-input').focus();
    }, 500);
}
function processManualQR() {
    const qrText = document.getElementById('manual-qr-input').value.trim();
    if (!qrText) {
        alert('Masukkan teks QR Code terlebih dahulu!');
        return;
    }
    const modal = bootstrap.Modal.getInstance(document.getElementById('manualInputModal'));
    modal.hide();
    processScannedQR(qrText);
    document.getElementById('manual-qr-input').value = '';
}
function testParsing() {
    const qrText = elements.kodeInput.value || lastScannedText;
    if (!qrText) {
        alert('Scan QR Code terlebih dahulu atau masukkan kode manual!');
        return;
    }
    const modal = new bootstrap.Modal(document.getElementById('parsingModal'));
    document.getElementById('parsingModalTitle').textContent = 'Test Parsing QR Code';
    document.getElementById('parsingModalBody').innerHTML = `
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Memproses parsing...</p>
        </div>
    `;
    modal.show();
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
        if (data.success) {
            resultHtml = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    <strong>QR Code Berhasil Diparsing!</strong>
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
            document.getElementById('useParsedResultBtn').classList.remove('d-none');
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
            document.getElementById('useParsedResultBtn').classList.add('d-none');
        }
        
        document.getElementById('parsingModalBody').innerHTML = resultHtml;
    })
    .catch(error => {
        document.getElementById('parsingModalBody').innerHTML = `
            <div class="alert alert-danger">
                <i class="bi bi-x-circle me-2"></i>
                <strong>Error!</strong><br>
                ${error.message}
            </div>
        `;
    });
}
function resetForm() {
    if (elements.kodeInput) elements.kodeInput.value = '';
    if (elements.parsingResult) elements.parsingResult.classList.add('hidden');
    if (elements.itemDetails) elements.itemDetails.classList.add('hidden');
    if (elements.submitBtn) {
        elements.submitBtn.disabled = true;
        elements.submitBtn.innerHTML = '<i class="bi bi-cloud-download me-1"></i> Tarik dari SARPRAS';
    }
    if (elements.lastQrData) elements.lastQrData.textContent = '';
    if (elements.logContainer) {
        elements.logContainer.innerHTML = '';
    }
    addLog('Form direset', 'info');
}
document.addEventListener('DOMContentLoaded', function() {
    console.log('Scan Webcam Page Loading...');
    initializeScanner();
    if (elements.startBtn) {
        elements.startBtn.addEventListener('click', startScanning);
    }
    if (elements.stopBtn) {
        elements.stopBtn.addEventListener('click', stopScanning);
    }
    if (elements.switchBtn) {
        elements.switchBtn.addEventListener('click', switchCamera);
    }
    if (elements.manualInputBtn) {
        elements.manualInputBtn.addEventListener('click', openManualInput);
    }
    if (elements.resetBtn) {
        elements.resetBtn.addEventListener('click', resetForm);
    }
    if (elements.testParsingBtn) {
        elements.testParsingBtn.addEventListener('click', testParsing);
    }
    document.getElementById('useParsedResultBtn').addEventListener('click', function() {
        if (lastScannedText) {
            processScannedQR(lastScannedText);
        }
        const modal = bootstrap.Modal.getInstance(document.getElementById('parsingModal'));
        modal.hide();
    });
    window.addEventListener('beforeunload', function() {
        if (isScanning && html5QrCode) {
            html5QrCode.stop().catch(() => {});
        }
    });
    addLog('Halaman scan webcam siap', 'success');
});
</script>
@endsection