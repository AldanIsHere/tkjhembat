<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aturan;

class AturanController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $aturan = Aturan::orderBy('id', 'DESC')->get();
        return view('admin.aturan.index', compact('aturan'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
            'deskripsi' => 'nullable|string',
            'aktif' => 'required|boolean',

            // OPTIONAL - boleh kosong
            'maks_hari' => 'nullable|integer',
            'denda_hari' => 'nullable|numeric',
            'perlu_setuju' => 'nullable|boolean',
            'role_setuju' => 'nullable|string|max:50',
        ]);

        Aturan::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'aktif' => $request->aktif,

            // optional
            'maks_hari' => $request->maks_hari,
            'denda_hari' => $request->denda_hari,
            'perlu_setuju' => $request->perlu_setuju,
            'role_setuju' => $request->role_setuju,
        ]);

        return redirect()
            ->route('aturan.index')
            ->with('success', 'Aturan berhasil ditambahkan');
    }

    // ================= UPDATE =================
    public function update(Request $request, $id)
    {
        $aturan = Aturan::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:191',
            'deskripsi' => 'nullable|string',
            'aktif' => 'required|boolean',

            // OPTIONAL
            'maks_hari' => 'nullable|integer',
            'denda_hari' => 'nullable|numeric',
            'perlu_setuju' => 'nullable|boolean',
            'role_setuju' => 'nullable|string|max:50',
        ]);

        $aturan->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'aktif' => $request->aktif,
            'maks_hari' => $request->maks_hari,
            'denda_hari' => $request->denda_hari,
            'perlu_setuju' => $request->perlu_setuju,
            'role_setuju' => $request->role_setuju,
        ]);

        return redirect()
            ->route('aturan.index')
            ->with('success', 'Aturan berhasil diperbarui');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        Aturan::findOrFail($id)->delete();

        return redirect()
            ->route('aturan.index')
            ->with('success', 'Aturan berhasil dihapus');
    }
}
