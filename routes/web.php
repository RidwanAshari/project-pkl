<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetBiayaController;
use App\Http\Controllers\AssetPinjamanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PemegangController;
use Illuminate\Support\Facades\Route;

// Publik
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('qr/{kode_aset}', [AssetController::class, 'qrRedirect'])->name('qr.redirect');

// Proteksi
Route::middleware(['auth'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Data Aset
    Route::get('assets/export-excel', [AssetController::class, 'exportExcel'])->name('assets.export-excel');
    Route::resource('assets', AssetController::class);
    Route::post('assets/{asset}/transfer', [AssetController::class, 'transfer'])->name('assets.transfer');
    Route::get('assets/{asset}/sticker', [AssetController::class, 'printSticker'])->name('assets.sticker');
    Route::get('history/{history}/download-ba', [AssetController::class, 'downloadBA'])->name('history.download-ba');

    // Data Aset Biaya
    Route::get('assets-biaya/export-excel', [AssetBiayaController::class, 'exportExcel'])->name('assets-biaya.export-excel');
    Route::resource('assets-biaya', AssetBiayaController::class)->names('assets-biaya');

    // Data Aset Pinjaman
    Route::get('assets-pinjaman/export-excel', [AssetPinjamanController::class, 'exportExcel'])->name('assets-pinjaman.export-excel');
    Route::resource('assets-pinjaman', AssetPinjamanController::class)->names('assets-pinjaman');

    // Kelola Pemegang Aset
    Route::get('settings/pemegang', [PemegangController::class, 'index'])->name('settings.pemegang');
    Route::post('settings/pemegang', [PemegangController::class, 'store'])->name('settings.pemegang.store');
    Route::put('settings/pemegang/{user}', [PemegangController::class, 'update'])->name('settings.pemegang.update');
    Route::delete('settings/pemegang/{user}', [PemegangController::class, 'destroy'])->name('settings.pemegang.destroy');

    // Report
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/by-category', [ReportController::class, 'byCategory'])->name('reports.by-category');
    Route::get('reports/by-condition', [ReportController::class, 'byCondition'])->name('reports.by-condition');
    Route::get('reports/by-holder', [ReportController::class, 'byHolder'])->name('reports.by-holder');
    Route::get('reports/export-pdf', [ReportController::class, 'exportPDF'])->name('reports.export-pdf');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/backup', [SettingsController::class, 'backupDatabase'])->name('settings.backup');
    Route::post('settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::get('settings/backups', [SettingsController::class, 'listBackups'])->name('settings.backups');
    Route::get('settings/backups/{filename}/download', [SettingsController::class, 'downloadBackup'])->name('settings.download-backup');
    Route::delete('settings/backups/{filename}', [SettingsController::class, 'deleteBackup'])->name('settings.delete-backup');

    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');

    // Vehicle
    Route::get('vehicles/{asset}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('vehicles/{asset}/edit-identity', [VehicleController::class, 'editIdentity'])->name('vehicles.edit-identity');
    Route::put('vehicles/{asset}/update-identity', [VehicleController::class, 'updateIdentity'])->name('vehicles.update-identity');
    Route::get('vehicles/{asset}/create-maintenance', [VehicleController::class, 'createMaintenance'])->name('vehicles.create-maintenance');
    Route::post('vehicles/{asset}/store-maintenance', [VehicleController::class, 'storeMaintenance'])->name('vehicles.store-maintenance');
    Route::delete('vehicles/{asset}/maintenance/{maintenance}', [VehicleController::class, 'deleteMaintenance'])->name('vehicles.delete-maintenance');
    Route::get('vehicles/{asset}/report-cost', [VehicleController::class, 'reportCost'])->name('vehicles.report-cost');
    Route::get('vehicles/{asset}/maintenance/{maintenance}/download-surat', [VehicleController::class, 'downloadSuratPengantar'])->name('vehicles.download-surat');
});