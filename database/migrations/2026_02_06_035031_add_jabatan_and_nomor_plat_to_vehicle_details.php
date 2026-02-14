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
        Schema::table('vehicle_details', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('nama_pemilik');
            $table->string('nomor_plat')->nullable()->after('alamat');
        });
    }
};