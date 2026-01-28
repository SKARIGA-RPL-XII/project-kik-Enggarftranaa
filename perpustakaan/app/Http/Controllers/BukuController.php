<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    // Menampilkan semua daftar buku (untuk sisi Admin)
    public function index()
    {
        $semuaBuku = buku::latest()->get();
        return view('admin.buku.index', compact('semuaBuku'));
    }

    // Menampilkan form tambah buku
    public function create()
    {
        return view('admin.buku.create');
    }

    // Menyimpan buku baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'stok' => 'required|integer|min:1',
        ]);

        Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'status' => 'tersedia', // Default saat buku baru ditambah
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Menampilkan form edit buku
    public function edit(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    // Memperbarui data buku
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'status' => 'required|in:tersedia,dipinjam,perbaikan',
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Data buku berhasil diperbarui!');
    }

    // Menghapus buku
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku telah dihapus.');
    }
}

