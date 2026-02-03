<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku; 
use App\Models\Category;
use App\Models\User;

class UserController extends Controller
{
    /**
     * ==========================================
     * FITUR UNTUK ADMIN (MANAJEMEN ANGGOTA)
     * ==========================================
     */

    // Menampilkan daftar anggota
    public function index()
    {
        $users = User::latest()->get(); 
        return view('admin.user', compact('users'));
    }

    // Menyimpan anggota baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        // Karena Model User menggunakan cast 'hashed', 
        // kita CUKUP mengirim teks biasa, Laravel akan meng-hash otomatis.
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, 
            'role' => 'user', // Sesuaikan dengan kebutuhan role Anda
        ]);

        return redirect()->back()->with('success', 'Anggota baru berhasil didaftarkan!');
    }

    // Memperbarui data anggota (Nama & Email)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Data anggota berhasil diperbarui!');
    }

    // Menghapus anggota
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun anggota telah dihapus.');
    }

    // Reset password ke default: 12345678
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
        
        // PENTING: Jangan gunakan Hash::make di sini agar tidak double hash
        $user->update([
            'password' => '12345678' 
        ]);

        return redirect()->back()->with('success', "Password {$user->name} telah dikembalikan ke: 12345678");
    }


    /**
     * ==========================================
     * FITUR UNTUK USER (KATALOG & DASHBOARD)
     * ==========================================
     */

    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function buku(Request $request)
    {
        $categories = Category::all();
        $query = Buku::with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }

        $buku = $query->latest()->get();
        return view('user.buku', compact('buku', 'categories'));
    }
}