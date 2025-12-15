<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Prescription;
use App\Models\PaymentProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. AMBIL FILTER DARI URL
        $bulan = $request->input('bulan');
        $quarter = $request->input('quarter');

        // --- BAGIAN A: STATISTIK OPERASIONAL (OLTP - Realtime) ---
        // Ini tetap dipertahankan karena penting untuk kerjaan harian admin.
        $oltpStats = [
            'rx_pending' => Prescription::where('status','prescription_under_review')
                ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))->count(),
            'pay_pending' => PaymentProof::where('status','under_review')
                ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))->count(),
            'orders_open' => Order::whereNotIn('status',['delivered','cancelled'])
                ->when($bulan, fn($q) => $q->whereMonth('created_at', $bulan))->count(),
            'orders_today' => Order::whereDate('created_at', now()->toDateString())->count(),
        ];

        // ...

        // --- BAGIAN B: SUMMARY DATA WAREHOUSE (OLAP) ---
        $dw = DB::connection('mysql_dw'); 

        // 1. Total Revenue (fact_penjualan)
        $qSales = $dw->table('fact_penjualan')->where('tahun', date('Y'));
        
        if ($bulan) $qSales->where('bulan', $bulan);
        if ($quarter) $qSales->where('quarter', $quarter);

        // Sesuai gambar 1: kolom 'total_penjualan'
        $totalRevenue = $qSales->sum('total_penjualan'); 

        // 2. Total Order (fact_cycle)
        // Kita pakai fact_cycle karena ini mencerminkan order
        $qLifecycle = $dw->table('fact_cycle')->where('tahun', date('Y'));

        if ($bulan) $qLifecycle->where('bulan', $bulan);
        if ($quarter) $qLifecycle->where('quarter', $quarter);

        $totalOrdersDW = $qLifecycle->count();

        // 3. Total Obat Terjual (fact_penjualan)
        // Kita pakai fact_penjualan karena di fact_obat tidak ada filter bulan
        $qObat = $dw->table('fact_penjualan')->where('tahun', date('Y'));

        if ($bulan) $qObat->where('bulan', $bulan);
        if ($quarter) $qObat->where('quarter', $quarter);

        // Sesuai gambar 1: kolom 'quantity'
        $totalQtySold = $qObat->sum('quantity'); 

// ... return view ...


        // Masukkan semua ke view
        return view('admin.dashboard', compact(
            'oltpStats', 
            'totalRevenue', 
            'totalOrdersDW', 
            'totalQtySold'
        ));
    }
}