<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_depreciations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->string('metode')->default('garis_lurus'); // garis_lurus, saldo_menurun
            $table->integer('umur_ekonomis'); // tahun
            $table->decimal('nilai_sisa', 15, 2)->default(0);
            $table->decimal('tarif_penyusutan', 8, 4)->nullable(); // persentase per tahun
            $table->year('tahun_mulai');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::create('asset_depreciation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->year('tahun');
            $table->decimal('nilai_awal_tahun', 15, 2);
            $table->decimal('biaya_penyusutan', 15, 2);
            $table->decimal('akumulasi_penyusutan', 15, 2);
            $table->decimal('nilai_buku', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_depreciation_details');
        Schema::dropIfExists('asset_depreciations');
    }
};
