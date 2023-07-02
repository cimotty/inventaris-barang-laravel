<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->string('nomorRegister');
            $table->string('merek');
            $table->string('tipe');
            $table->year('tahunBeli');
            $table->enum('kategori', ['Elektronik', 'Furniture', 'Kendaraan']);
            $table->string('warna')->nullable();
            $table->string('nomorRangka')->nullable();
            $table->string('nomorMesin')->nullable();
            $table->string('nomorPolisi')->nullable();
            $table->string('nomorBpkb')->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']);
            $table->bigInteger('harga');
            $table->string('keterangan');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
