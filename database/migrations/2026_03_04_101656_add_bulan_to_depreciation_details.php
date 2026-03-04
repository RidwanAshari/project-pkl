<?php
// Jalankan: php artisan make:migration add_bulan_to_depreciation_details --table=asset_depreciation_details
// Lalu isi dengan ini:

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('asset_depreciation_details', function (Blueprint $table) {
            $table->tinyInteger('bulan')->nullable()->after('tahun'); // 1-12
        });
    }

    public function down(): void
    {
        Schema::table('asset_depreciation_details', function (Blueprint $table) {
            $table->dropColumn('bulan');
        });
    }
};