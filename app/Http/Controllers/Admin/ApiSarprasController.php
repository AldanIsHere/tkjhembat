<?php
/*
nothing special kenapa nggak ditaruh di .env, hanya untuk mempermudah aja, cuma jeleknya adalah kalau api nya ganti kamu harus rubah juga yang ada di controller yang berhubungan dengan si Api ini, misal di Barang Controller dan lain lai

*/
namespace App\Http\Controllers\Admin;
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
use App\Http\Controllers\Controller;
use App\Models\ApiSarpras;
use Illuminate\Http\Request;

class ApiSarprasController extends Controller
{
    public function index()
    {
        $apiSarpras = ApiSarpras::orderBy('nama')->get();
        return view('admin.api_sarpras.index', compact('apiSarpras'));
    }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'base_url' => 'required',
            'tipe_auth' => 'required',
        ]);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        ApiSarpras::create([
            'nama' => $request->nama,
            'base_url' => $request->base_url,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'token' => $request->token,
            'tipe_auth' => $request->tipe_auth,
            'aktif' => $request->aktif ?? 0,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'API Sarpras berhasil ditambahkan');
    }
<<<<<<< HEAD
    public function update(Request $request, $id)
    {
        $api = ApiSarpras::findOrFail($id);
=======

    public function update(Request $request, $id)
    {
        $api = ApiSarpras::findOrFail($id);

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $api->update([
            'nama' => $request->nama,
            'base_url' => $request->base_url,
            'api_key' => $request->api_key,
            'api_secret' => $request->api_secret,
            'token' => $request->token,
            'tipe_auth' => $request->tipe_auth,
            'aktif' => $request->aktif ?? 0,
            'keterangan' => $request->keterangan,
        ]);
<<<<<<< HEAD
        return back()->with('success', 'API Sarpras berhasil diperbarui');
    }
=======

        return back()->with('success', 'API Sarpras berhasil diperbarui');
    }

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function destroy($id)
    {
        ApiSarpras::findOrFail($id)->delete();
        return back()->with('success', 'API Sarpras berhasil dihapus');
    }
}
