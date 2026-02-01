<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('inputAspirasis')->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ket_kategoris' => 'required|string|max:30|unique:kategoris,ket_kategoris',
        ], [
            'ket_kategoris.required' => 'Nama kategori wajib diisi',
            'ket_kategoris.max' => 'Nama kategori maksimal 30 karakter',
            'ket_kategoris.unique' => 'Kategori sudah ada',
        ]);

        Kategori::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'ket_kategoris' => 'required|string|unique:kategoris,ket_kategoris,' . $id,
        ], [
            'ket_kategoris.required' => 'Nama kategori wajib diisi',
            'ket_kategoris.max' => 'Nama kategori maksimal 30 karakter',
            'ket_kategoris.unique' => 'Kategori sudah ada',
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        
        
        if ($kategori->inputAspirasis()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan!');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus!');
    }
}