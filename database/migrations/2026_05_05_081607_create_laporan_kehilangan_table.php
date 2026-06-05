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
        Schema::create('laporan_kehilangan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_pengguna');
            $table->dateTime('tanggal_hilang');
            $table->string('barang_hilang');
            $table->string('lokasi_hilang');
            $table->string('foto_barang')->nullable();
            $table->dateTime('tanggal_laporan');
            $table->text('deskripsi_laporan')->nullable();
            $table->string('status_kehilangan')->nullable();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_kehilangan');
    }
};
