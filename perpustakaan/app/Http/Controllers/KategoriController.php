<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category; // Sesuaikan jika nama model Anda 'Kategori'
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index()
    {
        // withCount('buku') akan memberikan atribut 'buku_count' secara otomatis
        $categories = Category::withCount('buku')->get();
        
        return view('admin.kategori', compact('categories'));
    }

    /**
     * Menyimpan kategori baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|unique:categories,nama|max:100',
        ], [
            'nama.unique' => 'Nama kategori ini sudah ada!',
        ]);

        Category::create([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Memperbarui kategori
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'nama' => 'required|max:100|unique:categories,nama,' . $id,
        ]);

        $category->update([
            'nama' => $request->nama,
            'slug' => Str::slug($request->nama)
        ]);

        return redirect()->back()->with('success', 'Nama kategori berhasil diubah.');
    }

    /**
     * Menghapus kategori
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Cek apakah ada buku yang masih menggunakan kategori ini
        if ($category->buku()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh beberapa buku.');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori telah berhasil dihapus.');
    }
}