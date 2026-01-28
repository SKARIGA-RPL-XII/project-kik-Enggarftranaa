<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// AUTHENTICATION
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // SUDAH DIPERBAIKI

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);

// DASHBOARD GROUP (Dengan Middleware Auth agar aman)
Route::middleware('auth')->group(function () {
    
    Route::get('/admin/dashboard', function () {
        return view('Admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/user/dashboard', function () {
        return view('User.dashboard');
    })->name('user.dashboard');


    // File: routes/web.php
// Pastikan pakai POST dan punya ->name('logout')
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
    Route::get('/buku', [AdminController::class, 'Buku'])->name('admin.buku.index');
// Rute untuk halaman buku di sisi User
Route::get('/user/buku', [UserController::class, 'buku'])->name('user.buku');
Route::get('/admin/buku', [AdminController::class, 'dataBuku'])->name('admin.buku.index');
Route::post('/admin/buku', [AdminController::class, 'storeBuku'])->name('admin.buku.store');
Route::delete('/admin/buku/{id}', [AdminController::class, 'destroyBuku'])->name('admin.buku.destroy');
