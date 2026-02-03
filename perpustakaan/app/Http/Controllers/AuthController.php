<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('Auth/login');
    }

    public function authenticate(Request $request)
    {
        // Gunakan validasi agar input bersih dari spasi yang tidak diinginkan
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role == 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/user/dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }

    public function register()
    {
        return view('Auth/register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required'
        ]);

        // JANGAN gunakan Hash::make di sini karena di Model sudah ada casts: 'hashed'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, 
            'role' => $request->role
        ]);

        return redirect('/login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}