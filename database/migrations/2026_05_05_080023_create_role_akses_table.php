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
        Schema::create('role_akses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_role');
            $table->foreignId('id_akses');

            $table->foreign('id_role')->references('id_role')->on('role')->cascadeOnDelete();
            $table->foreign('id_akses')->references('id_akses')->on('akses')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_akses');
    }
};
