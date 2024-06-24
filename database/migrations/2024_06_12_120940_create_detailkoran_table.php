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
        Schema::create('detailkoran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('koran_id');
            $table->string('image');
            $table->string('path');
            $table->timestamps();
            $table->foreign('koran_id')->references('id')->on('koran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detailkoran');
    }
};
