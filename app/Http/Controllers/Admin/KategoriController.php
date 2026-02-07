<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::orderBy('id', 'DESC')->get();
        return view('admin.kategori.index', compact('kategori'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
            'deskripsi' => 'nullable|string',
        ]);

        Kategori::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:191',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }
    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
