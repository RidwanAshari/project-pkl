<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\VehicleController; 

// =============================================
// ROOT ROUTE - REDIRECT TO LOGIN
// =============================================
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// =============================================
// AUTH ROUTES (from auth.php)
// =============================================
require __DIR__.'/auth.php';

// =============================================
// AUTHENTICATED ROUTES
// =============================================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // ======================
    // DASHBOARD
    // ======================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // ======================
    // PROFILE
    // ======================
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });
    
    // ======================
    // ASSETS MANAGEMENT
    // ======================
    Route::prefix('assets')->name('assets.')->group(function () {
        // CRUD Assets
        Route::get('/', [AssetController::class, 'index'])->name('index');
        Route::get('/create', [AssetController::class, 'create'])->name('create');
        Route::post('/', [AssetController::class, 'store'])->name('store');
        Route::get('/{asset}', [AssetController::class, 'show'])->name('show');
        Route::get('/{asset}/edit', [AssetController::class, 'edit'])->name('edit');
        Route::put('/{asset}', [AssetController::class, 'update'])->name('update');
        Route::delete('/{asset}', [AssetController::class, 'destroy'])->name('destroy');
        
        // Additional Asset Features
        Route::post('/{asset}/transfer', [AssetController::class, 'transfer'])->name('transfer');
        Route::get('/{asset}/sticker', [AssetController::class, 'printSticker'])->name('sticker');
        Route::get('/{asset}/generate-qr', [AssetController::class, 'generateQrCode'])->name('generate-qr');
        
        // Asset History & BA
        Route::get('/history/{history}/download-ba', [AssetController::class, 'downloadBA'])
            ->name('download-ba');
            
        // Bulk Actions
        Route::post('/bulk-actions', [AssetController::class, 'bulkActions'])->name('bulk.actions');
        
        // AJAX Search
        Route::get('/ajax/search', [AssetController::class, 'ajaxSearch'])->name('ajax.search');
    });
    
    // ======================
    // REPORTS
    // ======================
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/by-category', [ReportController::class, 'byCategory'])->name('by-category');
        Route::get('/by-condition', [ReportController::class, 'byCondition'])->name('by-condition');
        Route::get('/by-holder', [ReportController::class, 'byHolder'])->name('by-holder');
        Route::get('/pdf', [ReportController::class, 'pdf'])->name('pdf');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });
    
    // ======================
    // SETTINGS
    // ======================
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        Route::put('/', [SettingsController::class, 'update'])->name('update');
        Route::put('/profile', [SettingsController::class, 'updateProfile'])->name('profile.update');
        Route::put('/password', [SettingsController::class, 'updatePassword'])->name('password.update');
        
        // Backup routes
        Route::post('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::post('/backups', [SettingsController::class, 'backup'])->name('backups');
        
        // Additional utility routes
        Route::post('/clear-cache', [SettingsController::class, 'clearCache'])->name('clear-cache');
        Route::get('/system-info', [SettingsController::class, 'systemInfo'])->name('system-info');
    });
    
    // ======================
    // VEHICLE ROUTES (khusus kendaraan)
    // ======================
    Route::get('vehicles/{asset}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('vehicles/{asset}/edit-identity', [VehicleController::class, 'editIdentity'])->name('vehicles.edit-identity');
    Route::put('vehicles/{asset}/update-identity', [VehicleController::class, 'updateIdentity'])->name('vehicles.update-identity');
    Route::get('vehicles/{asset}/create-maintenance', [VehicleController::class, 'createMaintenance'])->name('vehicles.create-maintenance');
    Route::post('vehicles/{asset}/store-maintenance', [VehicleController::class, 'storeMaintenance'])->name('vehicles.store-maintenance');
    Route::delete('vehicles/{asset}/maintenance/{maintenance}', [VehicleController::class, 'deleteMaintenance'])->name('vehicles.delete-maintenance');
    Route::get('vehicles/{asset}/report-cost', [VehicleController::class, 'reportCost'])->name('vehicles.report-cost');
    Route::get('vehicles/{asset}/maintenance/{maintenance}/download-surat', [VehicleController::class, 'downloadSuratPengantar'])->name('vehicles.download-surat');
});

// =============================================
// PUBLIC ROUTES
// =============================================
Route::get('/asset/qr/{code}', [AssetController::class, 'publicQrView'])
    ->name('asset.public.qr');

// QR Code Redirect - untuk scan QR Code
Route::get('qr/{kode_aset}', [AssetController::class, 'qrRedirect'])->name('qr.redirect');

// =============================================
// FALLBACK ROUTE (dari remote)
// =============================================
Route::fallback(function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});