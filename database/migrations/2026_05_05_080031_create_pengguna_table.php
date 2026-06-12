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
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('id_pengguna');
            $table->string('nama');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nik');
            $table->string('foto_profil')->nullable();
            $table->string('status_pengguna');
            $table->string('alamat_pengguna');
            $table->string('nomor_telepon_pengguna')->unique();
            $table->string('email_pengguna')->nullable();
            $table->string('jenis_kelamin_pengguna');
            $table->date('tanggal_lahir_pengguna')->nullable();
            $table->foreignId('id_role');

            $table->foreign('id_role')->references('id_role')->on('role')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
