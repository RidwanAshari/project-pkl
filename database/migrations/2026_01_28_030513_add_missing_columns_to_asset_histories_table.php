<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('asset_histories', function (Blueprint $table) {
            // Tambahkan semua kolom yang error
            $table->string('lokasi_lama', 200)->nullable()->after('ke_pemegang');
            $table->string('lokasi_baru', 200)->nullable()->after('lokasi_lama');
            $table->string('kondisi_lama', 50)->nullable()->after('lokasi_baru');
            $table->string('kondisi_baru', 50)->nullable()->after('kondisi_lama');
            $table->string('departemen_lama', 100)->nullable()->after('kondisi_baru');
            $table->string('departemen_baru', 100)->nullable()->after('departemen_lama');
        });
    }

    public function down()
    {
        Schema::table('asset_histories', function (Blueprint $table) {
            $table->dropColumn([
                'lokasi_lama',
                'lokasi_baru',
                'kondisi_lama',
                'kondisi_baru',
                'departemen_lama',
                'departemen_baru'
            ]);
        });
    }
};