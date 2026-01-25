<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;

class GuruProfileController extends Controller
{
    // TAMPIL + EDIT PROFIL (SATU HALAMAN)
    public function index()
    {
        $guru = Guru::findOrFail(session('user_id'));
        return view('guru.profile', compact('guru'));
    }

    // EDIT TIDAK DIPAKAI (REDIRECT)
    public function edit()
    {
        return redirect()->route('guru.profile');
    }

    // UPDATE PROFIL
    public function update(Request $request)
    {
        $guru = Guru::findOrFail(session('user_id'));

        $data = $request->only([
            'nama',
            'telepon',
            'jabatan'
        ]);

        // ================= FOTO PROFIL =================
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');
            $filename = 'guru_' . $guru->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('uploads/foto_guru');

            // buat folder jika belum ada
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            // hapus foto lama
            if ($guru->foto && file_exists(public_path($guru->foto))) {
                unlink(public_path($guru->foto));
            }

            $file->move($path, $filename);
            $data['foto'] = 'uploads/foto_guru/' . $filename;
        }

        $guru->update($data);

        return redirect()
            ->route('guru.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
