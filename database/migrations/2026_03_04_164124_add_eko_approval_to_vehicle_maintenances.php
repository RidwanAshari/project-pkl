<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            // Cek kolom yang belum ada sebelum tambah
            if (!Schema::hasColumn('vehicle_maintenances', 'file_surat_ttd_eko')) {
                $table->string('file_surat_ttd_eko')->nullable()->after('approved_by_eko');
            }
            if (!Schema::hasColumn('vehicle_maintenances', 'approved_at_eko')) {
                $table->timestamp('approved_at_eko')->nullable();
            }
        });
    }

    public function down(): void {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            $table->dropColumn(['file_surat_ttd_eko', 'approved_at_eko']);
        });
    }
};