<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang; 

class BarangApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Data semua barang',
            'data' => Barang::all()
        ]);
    }

    public function store(Request $request)
    {
        $barang = Barang::create($request->all());
        return response()->json(['success' => true, 'data' => $barang]);
    }
    public function show($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail barang',
            'data' => $barang
        ]);
    }
    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diupdate',
            'data' => $barang
        ]);
    }
    public function destroy($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}
