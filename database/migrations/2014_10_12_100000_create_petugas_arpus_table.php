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
        Schema::create('petugas_arpus', function (Blueprint $table) {
            $table->unsignedBigInteger('nik')->unique()->primary();
            $table->string('name');
            $table->date('tanggal_lahir');
            $table->bigInteger('kk');
            $table->string('no_hp');
            // $table->string('email')->unique();
            // $table->timestamp('email_verified_at')->nullable();
            // $table->string('password');
            $table->string('url')->nullable();
            $table->string('hashname')->nullable();
            $table->string('kecamatan');
            $table->string('desa');
            $table->timestamps();
            $table->foreign('nik')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petugas_arpus');
    }
};
