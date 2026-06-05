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
        Schema::create('komentar_forum', function (Blueprint $table) {
            $table->id('id_komen');
            $table->foreignId('id_laporan');
            $table->text('komentar');
            $table->dateTime('tgl_waktu_komen');
            $table->string('foto_komen')->nullable();
            $table->unsignedBigInteger('id_pengguna')->nullable();
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna')->onDelete('set null');

            $table->foreign('id_laporan')->references('id_laporan')->on('laporan_kehilangan')->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komentar_forum');
    }
};
