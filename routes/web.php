<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;

// ===============================
// ROUTE PUBLIK
// ===============================

// login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// register
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// redirect dari QR (boleh publik)
Route::get('qr/{kode_aset}', [AssetController::class, 'qrRedirect'])->name('qr.redirect');


// ===============================
// ROUTE BUTUH LOGIN
// ===============================

Route::middleware(['auth'])->group(function () {

    // logout (butuh login)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // alias home -> dashboard (biar route('home') gak error)
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    // asset
    Route::resource('assets', AssetController::class);
    Route::post('assets/{asset}/transfer', [AssetController::class, 'transfer'])->name('assets.transfer');
    Route::get('assets/{asset}/sticker', [AssetController::class, 'printSticker'])->name('assets.sticker');
    Route::get('history/{history}/download-ba', [AssetController::class, 'downloadBA'])->name('history.download-ba');

    // laporan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/by-category', [ReportController::class, 'byCategory'])->name('reports.by-category');
    Route::get('reports/by-condition', [ReportController::class, 'byCondition'])->name('reports.by-condition');
    Route::get('reports/by-holder', [ReportController::class, 'byHolder'])->name('reports.by-holder');
    Route::get('reports/export-pdf', [ReportController::class, 'exportPDF'])->name('reports.export-pdf');

    // settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/backup', [SettingsController::class, 'backupDatabase'])->name('settings.backup');
    Route::post('settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::get('settings/backups', [SettingsController::class, 'listBackups'])->name('settings.backups');
    Route::get('settings/backups/{filename}/download', [SettingsController::class, 'downloadBackup'])->name('settings.download-backup');
    Route::delete('settings/backups/{filename}', [SettingsController::class, 'deleteBackup'])->name('settings.delete-backup');

    // profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');

    // kendaraan
    Route::get('vehicles/{asset}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('vehicles/{asset}/edit-identity', [VehicleController::class, 'editIdentity'])->name('vehicles.edit-identity');
    Route::put('vehicles/{asset}/update-identity', [VehicleController::class, 'updateIdentity'])->name('vehicles.update-identity');

    Route::get('vehicles/{asset}/create-maintenance', [VehicleController::class, 'createMaintenance'])->name('vehicles.create-maintenance');
    Route::post('vehicles/{asset}/store-maintenance', [VehicleController::class, 'storeMaintenance'])->name('vehicles.store-maintenance');
    Route::delete('vehicles/{asset}/maintenance/{maintenance}', [VehicleController::class, 'deleteMaintenance'])->name('vehicles.delete-maintenance');
    Route::get('vehicles/{asset}/report-cost', [VehicleController::class, 'reportCost'])->name('vehicles.report-cost');

    // download surat (controller tetap wajib cek is_acc_kabag)
    Route::get(
        'vehicles/{asset}/maintenance/{maintenance}/download-surat',
        [VehicleController::class, 'downloadSuratPengantar']
    )->name('vehicles.download-surat');

    // ===============================
    // KHUSUS ROLE KABAG
    // ===============================
    Route::middleware(['role:kabag'])->group(function () {
        Route::get('/kabag/acc-surat', [VehicleController::class, 'accIndex'])->name('kabag.acc.index');
        Route::post('/kabag/acc-surat/{id}', [VehicleController::class, 'accSurat'])->name('kabag.acc.store');
    });
    // review pdf (khas kabag)
Route::get('/kabag/maintenance/{maintenance}/review-surat', [VehicleController::class, 'reviewSuratPengantar'])
    ->name('kabag.surat.review');

// tolak surat
Route::post('/kabag/acc-surat/{id}/reject', [VehicleController::class, 'rejectSurat'])
    ->name('kabag.acc.reject');


// Upload Nota - FORM
Route::post('/vehicles/{id}/upload-nota',
    [VehicleController::class, 'uploadNota'])
    ->name('vehicles.uploadNota');


// Upload Nota - SIMPAN
Route::post(
    'vehicles/{asset}/maintenance/{maintenance}/upload-nota',
    [VehicleController::class, 'storeNota']
)->name('vehicles.store-nota');





});
