<?php

namespace App\Http\Controllers\Admin;

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

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'base_url' => 'required',
            'tipe_auth' => 'required',
        ]);

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

    public function update(Request $request, $id)
    {
        $api = ApiSarpras::findOrFail($id);

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

        return back()->with('success', 'API Sarpras berhasil diperbarui');
    }

    public function destroy($id)
    {
        ApiSarpras::findOrFail($id)->delete();
        return back()->with('success', 'API Sarpras berhasil dihapus');
    }
}
