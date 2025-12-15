<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <--- PENTING: Jangan lupa import ini

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'shipment'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'action' => 'required|in:processing,ship,deliver,cancel',
            'courier_name' => 'nullable|string',
            'tracking_number' => 'nullable|string',
        ]);

        // ==========================================
        // 1. UPDATE OPERASIONAL (TABEL ASLI)
        // ==========================================
        
        if ($request->action == 'processing') {
            $order->update(['status' => 'processing']);
        } 
        elseif ($request->action == 'ship') {
            $order->update(['status' => 'shipped']);
            
            // Update atau Buat Data Pengiriman
            Shipment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'courier_name' => $request->courier_name ?? 'Kurir Toko',
                    'tracking_number' => $request->tracking_number ?? 'SHP-'.time(),
                    'shipped_at' => now(),
                ]
            );
        } 
        elseif ($request->action == 'deliver') {
            $order->update(['status' => 'delivered']);
            
            // Pastikan shipment terupdate waktu sampainya
            Shipment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'courier_name' => $request->courier_name ?? ($order->shipment->courier_name ?? 'Kurir Toko'),
                    'tracking_number' => $request->tracking_number ?? ($order->shipment->tracking_number ?? 'REC-'.time()),
                    'delivered_at' => now(), // Waktu sampai diset SEKARANG
                ]
            );
        } 
        elseif ($request->action == 'cancel') {
            $order->update(['status' => 'cancelled']);
        }

        // ==========================================
        // 2. AUTO-SYNC DATA WAREHOUSE (ETL)
        // ==========================================
        // Jalankan sinkronisasi otomatis agar grafik langsung berubah
        $this->syncDataWarehouse();

        return back()->with('success', 'Status order diperbarui & Data Warehouse otomatis disinkronisasi!');
    }


    // =========================================================================
    // FUNGSI ETL PRIVATE (LOGIKA SAMA PERSIS DENGAN ROUTE /debug-fill-dw)
    // =========================================================================
    private function syncDataWarehouse()
    {
        // 1. BERSIHKAN SEMUA DATA
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('fact_penjualan')->truncate();
        DB::table('fact_obat')->truncate();
        DB::table('fact_lifecycle_pesanan')->truncate();
        DB::table('dim_produk')->truncate(); 
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. PREPARE DEFAULT DIMENSIONS
        $unknownLayanan = DB::table('dim_metode_layanan')->where('nama_kurir', 'Belum Dipilih')->first();
        if (!$unknownLayanan) {
            $unknownLayananId = DB::table('dim_metode_layanan')->insertGetId([
                'nama_kurir' => 'Belum Dipilih', 'jenis_order' => 'N/A', 'created_at' => now()
            ]);
        } else {
            $unknownLayananId = $unknownLayanan->layanan_key;
        }

        // 3. LOOP SEMUA ORDER
        $orders = Order::all();

        foreach($orders as $order) {
            // A. Dimensi Waktu
            $tgl = \Carbon\Carbon::parse($order->created_at);
            $waktuKey = $tgl->format('Y-m-d');
            $cekWaktu = DB::table('dim_waktu')->where('full_date', $waktuKey)->first();
            
            if ($cekWaktu) {
                $waktuId = $cekWaktu->waktu_key;
            } else {
                $waktuId = DB::table('dim_waktu')->insertGetId([
                    'full_date' => $waktuKey, 'hari' => $tgl->day, 'bulan' => $tgl->month, 'tahun' => $tgl->year,
                    'nama_bulan' => $tgl->format('F'), 'nama_hari' => $tgl->format('l'), 'quarter' => 'Q'.$tgl->quarter
                ]);
            }

            // Dimensi Pelanggan
            $pelangganId = 1; 
            $user = DB::table('users')->where('id', $order->user_id)->first();
            if ($user) {
                $cekUser = DB::table('dim_pelanggan')->where('user_id_asli', $user->id)->first();
                if ($cekUser) {
                    $pelangganId = $cekUser->pelanggan_key;
                } else {
                    $pelangganId = DB::table('dim_pelanggan')->insertGetId([
                        'user_id_asli' => $user->id,
                        'nama_kota' => 'Unknown',
                        'jenis_kelamin' => $user->gender ?? 'L',
                        'umur' => $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->age : 0,
                        'created_at' => now(), 'updated_at' => now()
                    ]);
                }
            }

            // B. Lifecycle & Status
            $cekStatus = DB::table('dim_status_akhir')->where('status', $order->status)->first();
            if ($cekStatus) {
                $statusId = $cekStatus->status_key;
            } else {
                $statusId = DB::table('dim_status_akhir')->insertGetId(['status' => $order->status, 'created_at' => now()]);
            }

            $shipment = DB::table('shipments')->where('order_id', $order->id)->first();
            $layananId = $unknownLayananId; 
            $durasi = 0;

            if ($shipment) {
                $cekLayanan = DB::table('dim_metode_layanan')->where('nama_kurir', $shipment->courier_name)->first();
                if ($cekLayanan) {
                    $layananId = $cekLayanan->layanan_key;
                } else {
                    $layananId = DB::table('dim_metode_layanan')->insertGetId(['nama_kurir' => $shipment->courier_name, 'jenis_order' => 'Reguler', 'created_at' => now()]);
                }

                if ($shipment->delivered_at) {
                    $start = \Carbon\Carbon::parse($order->created_at);
                    $end = \Carbon\Carbon::parse($shipment->delivered_at);
                    $durasi = abs($start->diffInHours($end, false));
                }
            }

            DB::table('fact_lifecycle_pesanan')->insert([
                'order_id' => $order->id, 'waktu_order_key' => $waktuId, 'layanan_key' => $layananId,
                'status_key' => $statusId, 'durasi_order' => $durasi, 'jumlah_order' => 1,
                'track_number' => $shipment->tracking_number ?? null, 'created_at' => $order->created_at
            ]);

            // C. Fact Penjualan & Obat
            $statusSah = ['paid', 'confirmed', 'processing', 'shipped', 'delivered'];
            
            if (in_array($order->status, $statusSah)) {
                $items = DB::table('order_items')->where('order_id', $order->id)->get();
                foreach($items as $item) {
                    // Logic Master Data
                    $prod = DB::table('medicines')->where('id', $item->medicine_id)->first();
                    $katNama = 'Umum';
                    if ($prod && isset($prod->category_id)) {
                        $cat = DB::table('categories')->where('id', $prod->category_id)->first();
                        if ($cat) $katNama = $cat->name; 
                    }
                    
                    // Logic Resep vs Bebas
                    $isResep = ($prod && isset($prod->is_prescription_only) && $prod->is_prescription_only == 1);
                    $statusResep = $isResep ? 'Resep' : 'Bebas';

                    // Update Dimensi Produk
                    $cekProd = DB::table('dim_produk')->where('id_obat_asli', $item->medicine_id)->first();
                    if (!$cekProd) {
                        $prodKey = DB::table('dim_produk')->insertGetId([
                            'id_obat_asli' => $item->medicine_id, 
                            'nama_obat' => $prod->name ?? 'Unknown',
                            'kategori' => $katNama, 
                            'resep' => $statusResep,
                            'unit_price' => $prod->price ?? 0, 
                            'created_at' => now(), 'updated_at' => now()
                        ]);
                    } else {
                        // Jika sudah ada, tetap kita pake ID-nya (karena kita truncate di awal, kondisi else ini jarang kena, tapi aman)
                        $prodKey = $cekProd->produk_key;
                    }

                    // Insert Facts
                    DB::table('fact_penjualan')->insert([
                        'waktu_key' => $waktuId, 'produk_key' => $prodKey, 'pelanggan_key' => $pelangganId,
                        'id_order' => $order->id, 'qty' => $item->qty, 'harga_satuan' => $item->unit_price,
                        'total' => $item->subtotal, 'created_at' => $order->created_at
                    ]);
                    
                    DB::table('fact_obat')->insert([
                        'id_obat' => $prodKey, 'waktu_key' => $waktuId, 'id_order' => $order->id,
                        'quantity' => $item->qty, 'total_penjualan' => $item->subtotal, 'created_at' => $order->created_at
                    ]);
                }
            }
        }
    }
}