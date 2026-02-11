<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku; 
use App\Models\Category;
use App\Models\User;
use App\Models\Peminjaman; // Pastikan model ini di-import

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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, 
            'role' => 'user',
        ]);

        return redirect()->back()->with('success', 'Anggota baru berhasil didaftarkan!');
    }

    // Memperbarui data anggota
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

    // Reset password ke default
    public function resetPassword($id)
    {
        $user = User::findOrFail($id);
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

    public function cekStatusPinjam($buku_id)
    {
        // Menggunakan Auth::id() untuk menghindari error 'Undefined method id'
        $userId = Auth::id();

        $cek = Peminjaman::where('user_id', $userId)
                ->where('buku_id', $buku_id)
                ->whereIn('status', ['dipinjam', 'Dipinjam', 'PINJAM'])
                // Opsional: Hapus baris di bawah jika ingin mengecek tanpa batas waktu 10 menit
                ->where('created_at', '>=', now()->subMinutes(10))
                ->first();

        if ($cek) {
            return response()->json(['approved' => true]);
        }

        return response()->json(['approved' => false]);
    }
}