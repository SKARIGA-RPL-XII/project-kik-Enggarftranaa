<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

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