<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNilaiPerolehanToAssetsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Menambahkan kolom nilai_perolehan dengan tipe decimal
            $table->decimal('nilai_perolehan', 15, 2)->after('tahun_perolehan'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            // Menghapus kolom nilai_perolehan jika rollback dilakukan
            $table->dropColumn('nilai_perolehan');
        });
    }
}
