<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('dpb_documents', function (Blueprint $table) {
            // Uraian terstruktur: JSON array of {nama, vol, satuan, harga, jenis: 'barang'|'jasa'}
            $table->json('uraian_items')->nullable()->after('uraian');
            $table->decimal('total_pph', 15, 2)->default(0)->after('total_biaya');
            $table->string('nama_bengkel')->nullable()->after('total_pph');
            $table->string('untuk_keterangan')->nullable()->after('nama_bengkel'); // "Untuk: Sub Unit Secang"
            // Status untuk alur approval Eko → Kabag
            $table->string('status_eko')->default('menunggu')->after('status'); // menunggu|disetujui
            $table->string('approved_by_eko')->nullable()->after('status_eko');
            $table->timestamp('approved_at_eko')->nullable()->after('approved_by_eko');
        });
    }

    public function down(): void {
        Schema::table('dpb_documents', function (Blueprint $table) {
            $table->dropColumn(['uraian_items','total_pph','nama_bengkel','untuk_keterangan','status_eko','approved_by_eko','approved_at_eko']);
        });
    }
};