<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            
            // Identitas Pemilik/Pengguna
            $table->string('nama_pemilik')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat')->nullable();
            
            // Spesifikasi Kendaraan
            $table->string('nomor_plat')->nullable();
            $table->string('model')->nullable();
            $table->integer('tahun_pembuatan')->nullable();
            $table->string('isi_silinder')->nullable();
            $table->string('nomor_rangka')->nullable();
            $table->string('nomor_mesin')->nullable();
            $table->string('warna')->nullable();
            $table->string('bahan_bakar')->nullable(); // Bensin, Solar, Listrik
            
            // STNK/BPKB
            $table->string('warna_tnkb')->nullable();
            $table->integer('tahun_registrasi')->nullable();
            $table->string('nomor_bpkb')->nullable();
            $table->date('tanggal_berlaku')->nullable();
            $table->string('bulan_berlaku')->nullable();
            $table->string('tahun_berlaku')->nullable();
            
            // Spesifikasi Teknis
            $table->decimal('berat', 8, 2)->nullable(); // dalam KG
            $table->integer('sumbu')->nullable();
            $table->integer('penumpang')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_details');
    }
};