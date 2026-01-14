<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Login (Root)
Route::get('/', function () {
    // Kalau sudah login (simulasi session), lempar ke dashboard
    if (session('isLoggedIn')) {
        return redirect('/dashboard');
    }
    return view('login');
});

// 2. Halaman Login Eksplisit
Route::get('/login', function () {
    return view('login');
});

// 3. Halaman Dashboard
Route::get('/dashboard', function () {
    return view('welcome');
});

// 4. Halaman Data Aset
Route::get('/data-aset', function () {
    return view('assets.index');
});

// 5. Halaman History
Route::get('/history', function () {
    return view('history');
});

// 6. Halaman Kategori
// ...
Route::get('/kategori', function () {
    return view('kategori');
});