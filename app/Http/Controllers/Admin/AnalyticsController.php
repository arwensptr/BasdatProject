<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
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
        $qChart = $dw->table('fact_penjualan')
            ->select('bulan', 
                     DB::raw('SUM(total_penjualan) as main_metric'),
                     DB::raw('COUNT(penjualan_id) as sec_metric'))
            ->where('tahun', date('Y'));
        
        $this->applyFilter($qChart, $request);
        $chartData = $this->prepareTrendData($qChart->groupBy('bulan')->get(), $request);

        // B. Top 5 Pelanggan
        $qCust = $dw->table('fact_penjualan')
            ->select('nama_pelanggan as name',
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

        // Tentukan Nama Kolom yang Tepat sesuai DW (Gambar 11c7a0):
        $col_nama = 'nama_obat';
        $col_qty = 'total_quantity'; // Kolom Kuantitas
        $col_kat = 'kategori';
        $col_resep = 'resep_sumber'; // Kolom Resep
        
        // Kolom waktu (TIDAK ADA prefix 'order_')
        $col_tahun = 'tahun';
        $col_bulan = 'bulan';
        $col_quarter = 'quarter';

        // A. Pie Chart (Obat Terlaris)
        $qPie = $dw->table('fact_obat')
            ->select($col_nama . ' as nama_obat', DB::raw("SUM($col_qty) as total_qty")) 
            ->where($col_tahun, date('Y')); // FILTER TAHUN BENAR
        
        // Filter manual
        if ($request->quarter) $qPie->where($col_quarter, $request->quarter);
        if ($request->bulan) $qPie->where($col_bulan, $request->bulan); 
        
        $topMedicinesChart = $qPie->groupBy($col_nama)
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        // B. Top 10 Kategori
        $qCat = $dw->table('fact_obat')
            ->select($col_kat . ' as kategori', 
                    DB::raw('COUNT(*) as total_trx'), 
                    DB::raw('0 as total_revenue'), 
                    DB::raw("SUM($col_qty) as total_qty")) 
            ->where($col_tahun, date('Y'));

        // Filter manual
        if ($request->quarter) $qCat->where($col_quarter, $request->quarter);
        if ($request->bulan) $qCat->where($col_bulan, $request->bulan);

        $top10Categories = $qCat->groupBy($col_kat)
            ->orderByDesc('total_qty') // Order by total_qty (qty/TRX) agar terisi
            ->limit(10)
            ->get()
            // FIX: Karena revenue di Fact Obat selalu 0, kita beri nilai kosong jika total_qty juga 0
            ->map(function($item) {
                $item->total_revenue = $item->total_qty > 0 ? 0 : null; 
                return $item;
            });

        // C. Resep vs Bebas
        $qType = $dw->table('fact_obat')
            ->select($col_resep . ' as resep', 
                    DB::raw("SUM($col_qty) as qty"))
            ->where($col_tahun, date('Y'));
        
        // Filter manual
        if ($request->quarter) $qType->where($col_quarter, $request->quarter);
        if ($request->bulan) $qType->where($col_bulan, $request->bulan);
        
        $rawTypeData = $qType->groupBy($col_resep)->get();

        $resepVsBebas = collect(['Bebas', 'Resep'])->map(function($kategori) use ($rawTypeData) {
            $found = $rawTypeData->first(function($item) use ($kategori) {
                if ($kategori == 'Resep') return $item->resep == 'Resep Dokter';
                if ($kategori == 'Bebas') return $item->resep == 'Obat Bebas';
                return false;
            });
            
            return (object) [
                'resep' => $kategori,
                'qty' => $found ? $found->qty : 0,
            ];
        });


        // D. Monthly Best Category (Menggunakan fact_penjualan)
        // Query ini TIDAK MENGGUNAKAN fact_obat, jadi AMAN.
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