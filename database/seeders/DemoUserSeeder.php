<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin demo (opsional, login cepat)
        User::firstOrCreate(
            ['email' => 'admin@demo.test'], // Cek email ini dulu
            [
                'name' => 'Demo Admin',
                'password' => Hash::make('password'),
                // 'role' => 'admin',  <-- HATI-HATI: Pastikan kolom 'role' sudah ada di Migration kamu ya!
                'birth_date' => '1995-08-17', // Contoh tanggal
                'gender' => 'L',
                'address' => 'Surabaya',
                'role' => 'admin',
            ]
        );

        // 2. Customer Demo
        User::firstOrCreate(
            ['email' => 'customer@demo.test'],
            [
                'name' => 'Demo Customer',
                'password' => Hash::make('password'),
                // 'role' => 'customer', <-- HATI-HATI: Pastikan kolom 'role' sudah ada di Migration kamu ya!
                'birth_date' => '2002-05-20', // Otomatis jadi umur 20-an
                'gender' => 'P',
                'address' => 'Jl. MERR Surabaya',
                'role' => 'customer',
            ]
        );
    }
}
