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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->string('nomor_induk_kependudukan')->primary();
            $table->string('nama_lengkap');
            $table->string('nomor_kk');
            $table->string('jenis_kelamin');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('pendidikan');
            $table->string('jenis_pekerjaan');
            $table->string('alamat');
            $table->string('rt');
            $table->string('rw');
            $table->string('kecamatan');
            $table->string('desa_kelurahan');
            $table->string('kabupaten_kota');
            $table->string('provinsi');
            $table->string('status_perkawinan');
            $table->string('status_penduduk');
            $table->string('foto_penduduk')->nullable();
            $table->foreignId('id_pengguna')->nullable()->constrained('pengguna', 'id_pengguna')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
