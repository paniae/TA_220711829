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
        Schema::create('produk_umkm', function (Blueprint $table) {
            $table->id('id_produk');
            $table->foreignId('id_umkm');
            $table->string('nama_produk');
            $table->integer('harga');
            $table->string('status_produk')->nullable();
            $table->string('foto_produk')->nullable();
            $table->text('deskripsi_produk')->nullable();

            $table->foreign('id_umkm')->references('id_umkm')->on('umkm')->cascadeOnDelete();
            $table->unsignedBigInteger('id_produk_master')->nullable();
            $table->foreign('id_produk_master')->references('id_produk_master')->on('produk_master')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_umkm');
    }
};
