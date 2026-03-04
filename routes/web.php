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
use App\Http\Controllers\KabagController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\AssetDetailController;
use App\Http\Controllers\DepreciationController;
use Illuminate\Support\Facades\Route;

// Publik
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('qr/{kode_aset}', [AssetController::class, 'qrRedirect'])->name('qr.redirect');
Route::get('assets/qr/{kode_aset}', [AssetController::class, 'qrRedirect'])->name('assets.qr-redirect');

// Semua route dilindungi auth saja — pengecekan role ada di controller masing-masing
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/set-threshold', [DashboardController::class, 'setThreshold'])->name('dashboard.set-threshold');
    Route::get('/dashboard/stnk-notif', [DashboardController::class, 'stnkNotifApi'])->name('dashboard.stnk-notif');

    // Profil
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Finance
    Route::get('finance', [FinanceController::class, 'index'])->name('finance.index');
    Route::post('finance/create-dpb/{maintenance}', [FinanceController::class, 'createDpb'])->name('finance.create-dpb');
    Route::get('finance/download-dpb/{dpb}', [FinanceController::class, 'downloadDpb'])->name('finance.download-dpb');
    Route::post('finance/input-biaya/{maintenance}', [FinanceController::class, 'inputBiaya'])->name('finance.input-biaya');
    Route::get('finance/form-dpb/{maintenance}', [FinanceController::class, 'formDpb'])->name('finance.form-dpb');
    

    // Kabag
    Route::get('kabag', [KabagController::class, 'index'])->name('kabag.index');
    Route::get('kabag/surat/{maintenance}', [KabagController::class, 'showSurat'])->name('kabag.review-surat');
    Route::post('kabag/approve/{maintenance}', [KabagController::class, 'approve'])->name('kabag.approve');
    Route::post('kabag/reject/{maintenance}', [KabagController::class, 'reject'])->name('kabag.reject');
    Route::post('kabag/{maintenance}/approve-eko', [KabagController::class, 'approveEko'])->name('kabag.approve-eko');

    // Data Aset — trash HARUS sebelum resource agar tidak bentrok dengan {asset}
    Route::get('assets/export-excel', [AssetController::class, 'exportExcel'])->name('assets.export-excel');
    Route::get('assets/trash', [AssetController::class, 'trash'])->name('assets.trash');
    Route::post('assets/{id}/restore', [AssetController::class, 'restore'])->name('assets.restore');
    Route::delete('assets/{id}/force-delete', [AssetController::class, 'forceDelete'])->name('assets.force-delete');
    Route::resource('assets', AssetController::class);
    Route::post('assets/{asset}/transfer', [AssetController::class, 'transfer'])->name('assets.transfer');
    Route::get('assets/{asset}/sticker', [AssetController::class, 'printSticker'])->name('assets.sticker');
    Route::get('history/{history}/download-ba', [AssetController::class, 'downloadBA'])->name('history.download-ba');

    // Data Aset Biaya
    Route::get('assets-biaya/export-excel', [AssetBiayaController::class, 'exportExcel'])->name('assets-biaya.export-excel');
    Route::resource('assets-biaya', AssetBiayaController::class)->parameters(['assets-biaya' => 'asset'])->names('assets-biaya');

    // Data Aset Pinjaman
    Route::get('assets-pinjaman/export-excel', [AssetPinjamanController::class, 'exportExcel'])->name('assets-pinjaman.export-excel');
    Route::resource('assets-pinjaman', AssetPinjamanController::class)->parameters(['assets-pinjaman' => 'asset'])->names('assets-pinjaman');

    // Report
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/by-category', [ReportController::class, 'byCategory'])->name('reports.by-category');
    Route::get('reports/by-condition', [ReportController::class, 'byCondition'])->name('reports.by-condition');
    Route::get('reports/by-holder', [ReportController::class, 'byHolder'])->name('reports.by-holder');
    Route::get('reports/export-pdf', [ReportController::class, 'exportPDF'])->name('reports.export-pdf');

    // Vehicle
    Route::get('vehicles/{asset}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('vehicles/{asset}/edit-identity', [VehicleController::class, 'editIdentity'])->name('vehicles.edit-identity');
    Route::put('vehicles/{asset}/update-identity', [VehicleController::class, 'updateIdentity'])->name('vehicles.update-identity');
    Route::get('vehicles/{asset}/report-cost', [VehicleController::class, 'reportCost'])->name('vehicles.report-cost');
    Route::post('vehicles/{asset}/save-depreciation', [VehicleController::class, 'saveDepreciation'])->name('vehicles.save-depreciation');
    Route::get('vehicles/{asset}/maintenance/create', [VehicleController::class, 'createMaintenance'])->name('vehicles.maintenance.create');
    Route::post('vehicles/{asset}/maintenance', [VehicleController::class, 'storeMaintenance'])->name('vehicles.maintenance.store');
    Route::delete('vehicles/{asset}/maintenance/{maintenance}', [VehicleController::class, 'deleteMaintenance'])->name('vehicles.maintenance.delete');
    Route::get('vehicles/{asset}/maintenance/{maintenance}/surat-pengantar', [VehicleController::class, 'downloadSuratPengantar'])->name('vehicles.maintenance.surat-pengantar');
    Route::get('vehicles/{asset}/maintenance/{maintenance}/input-biaya', [VehicleController::class, 'formInputBiaya'])->name('vehicles.input-biaya');

    // Asset Detail non-kendaraan
    Route::get('asset-details/{asset}', [AssetDetailController::class, 'show'])->name('asset-details.show');
    Route::put('asset-details/{asset}/update-detail', [AssetDetailController::class, 'updateDetail'])->name('asset-details.update-detail');
    Route::post('asset-details/{asset}/maintenance', [AssetDetailController::class, 'storeMaintenance'])->name('asset-details.store-maintenance');
    Route::delete('asset-details/{asset}/maintenance/{maintenance}', [AssetDetailController::class, 'deleteMaintenance'])->name('asset-details.delete-maintenance');

    // Penyusutan
    Route::post('depreciations/{asset}', [DepreciationController::class, 'store'])->name('depreciations.store');
    Route::post('depreciations/{asset}/add-detail', [DepreciationController::class, 'addDetail'])->name('depreciations.add-detail');
    Route::delete('depreciations/{asset}/detail/{detail}', [DepreciationController::class, 'deleteDetail'])->name('depreciations.delete-detail');

    // Settings
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings/backup', [SettingsController::class, 'backupDatabase'])->name('settings.backup');
    Route::post('settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
    Route::get('settings/backups', [SettingsController::class, 'listBackups'])->name('settings.backups');
    Route::get('settings/backups/{filename}/download', [SettingsController::class, 'downloadBackup'])->name('settings.download-backup');
    Route::delete('settings/backups/{filename}', [SettingsController::class, 'deleteBackup'])->name('settings.delete-backup');

    // Pemegang
    Route::get('settings/pemegang', [PemegangController::class, 'index'])->name('settings.pemegang');
    Route::post('settings/pemegang', [PemegangController::class, 'store'])->name('settings.pemegang.store');
    Route::put('settings/pemegang/{user}', [PemegangController::class, 'update'])->name('settings.pemegang.update');
    Route::delete('settings/pemegang/{user}', [PemegangController::class, 'destroy'])->name('settings.pemegang.destroy');
    Route::put('settings/pemegang/{user}/role', [PemegangController::class, 'updateRole'])->name('settings.pemegang.update-role');

    // Bengkel
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/bengkel', [App\Http\Controllers\BengkelController::class, 'index'])->name('bengkel');
        Route::post('/bengkel', [App\Http\Controllers\BengkelController::class, 'store'])->name('bengkel.store');
        Route::put('/bengkel/{bengkel}', [App\Http\Controllers\BengkelController::class, 'update'])->name('bengkel.update');
        Route::delete('/bengkel/{bengkel}', [App\Http\Controllers\BengkelController::class, 'destroy'])->name('bengkel.destroy');
    });

});