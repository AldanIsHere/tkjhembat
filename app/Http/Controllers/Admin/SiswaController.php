<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::orderBy('nama')->get();
        return view('admin.siswa.index', compact('siswa'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:191',
            'email'    => 'required|email|unique:siswa,email',
            'password' => 'required',
            'nis'      => 'nullable|string|max:50',
            'kelas'    => 'nullable|string|max:50',
            'jurusan'  => 'nullable|string|max:100',
            'telepon'  => 'nullable|string|max:50',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'siswa_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_siswa'), $filename);
            $fotoPath = 'uploads/foto_siswa/' . $filename;
        }
        Siswa::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password,
            'nis'      => $request->nis,
            'kelas'    => $request->kelas,
            'jurusan'  => $request->jurusan,
            'telepon'  => $request->telepon,
            'foto'     => $fotoPath,
        ]);
        return back()->with('success', 'Siswa berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nama'    => 'required|string|max:191',
            'email'   => 'required|email|unique:siswa,email,' . $siswa->id,
            'nis'     => 'nullable|string|max:50',
            'kelas'   => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
            'telepon' => 'nullable|string|max:50',
            'foto'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto && file_exists(public_path($siswa->foto))) {
                unlink(public_path($siswa->foto));
            }

            $file = $request->file('foto');
            $filename = 'siswa_' . time() . '_' . Str::random(6) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/foto_siswa'), $filename);
            $siswa->foto = 'uploads/foto_siswa/' . $filename;
        }
        $siswa->nama     = $request->nama;
        $siswa->email    = $request->email;
        $siswa->nis      = $request->nis;
        $siswa->kelas    = $request->kelas;
        $siswa->jurusan  = $request->jurusan;
        $siswa->telepon  = $request->telepon;

        if ($request->password) {
            $siswa->password = $request->password;
        }
        $siswa->save();
        return back()->with('success', 'Siswa berhasil diperbarui');
    }
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        if ($siswa->foto && file_exists(public_path($siswa->foto))) {
            unlink(public_path($siswa->foto));
        }
        $siswa->delete();
        return back()->with('success', 'Siswa berhasil dihapus');
    }
}
