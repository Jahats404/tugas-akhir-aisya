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
        Schema::create('detail_arpres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('arpres_id');
            $table->string('image');
            $table->string('path');
            $table->timestamps();
            $table->foreign('arpres_id')->references('id_arpres')->on('arsip_histori_prestasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_arpres');
    }
};
