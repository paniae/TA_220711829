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
        Schema::create('umkm', function (Blueprint $table) {
            $table->id('id_umkm');
            $table->foreignId('id_pengguna');
            $table->string('nama_umkm');
            $table->string('alamat_umkm');
            $table->string('bidang_umkm');
            $table->string('foto_umkm')->nullable();
            $table->string('status_umkm');
            $table->text('deskripsi_umkm')->nullable();
            $table->string('nomor_telepon_umkm');
            $table->boolean('is_nomor_telepon_ditampilkan')->default(true);
            $table->string('email_umkm')->nullable();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
