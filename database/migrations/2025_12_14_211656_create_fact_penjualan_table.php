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
        Schema::create('fact_penjualan', function (Blueprint $table) {
            $table->id('penjualan_id');
            
            // Foreign Keys
            $table->unsignedBigInteger('waktu_key');
            $table->unsignedBigInteger('produk_key');
            $table->unsignedBigInteger('pelanggan_key');
            
            // Measures (Angka)
            $table->string('id_order'); // Degenerate Dimension (No Resi/Order ID string)
            $table->integer('qty');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('total', 15, 2);
            
            $table->timestamps(); // Untuk memantau kapan data ini masuk ke DW

            // Indexing (Wajib untuk performa Query Cepat)
            $table->index(['waktu_key', 'produk_key', 'pelanggan_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fact_penjualan');
    }
};
