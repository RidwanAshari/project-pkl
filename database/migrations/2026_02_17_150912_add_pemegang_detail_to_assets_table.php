<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->string('jabatan_pemegang')->nullable();
            $table->text('alamat_pemegang')->nullable();
            $table->string('nipp_pemegang')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn(['jabatan_pemegang', 'alamat_pemegang', 'nipp_pemegang']);
        });
    }
};