<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('dari_pemegang')->nullable();
            $table->string('ke_pemegang');
            $table->date('tanggal_serah_terima');
            $table->string('nomor_ba')->unique(); // Nomor Berita Acara
            $table->string('file_ba')->nullable(); // File scan BA
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_histories');
    }
};