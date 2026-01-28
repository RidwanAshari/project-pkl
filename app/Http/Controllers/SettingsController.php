<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        // Dapatkan konfigurasi database
        $dbConnection = config('database.default', 'mysql');
        $dbDriver = config("database.connections.{$dbConnection}.driver", 'mysql');
        $dbName = config("database.connections.{$dbConnection}.database", 'unknown');
        
        // Kirim data info ke view
        $info = [
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'app_url' => config('app.url'),
            'app_timezone' => config('app.timezone'),
            'app_locale' => config('app.locale'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => ucfirst($dbConnection) . ($dbDriver ? " ({$dbDriver})" : ''), // ← TAMBAHKAN INI
            'database_name' => $dbName, // ← TAMBAHKAN INI
        ];
        
        return view('settings.index', compact('info'));
    }

    public function update(Request $request)
    {
        // Update system settings
        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'department' => 'nullable|string'
        ]);

        $user->update($request->only('name', 'email', 'phone', 'department'));

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8'
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->back()->with('success', 'Password berhasil diubah');
    }

    public function backup(Request $request)
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        session(['last_backup' => $timestamp]);
        
        return redirect()->back()->with('success', 'Backup berhasil dilakukan pada ' . $timestamp);
    }

    public function clearCache(Request $request)
    {
        try {
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            \Artisan::call('route:clear');
            
            return redirect()->back()->with('success', 'Cache berhasil dibersihkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    public function systemInfo()
    {
        // Dapatkan konfigurasi database
        $dbConnection = config('database.default', 'mysql');
        $dbDriver = config("database.connections.{$dbConnection}.driver", 'mysql');
        $dbName = config("database.connections.{$dbConnection}.database", 'unknown');
        
        $info = [
            'app_name' => config('app.name'),
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
            'app_url' => config('app.url'),
            'app_timezone' => config('app.timezone'),
            'app_locale' => config('app.locale'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'database' => ucfirst($dbConnection) . ($dbDriver ? " ({$dbDriver})" : ''), // ← TAMBAHKAN INI
            'database_name' => $dbName, // ← TAMBAHKAN INI
        ];
        
        return view('settings.system-info', compact('info'));
    }
}