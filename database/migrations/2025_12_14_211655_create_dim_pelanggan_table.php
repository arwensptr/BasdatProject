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
        Schema::create('dim_pelanggan', function (Blueprint $table) {
            $table->id('pelanggan_key');
            $table->unsignedBigInteger('user_id_asli'); // ID dari tabel users
            $table->string('nama_kota')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->integer('umur')->nullable(); // Bisa dihitung saat ETL
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_pelanggan');
    }
};
