<?php
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::orderBy('nama')->get();
        return view('admin.guru.index', compact('guru'));
    }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:191',
            'email'    => 'required|email|unique:guru,email',
            'password' => 'required',
            'nip'      => 'nullable|string|max:50',
            'telepon'  => 'nullable|string|max:50',
            'jabatan'  => 'nullable|string|max:100',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'guru_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_guru'), $filename);
            $fotoPath = 'uploads/foto_guru/' . $filename;
        }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        Guru::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password,
            'nip'      => $request->nip,
            'telepon'  => $request->telepon,
            'jabatan'  => $request->jabatan,
            'foto'     => $fotoPath,
        ]);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        return back()->with('success', 'Guru berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $guru = Guru::findOrFail($id);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $request->validate([
            'nama'    => 'required|string|max:191',
            'email'   => 'required|email|unique:guru,email,' . $guru->id,
            'nip'     => 'nullable|string|max:50',
            'telepon' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        if ($request->hasFile('foto')) {
            if ($guru->foto && file_exists(public_path($guru->foto))) {
                unlink(public_path($guru->foto));
            }

            $file = $request->file('foto');
            $filename = 'guru_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_guru'), $filename);
            $guru->foto = 'uploads/foto_guru/' . $filename;
        }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $guru->nama     = $request->nama;
        $guru->email    = $request->email;
        $guru->nip      = $request->nip;
        $guru->telepon  = $request->telepon;
        $guru->jabatan  = $request->jabatan;

        if ($request->password) {
            $guru->password = $request->password;
        }
<<<<<<< HEAD
        $guru->save();
=======

        $guru->save();

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        return back()->with('success', 'Guru berhasil diperbarui');
    }
    public function destroy($id)
    {
        $guru = Guru::findOrFail($id);
<<<<<<< HEAD
        if ($guru->foto && file_exists(public_path($guru->foto))) {
            unlink(public_path($guru->foto));
        }
        $guru->delete();
=======

        if ($guru->foto && file_exists(public_path($guru->foto))) {
            unlink(public_path($guru->foto));
        }

        $guru->delete();

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        return back()->with('success', 'Guru berhasil dihapus');
    }
}
