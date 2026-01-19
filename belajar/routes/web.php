<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// halaman login (GET)
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

// proses login (POST)
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post')
    ->middleware('guest');

// logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// dashboard (halaman utama setelah login)
Route::get('/', function () {
    return view('dashboard');   // resources/views/dashboard.blade.php
})->middleware('auth')->name('dashboard');

// halaman Data Aset
Route::get('/data-aset', function () {
    return view('assets.index');
})->middleware('auth');

// halaman History
Route::get('/history', function () {
    return view('history');
})->middleware('auth');

// halaman Kategori
Route::get('/kategori', function () {
    return view('kategori');
})->middleware('auth');
