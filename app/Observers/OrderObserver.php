<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Medicine; // Sesuaikan nama model produkmu
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderObserver
{
    /**
     * Dijalankan saat ada Order Baru (created)
     */
    public function created(Order $order)
    {
        // 1. SIAPKAN DIMENSI WAKTU
        // Ambil ID waktu dari tabel dim_waktu yang sudah di-seed
        $dateKey = Carbon::parse($order->created_at)->format('Y-m-d');
        $waktu = DB::table('dim_waktu')->where('full_date', $dateKey)->first();
        $waktuKey = $waktu ? $waktu->waktu_key : 1; // Default 1 jika tidak ketemu

        // 2. SIAPKAN DIMENSI PELANGGAN
        // Cek apakah user ini sudah masuk dim_pelanggan? Jika belum, masukkan.
        $pelangganKey = $this->syncDimPelanggan($order->user_id);

        // 3. PROSES ITEM BELANJA (Fact Penjualan & Fact Obat)
        // Kita loop order_items karena satu order bisa banyak obat
        $items = DB::table('order_items')->where('order_id', $order->id)->get();
        
        foreach ($items as $item) {
            // 3a. Sinkronisasi Dimensi Produk (Obat)
            $produkKey = $this->syncDimProduk($item->medicine_id); // Pake medicine_id sesuai screenshot

            // 3b. Isi Fact Penjualan
            DB::table('fact_penjualan')->insert([
                'waktu_key'     => $waktuKey,
                'produk_key'    => $produkKey,
                'pelanggan_key' => $pelangganKey,
                'id_order'      => $order->id, // Menggunakan ID Order asli
                'qty'           => $item->qty,
                'harga_satuan'  => $item->unit_price,
                'total'         => $item->subtotal,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // 3c. Isi Fact Obat (Sesuai rancanganmu)
            DB::table('fact_obat')->insert([
                'id_obat'         => $produkKey,
                'waktu_key'       => $waktuKey,
                'id_order'        => $order->id,
                'quantity'        => $item->qty,
                'total_penjualan' => $item->subtotal,
                'created_at'      => now(),
            ]);
        }

        // 4. SIAPKAN DIMENSI LAYANAN (Kurir)
        // Data kurir ada di tabel 'deliveries' (Image 61131a), kita perlu cek relasinya
        $delivery = DB::table('deliveries')->where('order_id', $order->id)->first();
        $layananKey = 1; // Default
        if ($delivery) {
            $layananKey = $this->getLayananKey($delivery->courier_name);
        }

        // 5. ISI FACT LIFECYCLE PESANAN (Logistik)
        // Ambil ID status awal (biasanya 'processing' atau 'awaiting_payment')
        $statusKey = $this->getStatusKey($order->status);

        DB::table('fact_lifecycle_pesanan')->insert([
            'order_id'        => $order->id,
            'waktu_order_key' => $waktuKey,
            'layanan_key'     => $layananKey,
            'status_key'      => $statusKey,
            'durasi_order'    => 0, // Masih 0 karena baru dibuat
            'jumlah_order'    => 1,
            'track_number'    => $delivery ? $delivery->tracking_number : null,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }

    /**
     * Dijalankan saat Order Berubah (updated) - Misal status ganti 'delivered'
     */
    public function updated(Order $order)
    {
        // Cek status baru
        $statusKey = $this->getStatusKey($order->status);

        // Hitung durasi jika status delivered (ID 4 di seeder biasanya delivered, sesuaikan stringnya)
        $durasi = 0;
        if ($order->status == 'delivered') {
            // Ambil data delivery untuk tau kapan delivered_at (Image 61131a)
            $delivery = DB::table('deliveries')->where('order_id', $order->id)->first();
            if ($delivery && $delivery->delivered_at) {
                $start = Carbon::parse($order->created_at);
                $end = Carbon::parse($delivery->delivered_at);
                $durasi = $end->diffInHours($start);
            }
        }

        // Update tabel Fact Lifecycle
        DB::table('fact_lifecycle_pesanan')
            ->where('order_id', $order->id)
            ->update([
                'status_key'   => $statusKey,
                'durasi_order' => $durasi,
                'updated_at'   => now(),
            ]);
    }

    // --- HELPER FUNCTIONS ---

    private function syncDimPelanggan($userId) {
        // Cek User Asli
        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) return 1;

        // Cek di Dimensi
        $existing = DB::table('dim_pelanggan')->where('user_id_asli', $userId)->first();
        if ($existing) return $existing->pelanggan_key;

        // Hitung Umur dari birth_date (Image 610f40)
        $umur = $user->birth_date ? Carbon::parse($user->birth_date)->age : 0;
        
        // Ambil Kota dari Address (Asumsi format: "Jalan..., Kota, Provinsi")
        // Kita ambil string setelah koma terakhir atau ambil string utuh dulu
        $kota = $user->address; 
        
        return DB::table('dim_pelanggan')->insertGetId([
            'user_id_asli'  => $userId,
            'nama_kota'     => $kota,
            'jenis_kelamin' => $user->gender, // 'L' atau 'P'
            'umur'          => $umur,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);
    }

    private function syncDimProduk($medicineId) {
        // Cek Produk Asli (Tabel medicines - Image 610fbe)
        $obat = DB::table('medicines')->where('id', $medicineId)->first(); // Nama tabel medicines?
        if (!$obat) return 1;

        // Cek di Dimensi
        $existing = DB::table('dim_produk')->where('id_obat_asli', $medicineId)->first();
        if ($existing) return $existing->produk_key;

        // Insert Baru
        return DB::table('dim_produk')->insertGetId([
            'id_obat_asli' => $medicineId,
            'nama_obat'    => $obat->name,
            'kategori'     => 'Obat', // Bisa ambil dari category_id lookup jika mau
            'subkategori'  => null,
            'resep'        => $obat->is_prescription_only ? 'Resep' : 'Bebas',
            'unit_price'   => $obat->price,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);
    }

    private function getLayananKey($courierName) {
        // Cari di dim_metode_layanan (Image 61131a kolom courier_name -> JNE, TIKI, dll)
        $layanan = DB::table('dim_metode_layanan')
                    ->where('nama_kurir', 'LIKE', "%$courierName%")
                    ->first();
        return $layanan ? $layanan->layanan_key : 1; 
    }

    private function getStatusKey($statusString) {
        // Mapping status string dari tabel orders (Image 611015) ke ID di dim_status_akhir
        $st = DB::table('dim_status_akhir')->where('status', $statusString)->first();
        return $st ? $st->status_key : 1;
    }
}