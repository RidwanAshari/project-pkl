<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {

            if (!Schema::hasColumn('vehicle_maintenances', 'file_surat_pengantar')) {
                $table->string('file_surat_pengantar')->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {

            if (Schema::hasColumn('vehicle_maintenances', 'file_surat_pengantar')) {
                $table->dropColumn('file_surat_pengantar');
            }

        });
    }
};
