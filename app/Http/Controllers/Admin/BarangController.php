<?php
 /*
 untuk disini teknik yang dipakai untuk dapat kode unik adalah parsing/filter dari url di isi gambar qr karena memang isi dari qr nggak langsung kode unik dari barang iu sendiri.
 
 
 untuk membaca dari isi gambar qr itu sendiri kita pakai library SimpleSoftwareIO untuk membaca isi data dari gambar qr, setelah itu hasil dari scan gambar tadi yang berupa link url kita parsing/filter untuk dapat si kode unik, setelah kode unik kita dapatkan secara akurat, kita tembak pakai method GET ke base_url dari api sarpras yang ada(tujuan kenapa use model ApiSarpras karena kita akan pakai kolom base_url dari tabel/model ApiSarpras)


untuk tembak url api kita pakai curl.

untuk generate gambar qr untuk barang yang bukan sarpras juga pakai ibrary SimpleSoftwareIO

 */
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\ApiSarpras;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangController extends Controller
{
    public function index()
    {
        $barang   = Barang::with(['kategori','lokasi'])->orderBy('created_at','DESC')->get();
        $kategori = Kategori::orderBy('nama')->get();
        $lokasi   = Lokasi::orderBy('nama')->get();

        return view('admin.barang.index', compact('barang','kategori','lokasi'));
    }
    private function extractKodeUnikFromQR($qrString)
    {
        $qrString = trim($qrString);
        if (empty($qrString)) {
            return null;
        }
        if (preg_match('/kodeunik=([A-Za-z0-9.\-_]+)(?:\/|$|\s|&)/', $qrString, $matches)) {
            return $matches[1];
        }
        if (preg_match('/^([A-Za-z0-9.\-_]+)$/', $qrString, $matches)) {
            return $matches[1];
        }
        if (preg_match('/\/([A-Za-z0-9.\-_]+)\/jenis=/', $qrString, $matches)) {
            return $matches[1];
        }
        $parsedUrl = parse_url($qrString);
        if (isset($parsedUrl['path'])) {
            $path = trim($parsedUrl['path'], '/');
            $segments = explode('/', $path);
            foreach ($segments as $segment) {
                if (strpos($segment, 'kodeunik=') !== false) {
                    if (preg_match('/kodeunik=([A-Za-z0-9.\-_]+)/', $segment, $matches)) {
                        return $matches[1];
                    }
                }
                if (preg_match('/^[A-Za-z0-9.\-_]+$/', $segment) && strlen($segment) >= 5) {
                    return $segment;
                }
            }
        }
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            if (isset($queryParams['kodeunik'])) {
                return $queryParams['kodeunik'];
            }
            foreach ($queryParams as $value) {
                if (preg_match('/^[A-Za-z0-9.\-_]+$/', $value) && strlen($value) >= 5) {
                    return $value;
                }
            }
        }
        return null;
    }
    private function processQRImage($imageFile)
    {
        try {
            if (!$imageFile || !$imageFile->isValid()) {
                return ['success' => false, 'message' => 'File tidak valid'];
            }
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/bmp', 'image/webp'];
            $mimeType = $imageFile->getMimeType();
            
            if (!in_array($mimeType, $allowedTypes)) {
                return ['success' => false, 'message' => 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF'];
            }
            $maxSize = 5 * 1024 * 1024;
            if ($imageFile->getSize() > $maxSize) {
                return ['success' => false, 'message' => 'Ukuran file maksimal 5MB'];
            } 
            $tempPath = $imageFile->getPathname();
            $qrData = $this->decodeWithZbar($tempPath);
            if ($qrData['success']) {
                return $qrData;
            }
            $qrData = $this->decodeWithPhpQR($tempPath);
            if ($qrData['success']) {
                return $qrData;
            }  
            return $this->decodeManually($tempPath); 
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Error processing image: ' . $e->getMessage()];
        }
    }
    private function decodeWithZbar($imagePath)
    {
        if (!function_exists('exec')) {
            return ['success' => false, 'message' => 'exec() function tidak tersedia'];
        }
        
        exec('which zbarimg 2>/dev/null', $output, $returnCode);
        if ($returnCode !== 0) {
            return ['success' => false, 'message' => 'zbarimg tidak terinstall'];
        }
        
        $command = 'zbarimg --quiet --raw "' . escapeshellarg($imagePath) . '" 2>&1';
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && !empty($output)) {
            $qrText = trim(implode("\n", $output));
            return [
                'success' => true,
                'data' => $qrText,
                'method' => 'zbarimg'
            ];
        }
        
        return ['success' => false, 'message' => 'Gagal decode dengan zbarimg'];
    }
    
    /**
     * Decode QR menggunakan PHP QR Code Reader
     */
    private function decodeWithPhpQR($imagePath)
    {
        try {
            if (class_exists('Zxing\QrReader')) {
                $qrReader = new \Zxing\QrReader($imagePath);
                $qrText = $qrReader->text();
                
                if ($qrText) {
                    return [
                        'success' => true,
                        'data' => $qrText,
                        'method' => 'php-qrcode-reader'
                    ];
                }
            }
        } catch (\Exception $e) {
        }
        
        return ['success' => false, 'message' => 'Library QR decoder tidak tersedia'];
    }
    private function decodeManually($imagePath)
    {
        return [
            'success' => false,
            'message' => 'Tidak dapat membaca QR Code dari gambar. Pastikan gambar QR Code jelas dan tidak blur. Atau gunakan input manual dengan menyalin teks dari QR Code.'
        ];
    }

    public function tarikSarpras(Request $request)
    {
        if (!$request->lokasi_id || !Lokasi::find($request->lokasi_id)) {
            return back()->with('error', 'Lokasi harus dipilih');
        }
        $kode = $this->extractKodeFromRequest($request);
        
        if (!$kode) {
            return back()->with('error', 'Kode barang tidak ditemukan');
        }
        if (!preg_match('/^[A-Za-z0-9.\-_]+$/', $kode)) {
            return back()->with('error', 'Format kode tidak valid: ' . htmlspecialchars($kode));
        }
        
        if (Barang::where('kode', $kode)->exists()) {
            $existing = Barang::where('kode', $kode)->first();
            return back()->with('warning', 
                'Barang dengan kode "' . $kode . '" sudah ada: ' . $existing->nama . 
                ' (Lokasi: ' . ($existing->lokasi->nama ?? '-') . ')'
            );
        }
        $apiSarpras = ApiSarpras::where('aktif', 1)->first();
        if (!$apiSarpras) {
            return back()->with('error', 'API SARPRAS belum aktif. Hubungi administrator.');
        }
        $apiResult = $this->fetchFromSarprasAPI($apiSarpras, $kode);
        if (!$apiResult['success']) {
            return back()->with('error', $apiResult['message']);
        }
        
        $this->saveBarangFromAPI($apiResult['data'], $request->lokasi_id, $apiSarpras);
        
        return back()->with('success', 
            'Barang berhasil ditarik dari SARPRAS: ' . 
            $apiResult['data']['namaBarang'] . ' (' . $apiResult['data']['kodeUnik'] . ')'
        );
    }
    private function extractKodeFromRequest($request)
    {
        if ($request->filled('qr_string')) {
            return $this->extractKodeUnikFromQR($request->qr_string);
        }
        
        if ($request->filled('manual_kode')) {
            return trim($request->manual_kode);
        }
        
        if ($request->hasFile('qr_image') && $request->file('qr_image')->isValid()) {
            $imageResult = $this->processQRImage($request->file('qr_image'));
            if (!$imageResult['success']) {
                return null;
            }
            return $this->extractKodeUnikFromQR($imageResult['data']);
        }
        
        return null;
    }
    private function fetchFromSarprasAPI($apiSarpras, $kode)
    {
        try {
            $apiUrl = rtrim($apiSarpras->base_url, '/') . '/inventarisasi-kib/by-kode-barang/' . urlencode($kode);
            $headers = [];
            if ($apiSarpras->tipe_auth === 'bearer' && $apiSarpras->token) {
                $headers['Authorization'] = 'Bearer ' . $apiSarpras->token;
            } elseif ($apiSarpras->tipe_auth === 'api_key' && $apiSarpras->api_key) {
                $headers['X-API-KEY'] = $apiSarpras->api_key;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            if (!empty($headers)) {
                $headerArray = [];
                foreach ($headers as $key => $value) {
                    $headerArray[] = $key . ': ' . $value;
                }
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArray);
            }
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);
            if ($httpCode !== 200) {
                $message = $this->getErrorMessageFromHttpCode($httpCode, $error, $kode);
                return ['success' => false, 'message' => $message];
            }
            $responseData = json_decode($response, true);
            if (!$responseData || !isset($responseData['success']) || !$responseData['success']) {
                return ['success' => false, 'message' => 'Response tidak valid dari SARPRAS'];
            }
            if (!isset($responseData['data']) || empty($responseData['data'])) {
                return ['success' => false, 'message' => 'Data barang tidak ditemukan di response SARPRAS'];
            }
            $barangData = $responseData['data'];
            if (!isset($barangData['kodeUnik']) || empty($barangData['kodeUnik'])) {
                return ['success' => false, 'message' => 'Data kodeUnik tidak ditemukan dalam response'];
            }
            if (!isset($barangData['namaBarang']) || empty($barangData['namaBarang'])) {
                return ['success' => false, 'message' => 'Data namaBarang tidak ditemukan dalam response'];
            }
            return ['success' => true, 'data' => $barangData]; 
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()];
        }
    }
    private function getErrorMessageFromHttpCode($httpCode, $error, $kode)
    {
        switch ($httpCode) {
            case 404:
                return 'Barang dengan kode "' . $kode . '" tidak ditemukan di SARPRAS Pusat';
            case 401:
            case 403:
                return 'Akses ditolak oleh SARPRAS Pusat. Periksa konfigurasi API.';
            case 500:
                return 'Server SARPRAS Pusat mengalami masalah.';
            default:
                if ($error) {
                    return 'Koneksi gagal: ' . $error;
                }
                return 'Gagal mengambil data. Status: ' . $httpCode;
        }
    }
    private function saveBarangFromAPI($barangData, $lokasiId, $apiSarpras)
    {
        $barang = new Barang();
        $barang->kode = $barangData['kodeUnik'];
        $barang->nama = $barangData['namaBarang'];
        $barang->merk = $barangData['merk'] ?? null;
        $barang->spesifikasi = $barangData['spesifikasi'] ?? null;
        $barang->kategori_id = null;
        $barang->stok = 1;
        $barang->satuan = 'unit';
        $barang->kondisi = 'baik';
        $barang->lokasi_id = $lokasiId;
        $barang->keterangan = 'Barang ditarik dari SARPRAS Pusat - ' . date('d/m/Y H:i');
        $barang->tipe = 'sarpras';
        $barang->foto = $barangData['foto'] ?? null;
        $barang->qr_code = $barangData['qrCode'] ?? null;    
        $barang->sarpras_id = $barangData['id'] ?? null;
        $barang->sarpras_sync = 1;
        $barang->sarpras_last_sync = date('Y-m-d H:i:s');
        $barang->save();
        $apiSarpras->last_sync = date('Y-m-d H:i:s');
        $apiSarpras->save();
    }
    public function validateQR(Request $request)
    {
        if (!$request->qr_string) {
            return response()->json([
                'success' => false,
                'message' => 'QR string kosong'
            ]);
        }
        $kode = $this->extractKodeUnikFromQR($request->qr_string);
        if (!$kode) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengekstrak kode dari QR'
            ]);
        }
        $existing = Barang::where('kode', $kode)->first();
        if ($existing) {
            return response()->json([
                'success' => true,
                'kode' => $kode,
                'exists' => true,
                'message' => 'Barang sudah ada: ' . $existing->nama,
                'barang' => [
                    'nama' => $existing->nama,
                    'kode' => $existing->kode,
                    'lokasi' => $existing->lokasi->nama ?? '-'
                ]
            ]);
        }
        return response()->json([
            'success' => true,
            'kode' => $kode,
            'exists' => false,
            'message' => 'Kode valid: ' . $kode
        ]);
    }
    public function validateQRImage(Request $request)
    {
        if (!$request->hasFile('qr_image') || !$request->file('qr_image')->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'File gambar tidak valid'
            ]);
        }
        $imageResult = $this->processQRImage($request->file('qr_image'));
        if (!$imageResult['success']) {
            return response()->json([
                'success' => false,
                'message' => $imageResult['message']
            ]);
        }
        $qrText = $imageResult['data'];
        $kode = $this->extractKodeUnikFromQR($qrText);
        
        if (!$kode) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat mengekstrak kode dari QR: ' . substr($qrText, 0, 100)
            ]);
        }
        $existing = Barang::where('kode', $kode)->first();
        if ($existing) {
            return response()->json([
                'success' => true,
                'kode' => $kode,
                'qr_text' => $qrText,
                'method' => $imageResult['method'] ?? 'unknown',
                'exists' => true,
                'message' => 'Barang sudah ada: ' . $existing->nama,
                'barang' => [
                    'nama' => $existing->nama,
                    'kode' => $existing->kode,
                    'lokasi' => $existing->lokasi->nama ?? '-'
                ]
            ]);
        }
        return response()->json([
            'success' => true,
            'kode' => $kode,
            'qr_text' => $qrText,
            'method' => $imageResult['method'] ?? 'unknown',
            'exists' => false,
            'message' => 'Kode valid: ' . $kode . ' (dibaca dari gambar)'
        ]);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:barang,kode',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'stok' => 'required|integer|min:1',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
        ]);
        Barang::create([
            'kode'        => $request->kode,
            'nama'        => $request->nama,
            'kategori_id' => $request->kategori_id,
            'lokasi_id'   => $request->lokasi_id,
            'merk'        => $request->merk,
            'spesifikasi' => $request->spesifikasi,
            'stok'        => $request->stok,
            'satuan'      => $request->satuan,
            'kondisi'     => $request->kondisi,
            'keterangan'  => $request->keterangan,
            'foto'        => $request->foto,
            'tipe'        => 'lokal',
            'qr_code'     => null
        ]);
        return back()->with('success', 'Barang lokal berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id); 
        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:barang,kode,' . $id,
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi_id' => 'required|exists:lokasi,id',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|in:baik,rusak ringan,rusak berat',
        ]);
        $barang->nama = $request->nama;
        $barang->kode = $request->kode;
        $barang->kategori_id = $request->kategori_id;
        $barang->lokasi_id = $request->lokasi_id;
        $barang->merk = $request->merk;
        $barang->spesifikasi = $request->spesifikasi;
        $barang->stok = $request->stok;
        $barang->satuan = $request->satuan;
        $barang->kondisi = $request->kondisi;
        $barang->keterangan = $request->keterangan;
        if ($barang->tipe === 'lokal' && $request->foto) {
            $barang->foto = $request->foto;
        }
        $barang->save();
        return back()->with('success', 'Barang berhasil diperbarui');
    }
    public function destroy($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }
        $barang->delete();
        return back()->with('success', 'Barang berhasil dihapus');
    }
    public function syncSarpras($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }
        if ($barang->tipe !== 'sarpras') {
            return back()->with('error', 'Hanya barang dari SARPRAS yang bisa disinkronisasi');
        }
        $apiSarpras = ApiSarpras::where('aktif', 1)->first();
        if (!$apiSarpras) {
            return back()->with('error', 'API SARPRAS tidak aktif');
        }
        try {
            $apiUrl = rtrim($apiSarpras->base_url, '/') . '/inventarisasi-kib/by-kode-barang/' . $barang->kode;
            $headers = [];
            if ($apiSarpras->tipe_auth === 'bearer' && $apiSarpras->token) {
                $headers['Authorization'] = 'Bearer ' . $apiSarpras->token;
            } elseif ($apiSarpras->tipe_auth === 'api_key' && $apiSarpras->api_key) {
                $headers['X-API-KEY'] = $apiSarpras->api_key;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpCode === 200) {
                $responseData = json_decode($response, true);
                
                if (isset($responseData['data'])) {
                    $item = $responseData['data'];
                    
                    $barang->nama = $item['namaBarang'] ?? $barang->nama;
                    $barang->merk = $item['merk'] ?? $barang->merk;
                    $barang->spesifikasi = $item['spesifikasi'] ?? $barang->spesifikasi;
                    $barang->foto = $item['foto'] ?? $barang->foto;
                    $barang->qr_code = $item['qrCode'] ?? $barang->qr_code;
                    $barang->sarpras_last_sync = date('Y-m-d H:i:s');
                    $barang->save();
                    return back()->with('success', 'Data barang berhasil disinkronisasi');
                }
            }
            return back()->with('warning', 'Data barang tidak ditemukan di SARPRAS');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal sinkronisasi: ' . $e->getMessage());
        }
    }
    public function generateQr($id)
    {
        $barang = Barang::find($id);
        if (!$barang) {
            return back()->with('error', 'Barang tidak ditemukan');
        }
        if ($barang->qr_code) {
            return back()->with('warning', 'QR sudah ada');
        }
        $qrContent = $barang->kode;
        $fileName = 'qr_' . $barang->kode . '_' . time() . '.svg';
        $qrDir = public_path('uploads/qr_barang');
        if (!is_dir($qrDir)) {
            mkdir($qrDir, 0777, true);
        }
        $filePath = $qrDir . '/' . $fileName;
        try {
            $qrCode = QrCode::format('svg')
                ->size(300)
                ->margin(10)
                ->color(0, 0, 0)
                ->backgroundColor(255, 255, 255) 
                ->generate($qrContent);
            
            file_put_contents($filePath, $qrCode);
            $barang->qr_code = 'uploads/qr_barang/' . $fileName;
            $barang->save();
            return back()->with('success', 'QR Code berhasil dibuat dan disimpan sebagai SVG');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat QR Code: ' . $e->getMessage());
        }
    }
    public function scan()
    {
        $lokasi = Lokasi::orderBy('nama')->get();
        return view('admin.barang.scan', compact('lokasi'));
    }
    public function testApiConnection()
    {
        $apiSarpras = ApiSarpras::where('aktif', 1)->first();
        if (!$apiSarpras) {
            return response()->json([
                'success' => false,
                'message' => 'API SARPRAS tidak aktif'
            ]);
        }
        try { 
            $testUrl = rtrim($apiSarpras->base_url, '/') . '/';  
            $startTime = microtime(true);  
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $testUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $totalTime = curl_getinfo($ch, CURLINFO_TOTAL_TIME) * 1000; 
            curl_close($ch);
            $endTime = microtime(true);
            $responseTime = round(($endTime - $startTime) * 1000, 2);   
            if ($httpCode >= 200 && $httpCode < 400) {
                return response()->json([
                    'success' => true,
                    'status' => $httpCode,
                    'response_time' => $responseTime,
                    'message' => 'API SARPRAS dapat diakses'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => $httpCode,
                    'response_time' => $responseTime,
                    'message' => 'API merespons dengan status: ' . $httpCode
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
public function scanWebcam()
{
    $lokasi = Lokasi::orderBy('nama')->get();
    return view('admin.barang.scan-webcam', compact('lokasi'));
}
public function validateWebcamQR(Request $request)
{
    $request->validate([
        'qr_data' => 'required|string',
    ]);
    $qrData = $request->qr_data;
    $kode = $this->extractKodeUnikFromQR($qrData);
    if (!$kode) {
        return response()->json([
            'success' => false,
            'message' => 'Tidak dapat mengekstrak kode dari QR',
            'raw_data' => substr($qrData, 0, 100)
        ]);
    }
    $existing = Barang::where('kode', $kode)->first();
    if ($existing) {
        return response()->json([
            'success' => true,
            'kode' => $kode,
            'exists' => true,
            'barang' => [
                'nama' => $existing->nama,
                'kode' => $existing->kode,
                'lokasi' => $existing->lokasi->nama ?? '-',
                'kondisi' => $existing->kondisi,
                'foto' => $existing->foto
            ],
            'message' => 'Barang sudah ada: ' . $existing->nama
        ]);
    }
    $apiSarpras = ApiSarpras::where('aktif', 1)->first();
    $sarprasData = null;
    if ($apiSarpras) {
        $apiResult = $this->fetchFromSarprasAPI($apiSarpras, $kode);
        if ($apiResult['success']) {
            $sarprasData = $apiResult['data'];
        }
    }
    return response()->json([
        'success' => true,
        'kode' => $kode,
        'exists' => false,
        'sarpras_data' => $sarprasData,
        'message' => 'Kode valid: ' . $kode . ($sarprasData ? ' (Ditemukan di SARPRAS)' : ' (Tidak ditemukan di SARPRAS)')
    ]);
}
}