<?php

use Illuminate\Support\Facades\Route;

// 1. Halaman Utama = Login
Route::get('/', function () {
    // Kita HAPUS pengecekan session('isLoggedIn') karena Javascript di browser yang mengaturnya
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
Route::get('/kategori', function () {
    return view('kategori');
});

// Route untuk Menu Kategori
Route::get('/kategori', function () {
    return view('kategori');
});

// Route untuk Halaman Detail Kendaraan (Fitur Lengkap)
Route::get('/kategori-kendaraan', function () {
    return view('kategori-kendaraan');
});