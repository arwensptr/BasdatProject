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
        Schema::create('fact_obat', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary Key Fact
            
            // Foreign Keys
            $table->unsignedBigInteger('id_obat'); // Mengacu ke dim_produk
            $table->unsignedBigInteger('waktu_key');
            
            // Measures
            $table->string('id_order'); // Nomor Order
            $table->integer('quantity');
            $table->decimal('total_penjualan', 15, 2);
            
            $table->timestamps();
            
            $table->index(['id_obat', 'waktu_key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fact_obat');
    }
};
