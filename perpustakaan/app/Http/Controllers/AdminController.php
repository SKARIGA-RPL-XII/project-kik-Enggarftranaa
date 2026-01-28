<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function dataBuku()
{
    $buku = \App\Models\buku::all(); // Mengambil data dari database
    return view('Admin.buku', compact('buku'));
}

public function storeBuku(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'penulis' => 'required',
        'stok' => 'required|numeric',
        'cover' => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $path = null;
    if ($request->hasFile('cover')) {
        $path = $request->file('cover')->store('covers', 'public');
    }

    \App\Models\Buku::create([
        'judul' => $request->judul,
        'penulis' => $request->penulis,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
        'cover' => $path
    ]);

    return redirect()->back()->with('success', 'Buku berhasil ditambahkan!');
}
}
