<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login',[AuthController::class,'login'])->name('login');
Route::post('/login',[AuthController::class,'authenticate']);
Route::post('/logout',[AuthController::class,'logout']);

Route::get('/register',[AuthController::class,'register']);
Route::post('/register',[AuthController::class,'store']);

Route::get('/admin/dashboard', function () {
    return view('Admin.dashboard');
})->middleware('auth');

Route::get('/user/dashboard', function () {
    return view('User.dashboard');
})->middleware('auth');

Route::get('/user/buku', function () {
    return view('User.buku');
});