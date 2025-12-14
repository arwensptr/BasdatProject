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
        Schema::create('fact_lifecycle_pesanan', function (Blueprint $table) {
            $table->id('lifecycle_id');
            
            // Foreign Keys
            $table->unsignedBigInteger('waktu_order_key');
            $table->unsignedBigInteger('layanan_key');
            $table->unsignedBigInteger('status_key');
            
            // Referensi ke Transaksi Asli
            $table->unsignedBigInteger('order_id'); 
            
            // Measures
            $table->integer('durasi_order')->default(0); // Dalam jam/hari
            $table->integer('jumlah_order')->default(1); // Biasanya 1, untuk di-SUM
            $table->string('track_number')->nullable();
            
            $table->timestamps();

            $table->index(['waktu_order_key', 'layanan_key', 'status_key'], 'idx_lifecycle_logistik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fact_lifecycle_pesanan');
    }
};
