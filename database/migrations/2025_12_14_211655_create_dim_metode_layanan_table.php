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
        Schema::create('dim_metode_layanan', function (Blueprint $table) {
            $table->id('layanan_key');
            $table->string('jenis_order'); // Reguler/Instant
            $table->string('nama_kurir'); // JNE, GoSend
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_metode_layanan');
    }
};
