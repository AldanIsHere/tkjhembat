<?php
namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
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
        $data = $request->only([
            'nama',
            'email',
            'kelas',
            'jurusan',
            'telepon'
        ]);
        if ($request->hasFile('foto')) {
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
        $user->update($data);
        return redirect()
            ->route('siswa.profile')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}
