<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah role ke users
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('staff')->after('email'); // admin, staff, kabag, finance
        });

        // Tambah status surat ke vehicle_maintenances
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            $table->string('status_surat')->nullable()->after('file_surat'); // null, menunggu_acc, disetujui, ditolak
            $table->string('file_surat_ttd')->nullable()->after('status_surat'); // file surat yg udah di-ttd
            $table->decimal('biaya_aktual', 15, 2)->nullable()->after('file_surat_ttd');
            $table->string('file_nota_bengkel')->nullable()->after('biaya_aktual');
            $table->boolean('terkirim_ke_finance')->default(false)->after('file_nota_bengkel');
            $table->timestamp('approved_at')->nullable()->after('terkirim_ke_finance');
            $table->string('approved_by')->nullable()->after('approved_at');
        });

        // Tabel detail aset non-kendaraan
        Schema::create('asset_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            // Bangunan
            $table->string('luas_bangunan')->nullable();
            $table->string('jumlah_lantai')->nullable();
            $table->string('konstruksi')->nullable();
            $table->string('nomor_imb')->nullable();
            $table->date('tanggal_imb')->nullable();
            // Tanah
            $table->string('luas_tanah')->nullable();
            $table->string('nomor_sertifikat')->nullable();
            $table->date('tanggal_sertifikat')->nullable();
            $table->string('jenis_sertifikat')->nullable(); // SHM, HGB, dll
            $table->date('berlaku_sampai')->nullable();
            // Peralatan / Inventaris
            $table->string('nomor_seri')->nullable();
            $table->string('spesifikasi')->nullable();
            $table->string('garansi_sampai')->nullable();
            $table->string('lokasi_detail')->nullable();
            // Umum
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Tabel pemeliharaan non-kendaraan (generik)
        Schema::create('asset_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->string('jenis_pemeliharaan'); // Perbaikan, Pengecekan, Renovasi, dll
            $table->text('keterangan')->nullable();
            $table->decimal('biaya', 15, 2)->default(0);
            $table->string('vendor')->nullable();
            $table->string('file_nota')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_maintenances');
        Schema::dropIfExists('asset_details');
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            $table->dropColumn(['status_surat', 'file_surat_ttd', 'biaya_aktual', 'file_nota_bengkel', 'terkirim_ke_finance', 'approved_at', 'approved_by']);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
