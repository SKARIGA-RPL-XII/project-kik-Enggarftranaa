<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; // Tambahkan ini untuk mengelola file fisik

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Memproses pembaruan data profil dan foto
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. LOGIKA PENYIMPANAN GAMBAR (Pindah langsung ke folder PUBLIC)
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
            // Tentukan folder tujuan di public/img/avatars
            $destinationPath = public_path('img/avatars');

            // Buat folder otomatis jika belum ada
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Hapus foto lama jika ada di folder tersebut
            if ($user->avatar && File::exists($destinationPath . '/' . $user->avatar)) {
                File::delete($destinationPath . '/' . $user->avatar);
            }

            // Pindahkan file baru
            $file->move($destinationPath, $fileName);
            
            // Simpan nama file ke database
            $user->avatar = $fileName;
        }

        // 3. Update info dasar
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('status', 'profile-updated');
    }
}