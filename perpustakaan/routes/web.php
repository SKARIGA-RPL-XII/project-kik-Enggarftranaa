<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    AdminController,
    UserController,
    BukuController,
    KategoriController,
    PeminjamanController,
    ProfileController,
    QRController
};

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/register', 'register')->name('register');
    Route::post('/register', 'store');
    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- PROFILE ---
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile/update', 'update')->name('profile.update');
    });

    // --- USER SIDE (PEMINJAM) ---
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [BukuController::class, 'indexUser'])->name('dashboard');
        Route::get('/buku', [BukuController::class, 'indexUser'])->name('buku');
        
        // Fitur Peminjaman & Generate Tiket QR
        Route::get('/pinjam/{id}', [PeminjamanController::class, 'pinjam'])->name('pinjam.buku');
        Route::get('/pinjam/tiket/{id}', [QRController::class, 'generateTicket'])->name('generate.qr');
        Route::get('/generate-qr/{id}', function ($id) {
            $buku = \App\Models\Buku::findOrFail($id);
            return view('user.generate-qr', compact('buku'));
        })->name('manual.qr');
    });

    // --- ADMIN SIDE (PUSTAKAWAN) ---
    // Middleware 'is_admin' pastikan sudah terdaftar di Kernel.php Anda
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // CRUD Resources
        Route::resource('buku', BukuController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('user', UserController::class);
        Route::put('user/{id}/reset', [UserController::class, 'resetPassword'])->name('user.reset');

        // Fitur Scanner
        Route::get('/scan', [AdminController::class, 'showScanner'])->name('scan');
        Route::get('/get-peminjam/{user_id}/{buku_id}', [AdminController::class, 'getDataScan']);
        Route::post('/proses-pinjam', [AdminController::class, 'prosesPinjam'])->name('proses.pinjam');

        // Log / Riwayat Peminjaman
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
        
        // Tombol Kembalikan (Fixed Name)
        Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
        Route::post('/peminjaman/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    });
});