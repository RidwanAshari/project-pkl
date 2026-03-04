<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asset_change_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('field_name');         // nama kolom yang berubah
            $table->string('field_label');        // label tampilan, e.g. "Nama Aset"
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->string('changed_by');         // nama user
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('asset_change_logs');
    }
};