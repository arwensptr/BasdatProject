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
        Schema::create('dim_produk', function (Blueprint $table) {
            $table->id('produk_key'); // Primary Key
            $table->unsignedBigInteger('id_obat_asli'); // ID dari tabel master obat (untuk referensi)
            $table->string('nama_obat');
            $table->string('kategori');
            $table->string('subkategori')->nullable();
            $table->string('resep')->nullable(); // Obat Resep / Bebas
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dim_produk');
    }
};
