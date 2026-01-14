<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Route;

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Asset Routes
Route::resource('assets', AssetController::class);
Route::post('assets/{asset}/transfer', [AssetController::class, 'transfer'])->name('assets.transfer');
Route::get('assets/{asset}/sticker', [AssetController::class, 'printSticker'])->name('assets.sticker');