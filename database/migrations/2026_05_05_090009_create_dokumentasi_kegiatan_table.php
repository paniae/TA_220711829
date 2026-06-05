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
        Schema::create('dokumentasi_kegiatan', function (Blueprint $table) {
            $table->id('id_dokumentasi');
            $table->foreignId('id_kegiatan');
            $table->date('tanggal_dokumentasi');
            $table->string('file_kegiatan');
            $table->text('deskripsi_dokumentasi')->nullable();

            $table->foreign('id_kegiatan')->references('id_kegiatan')->on('kegiatan_padukuhan')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumentasi_kegiatan');
    }
};
