<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku; 

class UserController extends Controller
{
    public function dashboard()
    {
        return view('user/dashboard');
    }
    public function logout(Request $request)
{
    Auth::logout(); // Menghapus sesi login user

    $request->session()->invalidate(); // Membatalkan sesi
    $request->session()->regenerateToken(); // Membuat ulang token CSRF demi keamanan

    return redirect('/login'); // Arahkan ke halaman login
}
    public function buku()
    {
        // Mengambil semua data buku dari database
        $buku = Buku::all(); 
        
        // Mengarahkan ke file resources/views/User/buku.blade.php
        return view('User.buku', compact('buku'));

{
    $search = $request->input('search');
    
    // Ambil data buku, jika ada pencarian maka filter berdasarkan judul atau penulis
    $buku = \App\Models\Buku::when($search, function($query) use ($search) {
        return $query->where('judul', 'like', "%{$search}%")
                     ->orWhere('penulis', 'like', "%{$search}%");
    })->get();

    return view('User.buku', compact('buku'));
    if ($request->filled('kategori')) {
        $query->where('kategori', $request->kategori);
    }

    $buku = $query->get();

    return view('User.buku', compact('buku'));
}
    }
}




