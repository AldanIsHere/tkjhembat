<?php
<<<<<<< HEAD
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;
=======

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lokasi;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class LokasiController extends Controller
{
    public function index()
    {
        $lokasi = Lokasi::orderBy('id', 'DESC')->get();
        return view('admin.lokasi.index', compact('lokasi'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
            'penanggung_jawab' => 'nullable|string|max:191',
            'foto_penanggung_jawab' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $foto = null;
        if ($request->hasFile('foto_penanggung_jawab')) {
            $file = $request->file('foto_penanggung_jawab');
            $foto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_penanggung_jawab'), $foto);
        }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        Lokasi::create([
            'nama' => $request->nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'foto_penanggung_jawab' => $foto,
            'keterangan' => $request->keterangan,
        ]);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        return redirect()
            ->route('lokasi.index')
            ->with('success', 'Lokasi berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $lokasi = Lokasi::findOrFail($id);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $request->validate([
            'nama' => 'required|string|max:191',
            'penanggung_jawab' => 'nullable|string|max:191',
            'foto_penanggung_jawab' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string',
        ]);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $data = [
            'nama' => $request->nama,
            'penanggung_jawab' => $request->penanggung_jawab,
            'keterangan' => $request->keterangan,
        ];
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        if ($request->hasFile('foto_penanggung_jawab')) {
            if ($lokasi->foto_penanggung_jawab &&
                file_exists(public_path('uploads/foto_penanggung_jawab/' . $lokasi->foto_penanggung_jawab))) {
                unlink(public_path('uploads/foto_penanggung_jawab/' . $lokasi->foto_penanggung_jawab));
            }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            $file = $request->file('foto_penanggung_jawab');
            $foto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/foto_penanggung_jawab'), $foto);
            $data['foto_penanggung_jawab'] = $foto;
        }
<<<<<<< HEAD
        $lokasi->update($data);
=======

        $lokasi->update($data);

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        return redirect()
            ->route('lokasi.index')
            ->with('success', 'Lokasi berhasil diperbarui');
    }
    public function destroy($id)
    {
        $lokasi = Lokasi::findOrFail($id);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        if ($lokasi->foto_penanggung_jawab &&
            file_exists(public_path('uploads/foto_penanggung_jawab/' . $lokasi->foto_penanggung_jawab))) {
            unlink(public_path('uploads/foto_penanggung_jawab/' . $lokasi->foto_penanggung_jawab));
        }
<<<<<<< HEAD
        $lokasi->delete();
=======

        $lokasi->delete();

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        return redirect()
            ->route('lokasi.index')
            ->with('success', 'Lokasi berhasil dihapus');
    }
}
