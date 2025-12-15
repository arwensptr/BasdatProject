<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    // --- HELPER: LOGIKA TETAP SAMA ---
    private function prepareTrendData($queryResult, $request) {
        $targetMonths = range(1, 12);
        if ($request->quarter == 'Q1') $targetMonths = [1, 2, 3];
        if ($request->quarter == 'Q2') $targetMonths = [4, 5, 6];
        if ($request->quarter == 'Q3') $targetMonths = [7, 8, 9];
        if ($request->quarter == 'Q4') $targetMonths = [10, 11, 12];
        if ($request->bulan) $targetMonths = [$request->bulan];

        $labels = [];
        $data1 = [];
        $data2 = [];

        foreach ($targetMonths as $m) {
            $found = $queryResult->firstWhere('bulan', $m);
            $labels[] = date('F', mktime(0, 0, 0, $m, 1));
            $data1[] = $found ? ($found->main_metric ?? 0) : 0;
            $data2[] = $found ? ($found->sec_metric ?? 0) : 0;
        }
        return ['labels' => $labels, 'data1' => $data1, 'data2' => $data2];
    }

    // Helper filter disesuaikan agar bisa terima nama kolom custom
    private function applyFilter($query, $request, $colBulan = 'bulan', $colQuarter = 'quarter', $colTahun = 'tahun') {
        if ($request->bulan) $query->where($colBulan, $request->bulan);
        if ($request->quarter) $query->where($colQuarter, $request->quarter);
        return $query;
    }

    // ==========================================
    // 1. FACT PENJUALAN (Denormalized)
    // ==========================================
    public function sales(Request $request)
    {
        $dw = DB::connection('mysql_dw'); 

        // A. Line Chart (Tren)
        // Tidak perlu JOIN, langsung group by 'bulan'
        $qChart = $dw->table('fact_penjualan')
            ->select('bulan', 
                     DB::raw('SUM(total_penjualan) as main_metric'), // Kolom: total_penjualan
                     DB::raw('COUNT(penjualan_id) as sec_metric'))   // Kolom: penjualan_id
            ->where('tahun', date('Y'));
        
        $this->applyFilter($qChart, $request);
        $chartData = $this->prepareTrendData($qChart->groupBy('bulan')->get(), $request);

        // B. Top 5 Pelanggan
        $qCust = $dw->table('fact_penjualan')
            ->select('nama_pelanggan as name', // Kolom: nama_pelanggan
                     DB::raw('COUNT(penjualan_id) as total_trx'),
                     DB::raw('SUM(total_penjualan) as total_spend'))
            ->where('tahun', date('Y'));
        
        $topCustomers = $this->applyFilter($qCust, $request)
            ->groupBy('nama_pelanggan')
            ->orderByDesc('total_spend')
            ->limit(5)
            ->get();

        // C. Top 5 Kategori
        $qCat = $dw->table('fact_penjualan')
            ->select('kategori', // Kolom: kategori
                     DB::raw('COUNT(penjualan_id) as total_trx'), 
                     DB::raw('SUM(quantity) as total_qty'),
                     DB::raw('SUM(total_penjualan) as total_revenue'))
            ->where('tahun', date('Y'));
        
        $topCategories = $this->applyFilter($qCat, $request)
            ->groupBy('kategori')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // D. Rekap Per Bulan
        $qRecap = $dw->table('fact_penjualan')
            ->select('bulan',
                     DB::raw('COUNT(penjualan_id) as total_trx'),
                     DB::raw('SUM(total_penjualan) as total_revenue'))
            ->where('tahun', date('Y'));
        
        if ($request->quarter) $qRecap->where('quarter', $request->quarter);
        
        // Kita perlu mapping angka bulan ke Nama Bulan di PHP karena di DB cuma angka
        $monthlyRecap = $qRecap->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->map(function($item) {
                $item->nama_bulan = date('F', mktime(0, 0, 0, $item->bulan, 1));
                return $item;
            });

        return view('admin.analytics.sales', compact('chartData', 'topCustomers', 'topCategories', 'monthlyRecap'));
    }

    // ==========================================
    // 2. FACT OBAT / INVENTORY
    // ==========================================
    public function inventory(Request $request)
    {
        $dw = DB::connection('mysql_dw');

        // A. Pie Chart (Aman)
        $qPie = $dw->table('fact_obat')
            ->select('nama_produk as nama_obat', DB::raw('SUM(quantity) as total_qty'))
            ->where('order_tahun', date('Y'));
        
        $this->applyFilter($qPie, $request, 'bulan', 'order_quarter'); 
        
        $topMedicinesChart = $qPie->groupBy('nama_obat') // Group by sesuai alias
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // B. Top 10 Kategori (Perbaikan Revenue)
        $qCat = $dw->table('fact_obat')
            ->select('kategori', 
                     DB::raw('COUNT(*) as total_trx'), 
                     DB::raw('0 as total_revenue'), 
                     DB::raw('SUM(quantity) as total_qty')) 
            ->where('order_tahun', date('Y'));

        $this->applyFilter($qCat, $request, 'bulan', 'order_quarter');

        $top10Categories = $qCat->groupBy('kategori')
            ->orderByDesc('total_qty') //
            ->limit(10)
            ->get();

        // C. Resep vs Bebas
        $qType = $dw->table('fact_obat')
            ->select('resep', 
                     DB::raw('SUM(quantity) as qty'),
                     DB::raw('0 as revenue')) 
            ->where('order_tahun', date('Y'));
        
        $this->applyFilter($qType, $request, 'bulan', 'order_quarter');
        $rawTypeData = $qType->groupBy('resep')->get();
        $resepVsBebas = collect(['Bebas', 'Resep'])->map(function($kategori) use ($rawTypeData) {
    
            $found = $rawTypeData->first(function($item) use ($kategori) {
                // Logika baru: Mencocokkan nilai di DB ('Obat Bebas', 'Resep Dokter')
                if ($kategori == 'Resep' && $item->resep == 'Resep Dokter') return true;
                if ($kategori == 'Bebas' && $item->resep == 'Obat Bebas') return true;
                
                // Tambahkan fallback untuk nilai-nilai lama (jika ada)
                if ($kategori == 'Resep' && ($item->resep == 'Resep' || $item->resep == 'Yes' || $item->resep == 1)) return true;
                if ($kategori == 'Bebas' && ($item->resep == 'Bebas' || $item->resep == 'No' || $item->resep == 0)) return true;
                
                return false;
            });
            
            return (object) [
                'resep' => $kategori,
                'qty' => $found ? $found->qty : 0,
                'revenue' => $found ? $found->revenue : 0
            ];
        });

        // D. Monthly Best Category
        $qMonthCat = $dw->table('fact_penjualan')
            ->select('bulan', 'kategori', 
                     DB::raw('SUM(quantity) as total_qty'))
            ->where('tahun', date('Y'));

        if($request->quarter) $qMonthCat->where('quarter', $request->quarter);

        $rawMonthData = $qMonthCat->groupBy('bulan', 'kategori')->get();

        $monthlyBestCategory = $rawMonthData->groupBy('bulan')->map(function ($rows) {
            $firstRow = $rows->first();
            if($firstRow) {
                $firstRow->nama_bulan = date('F', mktime(0, 0, 0, $firstRow->bulan, 1));
            }
            return $rows->sortByDesc('total_qty')->first(); 
        })->sortBy('bulan');

        return view('admin.analytics.inventory', compact('topMedicinesChart', 'top10Categories', 'resepVsBebas', 'monthlyBestCategory'));
    }

    // ==========================================
    // 3. FACT CYCLE / LIFECYCLE
    // ==========================================
    public function lifecycle(Request $request)
    {
        $dw = DB::connection('mysql_dw');

        // A. Status Chart (Aman)
        $qStatus = $dw->table('fact_cycle') 
            ->select('status', DB::raw('COUNT(*) as total')) 
            ->where('tahun', date('Y'));
        
        $statusChart = $this->applyFilter($qStatus, $request)->groupBy('status')->get();

        // B. Courier Chart (ERROR DISINI SEBELUMNYA)
        // Perbaikan: Tambahkan 'as nama_kurir'
        $qCourier = $dw->table('fact_cycle')
            ->select('courier_name as nama_kurir', DB::raw('COUNT(*) as total')) 
            ->where('tahun', date('Y'))
            ->where('status', 'delivered');

        $courierChart = $this->applyFilter($qCourier, $request)->groupBy('nama_kurir')->get();

        // C. Courier Table (ERROR DISINI SEBELUMNYA)
        // Perbaikan: Tambahkan 'as nama_kurir'
        $courierTable = $dw->table('fact_cycle')
            ->select('courier_name as nama_kurir', 
                     DB::raw('COUNT(*) as total_order'),
                     DB::raw('AVG(durasi_siklus_penuh_jam) as avg_duration'))
            ->where('tahun', date('Y'))
            ->where('status', 'delivered');
        
        $this->applyFilter($courierTable, $request);
        $courierTable = $courierTable->groupBy('nama_kurir')->get();

        return view('admin.analytics.lifecycle', compact('statusChart', 'courierChart', 'courierTable'));
    }
}