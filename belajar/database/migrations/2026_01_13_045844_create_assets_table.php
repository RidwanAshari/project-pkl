<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode Aset Unik
            $table->string('name'); // Nama Aset
            $table->string('category'); // Kategori
            $table->date('purchase_date'); // Tanggal Beli
            $table->decimal('price', 15, 2); // Harga (Support Desimal)
            $table->string('status')->default('Baik'); // Status: Baik, Perbaikan, Rusak
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('assets');
    }
};