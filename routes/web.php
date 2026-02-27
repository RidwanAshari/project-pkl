<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetBiayaController;
use App\Http\Controllers\AssetPinjamanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DpbController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| ROUTE PUBLIK
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Register
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Redirect dari QR (boleh publik)
Route::get('qr/{kode_aset}', [AssetController::class, 'qrRedirect'])->name('qr.redirect');

/*
|--------------------------------------------------------------------------
| ROUTE BUTUH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Alias home -> dashboard
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    /*
    |--------------------------------------------------------------------------
    | ASET UTAMA
    |--------------------------------------------------------------------------
    */
    Route::resource('assets', AssetController::class);
    Route::post('assets/{asset}/transfer', [AssetController::class, 'transfer'])->name('assets.transfer');
    Route::get('assets/{asset}/sticker', [AssetController::class, 'printSticker'])->name('assets.sticker');
    Route::get('history/{history}/download-ba', [AssetController::class, 'downloadBA'])->name('history.download-ba');

    /*
    |--------------------------------------------------------------------------
    | ASET BIAYA
    |--------------------------------------------------------------------------
    */
    Route::prefix('assets-biaya')->name('assets-biaya.')->group(function () {
        Route::get('/', [AssetBiayaController::class, 'index'])->name('index');
        Route::get('/export-excel', [AssetBiayaController::class, 'exportExcel'])->name('export-excel');

        // OPSI 1: form & simpan aset biaya
        Route::get('/create', [AssetBiayaController::class, 'create'])->name('create');
        Route::post('/store', [AssetBiayaController::class, 'store'])->name('store');
    });

    /*
    |--------------------------------------------------------------------------
    | ASET PINJAMAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('assets-pinjaman')->name('assets-pinjaman.')->group(function () {
        Route::get('/', [AssetPinjamanController::class, 'index'])->name('index');
        Route::get('create', [AssetPinjamanController::class, 'create'])->name('create');
        Route::post('store', [AssetPinjamanController::class, 'store'])->name('store');
        Route::get('edit/{asset}', [AssetPinjamanController::class, 'edit'])->name('edit');
        Route::put('update/{asset}', [AssetPinjamanController::class, 'update'])->name('update');
        Route::delete('destroy/{asset}', [AssetPinjamanController::class, 'destroy'])->name('destroy');

        // OPSI 1: export excel aset pinjaman
        Route::get('export-excel', [AssetPinjamanController::class, 'exportExcel'])
            ->name('export-excel');
    });

    /*
    |--------------------------------------------------------------------------
    | LAPORAN ASET (REPORTS)
    |--------------------------------------------------------------------------
    */
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/by-category', [ReportController::class, 'byCategory'])->name('by-category');
        Route::get('/by-condition', [ReportController::class, 'byCondition'])->name('by-condition');
        Route::get('/by-holder', [ReportController::class, 'byHolder'])->name('by-holder');
        Route::get('/export-pdf', [ReportController::class, 'exportPDF'])->name('export-pdf');
    });

    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::post('/backup', [SettingsController::class, 'backupDatabase'])->name('backup');
        Route::post('/clear-cache', [SettingsController::class, 'clearCache'])->name('clear-cache');
        Route::get('/backups', [SettingsController::class, 'listBackups'])->name('backups');
        Route::get('/backups/{filename}/download', [SettingsController::class, 'downloadBackup'])->name('download-backup');
        Route::delete('/backups/{filename}', [SettingsController::class, 'deleteBackup'])->name('delete-backup');
    });

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');

    /*
    |--------------------------------------------------------------------------
    | KENDARAAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('vehicles')->name('vehicles.')->group(function () {
        Route::get('{asset}', [VehicleController::class, 'show'])->name('show');
        Route::get('{asset}/edit-identity', [VehicleController::class, 'editIdentity'])->name('edit-identity');
        Route::put('{asset}/update-identity', [VehicleController::class, 'updateIdentity'])->name('update-identity');

        Route::get('{asset}/create-maintenance', [VehicleController::class, 'createMaintenance'])->name('create-maintenance');
        Route::post('{asset}/store-maintenance', [VehicleController::class, 'storeMaintenance'])->name('store-maintenance');
        Route::delete('{asset}/maintenance/{maintenance}', [VehicleController::class, 'deleteMaintenance'])->name('delete-maintenance');
        Route::get('{asset}/report-cost', [VehicleController::class, 'reportCost'])->name('report-cost');

        // Download surat pengantar
        Route::get(
            '{asset}/maintenance/{maintenance}/download-surat',
            [VehicleController::class, 'downloadSuratPengantar']
        )->name('download-surat');

        // Upload nota (STAFF)
        Route::get(
            '{asset}/maintenance/{maintenance}/upload-nota',
            [VehicleController::class, 'uploadNotaForm']
        )->name('upload-nota.form');

        Route::post(
            '{asset}/maintenance/{maintenance}/upload-nota',
            [VehicleController::class, 'storeNota']
        )->name('store-nota');

        // Proses nota (FINANCE)
        Route::get(
            'process-nota/{maintenance}',
            [VehicleController::class, 'processNotaForm']
        )->name('process_nota.form');

        Route::post(
            'process-nota/{maintenance}',
            [VehicleController::class, 'processNota']
        )->name('process_nota');

        // Cetak DPB
        Route::get(
            'print-dpb/{maintenance}',
            [VehicleController::class, 'printDpb']
        )->name('printDpb');
    });

    /*
    |--------------------------------------------------------------------------
    | KHUSUS ROLE KABAG
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:kabag'])->group(function () {
        Route::get('/kabag/acc-surat', [VehicleController::class, 'accIndex'])->name('kabag.acc.index');
        Route::post('/kabag/acc-surat/{id}', [VehicleController::class, 'accSurat'])->name('kabag.acc.store');

        Route::get('/kabag/maintenance/{maintenance}/review-surat', [VehicleController::class, 'reviewSuratPengantar'])
            ->name('kabag.surat.review');

        Route::post('/kabag/acc-surat/{id}/reject', [VehicleController::class, 'rejectSurat'])
            ->name('kabag.acc.reject');
    });

    /*
    |--------------------------------------------------------------------------
    | FINANCE
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:finance'])
        ->prefix('finance')
        ->name('finance.')
        ->group(function () {

            // Laporan finance
            Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

            // DPB
            Route::get('/dpb', [DpbController::class, 'inbox'])->name('dpb.inbox');
            Route::get('/dpb/create/{maintenance}', [DpbController::class, 'create'])->name('dpb.create');
            Route::post('/dpb/store/{maintenance}', [DpbController::class, 'store'])->name('dpb.store');
            Route::get('/dpb/{dpb}', [DpbController::class, 'show'])->name('dpb.show');
        });

    /*
    |--------------------------------------------------------------------------
    | Laporan umum (di luar prefix finance)
    |--------------------------------------------------------------------------
    */
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
});