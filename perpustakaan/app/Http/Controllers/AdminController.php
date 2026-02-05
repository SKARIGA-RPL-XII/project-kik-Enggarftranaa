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

    /* --- LOGIKA DATA BUKU --- */

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

    /* --- LOGIKA SCANNER QR (DIPERBARUI) --- */

    public function showScanner()
    {
        return view('admin.scan');
    }

    /**
     * AJAX: Mencari data User dengan pembersihan input otomatis
     */
    public function getDataScan($payload)
{
    // 1. Inisialisasi ID yang akan dicari
    $userId = $payload;

    // 2. Cek apakah payload mengandung format pipa "|" (seperti USER:3|BUKU:1)
    if (str_contains($payload, '|')) {
        $parts = explode('|', $payload);
        foreach ($parts as $part) {
            // Cari bagian yang mengandung "USER:"
            if (str_starts_with($part, 'USER:')) {
                $userId = str_replace('USER:', '', $part);
                break;
            }
        }
    } 
    // 3. Jika bukan format pipa, tapi ada awalan "USER:" saja
    else if (str_starts_with($payload, 'USER:')) {
        $userId = str_replace('USER:', '', $payload);
    }

    // 4. Cari di database berdasarkan ID yang sudah diekstrak
    $user = User::find($userId);
    
    if ($user) {
        return response()->json([
            'success' => true,
            'user' => [
                'nama' => $user->name,
                'email' => $user->email,
                'foto' => $user->avatar ? asset('img/avatars/'.$user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random',
            ],
            // Opsional: Jika Anda ingin mengirim info buku yang ada di QR juga
            'debug_payload' => $payload 
        ]);
    }

    return response()->json([
        'success' => false, 
        'message' => 'User dengan ID ' . $userId . ' tidak ditemukan. (Data asli: ' . $payload . ')'
    ]);
}
}