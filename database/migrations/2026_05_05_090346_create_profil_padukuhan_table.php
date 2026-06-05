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
        Schema::create('profil_padukuhan', function (Blueprint $table) {
            $table->id('id_profil');
            $table->string('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('alamat_balai')->nullable();
            $table->string('nama_padukuhan')->nullable();
            $table->string('nama_kalurahan')->nullable();
            $table->string('nama_kecamatan')->nullable();
            $table->string('nama_kabupaten')->nullable();
            $table->text('sejarah')->nullable();
            $table->string('foto_balai')->nullable();
            $table->string('foto_kebersamaan')->nullable();
            $table->string('link_maps_balai')->nullable();
            $table->string('logo_padukuhan')->nullable();
            $table->string('jam_operasional')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_padukuhan');
    }
};
