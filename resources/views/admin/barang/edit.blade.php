<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h4>Edit Barang</h4>

    <form action="{{ route('barang.update',$barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <input class="form-control mb-2" name="nama" value="{{ $barang->nama }}" required>
        <input class="form-control mb-2" name="stok" type="number" value="{{ $barang->stok }}" required>
        <input class="form-control mb-2" name="kondisi" value="{{ $barang->kondisi }}">
        <input type="file" class="form-control mb-2" name="qr_code_file">
        <button class="btn btn-success">Update</button>
    </form>
</div>

</body>
</html>
