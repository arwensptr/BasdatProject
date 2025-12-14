<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Support\Facades\DB;

class InitDw extends Command
{
    /**
     * Nama command yang akan diketik di terminal
     */
    protected $signature = 'dw:init';

    /**
     * Deskripsi command
     */
    protected $description = 'Pindahkan data lama ke Data Warehouse';

    /**
     * Eksekusi command
     */
    public function handle()
    {
        $this->info('Mulai memindahkan data lama ke DW...');

        // Ambil semua order lama
        $orders = Order::all();
        
        if ($orders->isEmpty()) {
            $this->error('Tidak ada data order ditemukan di database lama.');
            return;
        }

        $bar = $this->output->createProgressBar(count($orders));
        $bar->start();

        // Panggil Logic Observer secara manual untuk setiap order
        $observer = new OrderObserver();

        foreach ($orders as $order) {
            try {
                // Gunakan transaction biar aman
                DB::transaction(function () use ($observer, $order) {
                    // 1. Jalankan logika "Created" (Insert data baru ke Fact)
                    $observer->created($order);

                    // 2. Jalankan logika "Updated" (Update status/durasi jika delivered)
                    $observer->updated($order);
                });
            } catch (\Exception $e) {
                // Skip error jika data duplikat atau ada masalah data kotor, log saja
                // $this->error('Gagal memproses Order ID: ' . $order->id . ' - ' . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Selesai! Data Warehouse sudah terisi.');
    }
}