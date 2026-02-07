<?php
<<<<<<< HEAD
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
=======

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class ProfilController extends Controller
{
    public function index()
    {
        $user = Siswa::findOrFail(session('user_id'));
        return view('siswa.profile', compact('user'));
    }
    public function edit()
    {
        return redirect()->route('siswa.profile');
    }
    public function update(Request $request)
    {
        $user = Siswa::findOrFail(session('user_id'));
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $data = $request->only([
            'nama',
            'email',
            'kelas',
            'jurusan',
            'telepon'
        ]);
        if ($request->hasFile('foto')) {
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
            $file = $request->file('foto');
            $namaFile = 'siswa_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

            $path = public_path('uploads/foto_siswa');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if ($user->foto && file_exists(public_path($user->foto))) {
                unlink(public_path($user->foto));
            }
            $file->move($path, $namaFile);
            $data['foto'] = 'uploads/foto_siswa/' . $namaFile;
        }
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
        $user->update($data);
        return redirect()
            ->route('siswa.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
