<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Prescription;
use App\Models\PaymentProof;
use Illuminate\Support\Facades\DB; // <--- Wajib ditambahkan

class HomeController extends Controller
{
    public function index()
    {
        // 1. Statistik Kartu (Existing Code)
        $stats = [
            'rx_pending'      => Prescription::where('status','prescription_under_review')->count(),
            'pay_pending'     => PaymentProof::where('status','under_review')->count(),
            'orders_open'     => Order::whereNotIn('status',['delivered','cancelled'])->count(),
            'orders_today'    => Order::whereDate('created_at', now()->toDateString())->count(),
        ];

        // 2. Order Terbaru (Existing Code)
        $recentOrders = Order::with('user')->latest()->limit(8)->get();

        // === [BARU] 3. QUERY DATA WAREHOUSE (OLAP) ===
        
        // A. Grafik Tren Penjualan Bulanan (Tahun Ini)
        $salesTrend = DB::table('fact_penjualan')
            ->join('dim_waktu', 'fact_penjualan.waktu_key', '=', 'dim_waktu.waktu_key')
            ->select(
                'dim_waktu.nama_bulan',
                'dim_waktu.bulan', // Diambil untuk sorting agar urut Jan-Des
                DB::raw('SUM(fact_penjualan.total) as total_revenue')
            )
            ->where('dim_waktu.tahun', date('Y')) // Filter Tahun Berjalan
            ->groupBy('dim_waktu.nama_bulan', 'dim_waktu.bulan')
            ->orderBy('dim_waktu.bulan', 'asc')
            ->get();

        // B. Grafik Top 5 Produk Terlaris
        $topProducts = DB::table('fact_obat')
            ->join('dim_produk', 'fact_obat.id_obat', '=', 'dim_produk.produk_key')
            ->select(
                'dim_produk.nama_obat',
                DB::raw('SUM(fact_obat.quantity) as total_sold')
            )
            ->groupBy('dim_produk.nama_obat')
            ->orderByDesc('total_sold') // Urutkan dari yang paling laku
            ->limit(5)
            ->get();
        
            // C. Grafik Performa Kurir (Rata-rata Durasi Pengiriman)
        // C. Grafik Status Pesanan (Lifecycle) - BARU
        $orderStatus = DB::table('fact_lifecycle_pesanan')
            ->join('dim_status_akhir', 'fact_lifecycle_pesanan.status_key', '=', 'dim_status_akhir.status_key')
            ->select('dim_status_akhir.status', DB::raw('COUNT(fact_lifecycle_pesanan.lifecycle_id) as total'))
            ->groupBy('dim_status_akhir.status')
            ->get();

        // Jangan lupa tambahkan $orderStatus ke compact()
        return view('admin.dashboard', compact('stats', 'recentOrders', 'salesTrend', 'topProducts', 'orderStatus'));
    }
}