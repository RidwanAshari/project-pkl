<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            // path nota (kalau belum ada)
            if (!Schema::hasColumn('vehicle_maintenances', 'nota_path')) {
                $table->string('nota_path')->nullable()->after('status_surat');
            }

            // waktu upload nota (optional, tapi berguna buat inbox finance)
            if (!Schema::hasColumn('vehicle_maintenances', 'nota_uploaded_at')) {
                $table->timestamp('nota_uploaded_at')->nullable()->after('nota_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            if (Schema::hasColumn('vehicle_maintenances', 'nota_uploaded_at')) {
                $table->dropColumn('nota_uploaded_at');
            }
            if (Schema::hasColumn('vehicle_maintenances', 'nota_path')) {
                $table->dropColumn('nota_path');
            }
        });
    }
};