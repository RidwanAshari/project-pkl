<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    // Kolom file_surat_pengantar sudah ada di create_vehicle_maintenances_table
    // Migration ini dikosongkan untuk menghindari duplicate column error
    public function up(): void {}
    public function down(): void {}
};