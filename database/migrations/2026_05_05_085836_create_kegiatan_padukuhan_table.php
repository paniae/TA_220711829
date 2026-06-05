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
        Schema::create('kegiatan_padukuhan', function (Blueprint $table) {
            $table->id('id_kegiatan');
            $table->foreignId('id_pengguna');
            $table->string('nama_kegiatan');
            $table->dateTime('tgl_waktu_pelaksanaan');
            $table->dateTime('waktu_selesai')->nullable();
            $table->string('jenis_kegiatan')->nullable();
            $table->string('status_kegiatan')->nullable();
            $table->string('kategori')->nullable();
            $table->integer('dana_dikeluarkan')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('deskripsi_kegiatan')->nullable();
            $table->string('poster_kegiatan')->nullable();

            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatan_padukuhan');
    }
};
