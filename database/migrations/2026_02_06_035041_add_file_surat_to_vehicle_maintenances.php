<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            $table->string('file_surat_pengantar')->nullable()->after('file_nota');
        });
    }
};
