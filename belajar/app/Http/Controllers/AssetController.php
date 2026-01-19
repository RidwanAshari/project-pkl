<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// -----------------------------------------------------------
// 1. ROUTE DASHBOARD (Halaman Utama)
// Ketika buka http://127.0.0.1:8000/ , yang muncul adalah welcome.blade.php
// -----------------------------------------------------------
Route::get('/', function () {
    return view('welcome');
});


// -----------------------------------------------------------
// 2. ROUTE HALAMAN DATA ASET (Clean UI)
// Ketika buka http://127.0.0.1:8000/data-aset , yang muncul adalah tabel aset
// -----------------------------------------------------------
Route::get('/data-aset', function () {
    return view('assets.index');
});


// -----------------------------------------------------------
// 3. ROUTE API (Backend Logic untuk Tombol Tambah/Edit/Hapus)
// Dipanggil secara diam-diam oleh Javascript di file assets/index.blade.php
// -----------------------------------------------------------
Route::prefix('api/assets')->group(function () {
    // Ambil semua data
    Route::get('/', [AssetController::class, 'index']);
    
    // Simpan data baru
    Route::post('/', [AssetController::class, 'store']);
    
    // Update data yang ada
    Route::put('/{id}', [AssetController::class, 'update']);
    
    // Hapus data
    Route::delete('/{id}', [AssetController::class, 'destroy']);
});

public function store(Request $request)
{
    // Validasi
    $request->validate([
        'code' => 'required|unique:assets,code',
        'name' => 'required|string',
        'category' => 'required|string',
        'purchase_date' => 'required|date',
        'price' => 'required|numeric|min:0',
        'status' => 'required|in:Baik,Perbaikan,Rusak',
    ]);

    // Simpan
    $asset = Asset::create($request->all());
    
    return response()->json([
        'message' => 'Aset berhasil ditambahkan',
        'data' => $asset
    ], 201);
}