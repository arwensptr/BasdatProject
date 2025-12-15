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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable(); 
            $table->string('address')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('role')->default('customer'); 
        });


        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        // 1. Matikan pengecekan Foreign Key (Ini kuncinya!)
        Schema::disableForeignKeyConstraints();

        // 2. Hapus tabel users
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');

        // 3. Nyalakan lagi pengamannya
        Schema::enableForeignKeyConstraints();
    }
};
