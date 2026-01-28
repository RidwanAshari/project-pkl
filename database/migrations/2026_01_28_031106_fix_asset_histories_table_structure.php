<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('asset_histories', function (Blueprint $table) {
            // Tambahkan semua kolom yang missing
            if (!Schema::hasColumn('asset_histories', 'jenis_perubahan')) {
                $table->string('jenis_perubahan', 50)->nullable()->after('nomor_ba');
            }
            
            if (!Schema::hasColumn('asset_histories', 'lokasi_lama')) {
                $table->string('lokasi_lama', 200)->nullable()->after('ke_pemegang');
            }
            
            if (!Schema::hasColumn('asset_histories', 'lokasi_baru')) {
                $table->string('lokasi_baru', 200)->nullable()->after('lokasi_lama');
            }
            
            if (!Schema::hasColumn('asset_histories', 'kondisi_lama')) {
                $table->string('kondisi_lama', 50)->nullable()->after('lokasi_baru');
            }
            
            if (!Schema::hasColumn('asset_histories', 'kondisi_baru')) {
                $table->string('kondisi_baru', 50)->nullable()->after('kondisi_lama');
            }
        });
    }

    public function down()
    {
        // Optional: bisa dikosongkan
    }
};