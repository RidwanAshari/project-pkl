<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->softDeletes();
            $table->string('alasan_hapus')->nullable();
            $table->string('dihapus_oleh')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['alasan_hapus', 'dihapus_oleh']);
        });
    }
};