<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardDwController extends Controller
{
    public function index()
    {
        // 1. GRAFIK TREN PENJUALAN BULANAN (Tahun Ini)
        $salesTrend = DB::table('fact_penjualan')
            ->join('dim_waktu', 'fact_penjualan.waktu_key', '=', 'dim_waktu.waktu_key')
            ->select(
                'dim_waktu.nama_bulan',
                'dim_waktu.bulan', // Untuk sorting
                DB::raw('SUM(fact_penjualan.total) as total_revenue')
            )
            ->where('dim_waktu.tahun', date('Y')) // Filter tahun berjalan
            ->groupBy('dim_waktu.nama_bulan', 'dim_waktu.bulan')
            ->orderBy('dim_waktu.bulan')
            ->get();

        // 2. TOP 5 OBAT TERLARIS
        $topProducts = DB::table('fact_obat')
            ->join('dim_produk', 'fact_obat.id_obat', '=', 'dim_produk.produk_key')
            ->select(
                'dim_produk.nama_obat',
                DB::raw('SUM(fact_obat.quantity) as total_sold')
            )
            ->groupBy('dim_produk.nama_obat')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // 3. PERFORMA KURIR (Rata-rata Durasi Pengiriman)
        $courierPerformance = DB::table('fact_lifecycle_pesanan')
            ->join('dim_metode_layanan', 'fact_lifecycle_pesanan.layanan_key', '=', 'dim_metode_layanan.layanan_key')
            ->select(
                'dim_metode_layanan.nama_kurir',
                DB::raw('AVG(fact_lifecycle_pesanan.durasi_order) as avg_hours'),
                DB::raw('COUNT(fact_lifecycle_pesanan.lifecycle_id) as total_orders')
            )
            ->where('fact_lifecycle_pesanan.status_key', 4) // Asumsi ID 4 = Delivered (Cek seedermu!)
            ->groupBy('dim_metode_layanan.nama_kurir')
            ->get();

        // Kirim data ke View
        return view('dashboard_dw', compact('salesTrend', 'topProducts', 'courierPerformance'));
    }
}