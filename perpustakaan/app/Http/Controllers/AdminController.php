<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Buku;      // Pastikan model Buku di-import
use App\Models\Category;  // Pastikan model Category di-import

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function dataBuku()
    {
        // Mengambil buku sekaligus kategorinya (Eager Loading)
    $buku = Buku::with('kategori')->get(); 
    $categories = Category::all();
    
    return view('admin.buku', compact('buku', 'categories'));
    }

    public function storeBuku(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'category_id' => 'required|exists:categories,id', // Validasi kategori
            'penulis' => 'required',
            'stok' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('covers', 'public');
        }

        Buku::create([
            'judul' => $request->judul,
            'category_id' => $request->category_id, // Simpan ID Kategori
            'penulis' => $request->penulis,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'cover' => $path
        ]);

        return redirect()->back()->with('success', 'Koleksi baru berhasil ditambahkan ke inventaris!');
    }
    public function updateBuku(Request $request, $id)
{
    // 1. Validasi input
    $request->validate([
        'judul' => 'required',
        'category_id' => 'required',
        'penulis' => 'required',
        'stok' => 'required|numeric',
        'deskripsi' => 'nullable',
        'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $buku = Buku::findOrFail($id);
    $data = [
        'judul' => $request->judul,
        'category_id' => $request->category_id,
        'penulis' => $request->penulis,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
    ];

    // 3. Logika ganti cover (Hapus yang lama, simpan yang baru)
    if ($request->hasFile('cover')) {
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $data['cover'] = $request->file('cover')->store('covers', 'public');
    }

    // 4. Eksekusi update
    $buku->update($data);

    return redirect()->back()->with('success', 'Data buku berhasil diperbarui!');
}
public function destroyBuku($id)
{
    // 1. Cari data buku berdasarkan ID, jika tidak ada akan muncul error 404
    $buku = Buku::findOrFail($id);

    // 2. Cek apakah buku memiliki file cover. Jika ada, hapus file fisiknya dari storage
    if ($buku->cover) {
        Storage::disk('public')->delete($buku->cover);
    }

    // 3. Hapus data buku dari database
    $buku->delete();

    // 4. Kembali ke halaman sebelumnya dengan pesan sukses
    return redirect()->back()->with('success', 'Buku telah berhasil dihapus dari sistem.');

 Buku::create([
        'judul' => $request->judul,
        'category_id' => $request->category_id, // Bagian ini yang sering terlewat
        'penulis' => $request->penulis,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
        // ... kode simpan cover ...
    ]);

    return redirect()->back()->with('success', 'Buku berhasil ditambah!');
    
}

}