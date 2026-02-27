<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            $table->text('nota')->nullable(); 
            $table->enum('dpb_status', ['pending', 'approved', 'printed'])->default('pending'); 
        });
    }

    public function down()
    {
        Schema::table('vehicle_maintenances', function (Blueprint $table) {
            $table->dropColumn('nota');
            $table->dropColumn('dpb_status');
        });
    }
};