<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleMaintenance;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $pendingSuratCount = 0;

            if (Auth::check()) {
                $user = Auth::user();

                // sementara: kabag pakai email (nanti ganti ke role)
                $isKabag = ($user->email === 'fajar@gmail.com');

                if ($isKabag) {
                    // hitung surat yang belum ACC kabag
                    // catatan: pastikan model VehicleMaintenance ada dan kolom is_acc_kabag ada
                    $pendingSuratCount = VehicleMaintenance::where('is_acc_kabag', false)->count();
                }
            }

            $view->with('pendingSuratCount', $pendingSuratCount);
        });
    }
}
