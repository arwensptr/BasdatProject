<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('dim_waktu', function (Blueprint $table) {
            $table->id('waktu_key'); // Primary Key
            $table->date('full_date')->unique(); // 2025-12-14
            $table->integer('hari'); // 14
            $table->integer('bulan'); // 12
            $table->string('nama_bulan'); // Desember
            $table->integer('tahun'); // 2025
            $table->string('quarter'); // Q4
            $table->string('nama_hari'); // Minggu
            // Tidak perlu timestamps() di dimensi waktu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_waktu');
    }
};
