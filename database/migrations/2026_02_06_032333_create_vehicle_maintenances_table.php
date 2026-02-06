<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            
            $table->date('tanggal');
            $table->enum('jenis_servis', ['Pengisian BBM', 'Service Rutin', 'Perbaikan', 'Penggantian', 'Bayar Pajak']);
            
            // Untuk Pengisian BBM
            $table->string('jenis_bbm')->nullable(); // Pertalite, Pertamax, Solar, dll
            $table->decimal('jumlah_liter', 8, 2)->nullable();
            $table->decimal('harga_per_liter', 10, 2)->nullable();
            $table->integer('odometer')->nullable(); // KM saat isi BBM
            
            // Untuk Service/Perbaikan/Penggantian
            $table->text('keterangan')->nullable();
            $table->string('bengkel')->nullable();
            
            // Biaya
            $table->decimal('biaya', 15, 2);
            
            // Bukti/Nota
            $table->string('file_nota')->nullable();
            $table->string('file_surat_pengantar')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenances');
    }
};