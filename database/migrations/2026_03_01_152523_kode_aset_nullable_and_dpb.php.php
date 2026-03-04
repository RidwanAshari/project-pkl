<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kode_aset menjadi nullable (bisa auto-generate)
        Schema::table('assets', function (Blueprint $table) {
            $table->string('kode_aset')->nullable()->change();
        });

        // Tabel DPB (Daftar Pengadaan Barang) untuk finance
        Schema::create('dpb_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')->constrained('vehicle_maintenances')->onDelete('cascade');
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->string('nomor_dpb')->unique();
            $table->date('tanggal_dpb');
            $table->decimal('jumlah', 15, 2);
            $table->string('status')->default('draft'); // draft, selesai
            $table->string('file_dpb')->nullable();
            $table->text('keterangan')->nullable();
            $table->foreignId('dibuat_oleh')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dpb_documents');
        Schema::table('assets', function (Blueprint $table) {
            $table->string('kode_aset')->nullable(false)->change();
        });
    }
};
