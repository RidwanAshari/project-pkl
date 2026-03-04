<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Asset;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        $info = [
            'app_name'        => config('app.name'),
            'app_env'         => config('app.env'),
            'php_version'     => phpversion(),
            'laravel_version' => app()->version(),
            'database'        => config('database.default'),
        ];

        $stats = [
            'total_aset'     => Asset::count(),
            'total_user'     => User::count(),
            'total_kendaraan'=> Asset::where('kategori', 'Kendaraan')->count(),
            'total_peralatan'=> Asset::where('kategori', 'Peralatan')->count(),
            'total_gedung'   => Asset::where('kategori', 'Gedung')->count(),
            'total_tanah'    => Asset::where('kategori', 'Tanah')->count(),
            'total_transfer' => \App\Models\AssetHistory::count(),
            'total_foto'     => Asset::whereNotNull('foto')->count(),
            'total_qr'       => Asset::whereNotNull('qr_code')->count(),
        ];

        return view('settings.index', compact('info', 'stats'));
    }

    public function backupDatabase()
    {
        try {
            $filename    = 'backup_' . date('Y-m-d_His') . '.sqlite';
            $source      = database_path('database.sqlite');
            $destination = storage_path('app/backups/' . $filename);

            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }

            copy($source, $destination);

            return redirect()->back()->with('success', 'Backup berhasil dibuat: ' . $filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            return redirect()->back()->with('success', 'Cache berhasil dibersihkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    public function listBackups()
    {
        $backupPath = storage_path('app/backups');

        if (!file_exists($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $files   = array_diff(scandir($backupPath), ['.', '..']);
        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'name' => $file,
                'size' => filesize($backupPath . '/' . $file),
                'date' => date('d/m/Y H:i:s', filemtime($backupPath . '/' . $file)),
            ];
        }

        return view('settings.backups', compact('backups'));
    }

    public function downloadBackup($filename)
    {
        $file = storage_path('app/backups/' . $filename);
        if (file_exists($file)) {
            return response()->download($file);
        }
        return redirect()->back()->with('error', 'File backup tidak ditemukan!');
    }

    public function deleteBackup($filename)
    {
        $file = storage_path('app/backups/' . $filename);
        if (file_exists($file)) {
            unlink($file);
            return redirect()->back()->with('success', 'Backup berhasil dihapus!');
        }
        return redirect()->back()->with('error', 'File backup tidak ditemukan!');
    }
}