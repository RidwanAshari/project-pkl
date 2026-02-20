<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('asset_histories', function (Blueprint $table) {
            // Kolom untuk data penandatangan berita acara
            $table->string('jabatan_dari')->nullable();
            $table->string('jabatan_ke')->nullable();
            $table->string('nipp_dari')->nullable();
            $table->string('nipp_ke')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('asset_histories', function (Blueprint $table) {
            $table->dropColumn(['jabatan_dari', 'jabatan_ke', 'nipp_dari', 'nipp_ke']);
        });
    }
};