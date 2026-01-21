<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('pemegang_saat_ini')->nullable()->after('lokasi');
            $table->string('qr_code')->nullable()->after('foto');
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['pemegang_saat_ini', 'qr_code']);
        });
    }
};