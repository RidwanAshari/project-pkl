<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Dashboard Route
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Asset Routes
Route::resource('assets', AssetController::class);
Route::post('assets/{asset}/transfer', [AssetController::class, 'transfer'])->name('assets.transfer');
Route::get('assets/{asset}/sticker', [AssetController::class, 'printSticker'])->name('assets.sticker');
Route::get('history/{history}/download-ba', [AssetController::class, 'downloadBA'])->name('history.download-ba');

// Report Routes
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/by-category', [ReportController::class, 'byCategory'])->name('reports.by-category');
Route::get('reports/by-condition', [ReportController::class, 'byCondition'])->name('reports.by-condition');
Route::get('reports/by-holder', [ReportController::class, 'byHolder'])->name('reports.by-holder');
Route::get('reports/export-pdf', [ReportController::class, 'exportPDF'])->name('reports.export-pdf');

// Settings Routes
Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('settings/backup', [SettingsController::class, 'backupDatabase'])->name('settings.backup');
Route::post('settings/clear-cache', [SettingsController::class, 'clearCache'])->name('settings.clear-cache');
Route::get('settings/backups', [SettingsController::class, 'listBackups'])->name('settings.backups');
Route::get('settings/backups/{filename}/download', [SettingsController::class, 'downloadBackup'])->name('settings.download-backup');
Route::delete('settings/backups/{filename}', [SettingsController::class, 'deleteBackup'])->name('settings.delete-backup');

// Profile Routes
Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');