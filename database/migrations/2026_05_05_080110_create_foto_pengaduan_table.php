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
        Schema::create('foto_pengaduan', function (Blueprint $table) {
            $table->id('id_foto_pengaduan');
            $table->foreignId('id_pengaduan');
            $table->string('foto_pengaduan');

            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduan')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_pengaduan');
    }
};
