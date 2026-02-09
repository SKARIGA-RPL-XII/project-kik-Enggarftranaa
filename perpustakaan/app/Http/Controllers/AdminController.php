<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\Buku;
use App\Models\Category;
use App\Models\Peminjaman;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /* |--------------------------------------------------------------------------
    | LOGIKA DATA BUKU (MANUAL)
    |--------------------------------------------------------------------------
    | Catatan: Jika Anda menggunakan Resource Controller (BukuController),
    | method di bawah ini mungkin tidak terpakai lewat route resource, 
    | tapi saya biarkan di sini sesuai permintaan Anda.
    */

    public function dataBuku()
    {
        $buku = Buku::with('kategori')->get(); 
        $categories = Category::all();
        return view('admin.buku', compact('buku', 'categories'));
    }

    public function storeBuku(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'category_id' => 'required|exists:categories,id',
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
            'category_id' => $request->category_id,
            'penulis' => $request->penulis,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'cover' => $path
        ]);

        return redirect()->back()->with('success', 'Koleksi baru berhasil ditambahkan!');
    }

    public function updateBuku(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'category_id' => 'required',
            'penulis' => 'required',
            'stok' => 'required|numeric',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $buku = Buku::findOrFail($id);
        $data = $request->only(['judul', 'category_id', 'penulis', 'stok', 'deskripsi']);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);
        return redirect()->back()->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroyBuku($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }

    /* |--------------------------------------------------------------------------
    | LOGIKA SCANNER QR (FIXED & MATCHED WITH JS)
    |--------------------------------------------------------------------------
    */

    public function showScanner() {
        return view('admin.scan');
    }

    /**
     * AJAX: Fungsi ini dipanggil oleh fetch() di admin/scan.blade.php
     * Mengembalikan JSON data User dan Buku
     */
    public function getDataScan($user_id, $buku_id) {
        $user = User::find($user_id);
        $buku = Buku::find($buku_id);

        if (!$user || !$buku) {
            return response()->json([
                'success' => false, 
                'message' => 'Data User atau Buku tidak valid/tidak ditemukan.'
            ]);
        }

        // PENTING: Struktur JSON ini disesuaikan dengan scan.blade.php
        return response()->json([
            'success' => true,
            'user' => [
                'id_asli' => $user->id, // Dipakai di input hidden user_id_input
                'nama' => $user->name,
                'email' => $user->email,
                // Gunakan foto avatar atau default UI Avatars jika null
                'foto' => $user->avatar ? asset('storage/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=1e40af&color=fff',
            ],
            'buku' => [
                'id' => $buku->id, // Dipakai di input hidden buku_id_input
                'judul' => $buku->judul,
                'kode' => $buku->kode ?? 'BOOK-'.$buku->id, // Handle jika kolom kode kosong
                // Gunakan cover buku atau placeholder abu-abu
                'cover_url' => $buku->cover ? asset('storage/'.$buku->cover) : 'https://placehold.co/150x200?text=No+Cover',
            ]
        ]);
    }

    /**
     * Menyimpan data transaksi peminjaman ke database
     */
    public function prosesPinjam(Request $request) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'buku_id' => 'required|exists:buku,id',
            'tgl_kembali' => 'required|date'
        ]);

        // Cek stok sebelum meminjam
        $buku = Buku::find($request->buku_id);
        if($buku->stok < 1) {
            return redirect()->back()->with('error', 'Gagal! Stok buku habis.');
        }

        // Simpan Peminjaman
        Peminjaman::create([
            'user_id' => $request->user_id,
            'buku_id' => $request->buku_id,
            'tgl_pinjam' => now(),
            'tgl_kembali' => $request->tgl_kembali,
            'status' => 'dipinjam' // Pastikan kolom ini ada di tabel database Anda
        ]);

        // Kurangi Stok
        $buku->decrement('stok');

        return redirect()->route('admin.scan')->with('success', 'Transaksi Peminjaman Berhasil!');
    }
}