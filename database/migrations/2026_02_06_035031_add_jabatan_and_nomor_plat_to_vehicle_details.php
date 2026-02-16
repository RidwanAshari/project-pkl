<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    // Kolom jabatan & nomor_plat sudah ada di create_vehicle_details_table
    // Migration ini dikosongkan untuk menghindari duplicate column error
    public function up(): void {}
    public function down(): void {}
};