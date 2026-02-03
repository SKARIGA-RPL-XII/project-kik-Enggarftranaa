<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * UNTUK USER: Menampilkan Katalog Digital di Halaman Dashboard
     */
    public function indexUser(Request $request)
    {
        // 1. Ambil semua kategori untuk dropdown filter (Variabel: $categories)
        $categories = Category::all();

        // 2. Query dasar dengan relasi kategori
        $query = Buku::with('kategori');

        // 3. Filter Pencarian (Judul/Penulis)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
            });
        }

        // 4. Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        $buku = $query->latest()->get();

        // Mengarah ke view dashboard dan mengirim variabel $categories
        return view('user.dashboard', compact('buku', 'categories'));
    }

    /**
     * UNTUK ADMIN: Menampilkan Management Buku
     */
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->get();
        $categories = Category::all();
        return view('admin.buku', compact('buku', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Buku::create($data);
        return redirect()->back()->with('success', 'Buku berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'stok' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();

        if ($request->hasFile('cover')) {
            if ($buku->cover) Storage::disk('public')->delete($buku->cover);
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);
        return redirect()->back()->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover) Storage::disk('public')->delete($buku->cover);
        $buku->delete();
        
        return redirect()->back()->with('success', 'Buku telah dihapus.');
    }
}