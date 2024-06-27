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
        Schema::create('arsip_histori_prestasi', function (Blueprint $table) {
            $table->id('id_arpres');
            $table->unsignedBigInteger('user_id');
            $table->string('nama');
            $table->string('wilayah');
            $table->string('kategori');
            $table->string('deskripsi');
            $table->string('status');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_histori_prestasi');
    }
};
