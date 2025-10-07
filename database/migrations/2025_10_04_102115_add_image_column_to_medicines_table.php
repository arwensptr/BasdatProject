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
        // Kode ini akan dijalankan saat migrasi
        Schema::table('medicines', function (Blueprint $table) {
            // Menambahkan kolom 'image' bertipe string,
            // bisa kosong (nullable), dan diletakkan setelah kolom 'description'
            $table->string('image')->nullable()->after('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kode ini untuk membatalkan migrasi (jika diperlukan)
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};