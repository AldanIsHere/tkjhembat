<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h4>Tambah Barang</h4>

    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="form-control mb-2" name="nama" placeholder="Nama Barang" required>
        <input class="form-control mb-2" name="stok" type="number" placeholder="Stok" required>
        <input class="form-control mb-2" name="kondisi" placeholder="Kondisi">
        <input type="file" class="form-control mb-2" name="qr_code_file">
        <button class="btn btn-success">Simpan</button>
    </form>
</div>

</body>
</html>
