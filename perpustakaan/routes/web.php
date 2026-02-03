<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QRController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;

// --- GUEST ROUTES (Tanpa Login) ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- PROTECTED ROUTES (Harus Login) ---
Route::middleware('auth')->group(function () {
    
    // DASHBOARD UMUM
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/user/dashboard', function () {
        return view('User.dashboard');
    })->name('user.dashboard');

    // FITUR USER
    Route::get('/user/buku', [UserController::class, 'buku'])->name('user.buku');

    // FITUR ADMIN (Manajemen Buku)
    Route::prefix('admin')->group(function () {
        Route::get('/buku', [AdminController::class, 'databuku'])->name('admin.buku.index');
        Route::post('/buku/store', [AdminController::class, 'storeBuku'])->name('admin.buku.store');
        Route::put('/buku/update/{id}', [AdminController::class, 'updateBuku'])->name('admin.buku.update');
        Route::delete('/buku/delete/{id}', [AdminController::class, 'destroyBuku'])->name('admin.buku.destroy');
    });

});

// Pastikan user harus login dulu (auth)
Route::get('/pinjam/tiket/{id}', [QRController::class, 'generateTicket'])->name('user.generate.qr')->middleware('auth');
Route::get('/admin/scan', [AdminController::class, 'showScanner'])->name('admin.scan');
Route::post('/admin/proses-pinjam', [AdminController::class, 'prosesPinjam'])->name('admin.proses.pinjam');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/user', [AdminController::class, 'indexUser'])->name('admin.user.index');
    Route::post('/user/store', [AdminController::class, 'storeUser'])->name('admin.user.store');
    Route::delete('/user/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy');
});
Route::prefix('admin')->name('admin.')->group(function () {
    // Route CRUD Kategori
    Route::resource('kategori', KategoriController::class);
    
    // Route CRUD Buku (contoh)
    Route::resource('buku', BukuController::class);
}); 
// Route untuk Katalog User
Route::get('/user/buku', [BukuController::class, 'indexUser'])->name('user.buku');

// Route untuk Admin (Resource)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('buku', BukuController::class);
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Route resource untuk index, store, update, destroy
    Route::resource('user', UserController::class);
    
    // Route khusus untuk reset password
    Route::put('user/{id}/reset', [UserController::class, 'resetPassword'])->name('user.reset');
});
Route::get('/user/dashboard', [BukuController::class, 'indexUser'])->name('user.dashboard');
// Tambahkan ini di web.php
Route::get('/pinjam/{id}', [PeminjamanController::class, 'pinjam'])->name('pinjam.buku');
use App\Models\Buku;

// Pastikan namanya 'generate.qr' agar sesuai dengan route() di tombol Anda
Route::get('/generate-qr/{id}', function ($id) {
    $buku = Buku::findOrFail($id);
    return view('user.generate-qr', compact('buku'));
})->name('generate-qr');