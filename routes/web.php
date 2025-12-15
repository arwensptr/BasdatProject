<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// Controllers - General & Auth
use App\Http\Controllers\ProfileController;

// Controllers - SHOP (Customer)
use App\Http\Controllers\Shop\CatalogController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\PrescriptionController as ShopPrescriptionController;
use App\Http\Controllers\Shop\PaymentProofController as ShopPaymentProofController;

// Controllers - ADMIN
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AnalyticsController; 
use App\Http\Controllers\Admin\PrescriptionReviewController;
use App\Http\Controllers\Admin\PaymentReviewController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\MedicineController;

// =====================
// PUBLIC / AUTH
// =====================

Route::get('/', fn () => view('welcome'))->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('shop.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route Dashboard Analisis DW lama Dihapus

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

// =====================
// ADMIN AREA
// =====================
Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
    
    // 1. Dashboard Utama (Operasional & Ringkasan OLAP)
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // 2. Analytics / Data Warehouse (Pentaho Style)
    Route::controller(AnalyticsController::class)->prefix('analytics')->name('analytics.')->group(function () {
        Route::get('/sales', 'sales')->name('sales');       
        Route::get('/lifecycle', 'lifecycle')->name('lifecycle'); 
        Route::get('/inventory', 'inventory')->name('inventory'); 
    });

    // 3. Review Resep 
    Route::get('/prescriptions',                    [PrescriptionReviewController::class,'index'])->name('prescriptions.index');
    Route::get('/prescriptions/{prescription}',      [PrescriptionReviewController::class,'show'])->name('prescriptions.show');
    Route::post('/prescriptions/{prescription}/approve',[PrescriptionReviewController::class,'approve'])->name('prescriptions.approve');
    Route::post('/prescriptions/{prescription}/reject', [PrescriptionReviewController::class,'reject'])->name('prescriptions.reject');

    // 4. Review Pembayaran 
    Route::get('/payments',                        [PaymentReviewController::class,'index'])->name('payments.index');
    Route::get('/payments/{payment}',              [PaymentReviewController::class,'show'])->name('payments.show');
    Route::post('/payments/{payment}/approve',     [PaymentReviewController::class,'approve'])->name('payments.approve');
    Route::post('/payments/{payment}/reject',      [PaymentReviewController::class,'reject'])->name('payments.reject');

    // 5. Manajemen Order 
    Route::get('/orders',                  [AdminOrderController::class,'index'])->name('orders.index');
    Route::post('/orders/{order}/status',  [AdminOrderController::class,'updateStatus'])->name('orders.updateStatus');
    
    // 6. Stok & Obat (CREATE, STORE, INDEX, ADDSTOCK)
    Route::get('/medicines',                     [MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/create',              [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines',                    [MedicineController::class, 'store'])->name('medicines.store');
    Route::post('/medicines/{medicine}/add-stock', [MedicineController::class, 'addStock'])->name('medicines.addStock');
    Route::get('/medicines/{medicine}/edit',        [MedicineController::class, 'edit'])->name('medicines.edit');
    Route::patch('/medicines/{medicine}',           [MedicineController::class, 'update'])->name('medicines.update');   
});

// =====================
// CUSTOMER / SHOP AREA 
// =====================
Route::middleware(['auth','role:customer'])
    ->prefix('shop')->name('shop.')
    ->group(function () {
    Route::get('/',              [CatalogController::class, 'index'])->name('index');
    Route::get('/product/{medicine:slug}',   [CatalogController::class, 'show'])->name('product.show');
    
    Route::get('/cart',              [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add',         [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update',      [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove',      [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear',       [CartController::class, 'clear'])->name('cart.clear');
    
    Route::get('/checkout',          [CheckoutController::class, 'show'])->name('checkout.show');
    Route::post('/checkout',         [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    
    Route::get('/orders',            [ShopOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}',    [ShopOrderController::class, 'show'])->name('orders.show');
    
    Route::get('/orders/{order}/prescription', [ShopPrescriptionController::class,'create'])->name('prescriptions.create');
    Route::post('/orders/{order}/prescription', [ShopPrescriptionController::class,'store'])->name('prescriptions.store');
    
    Route::get('/orders/{order}/payment',  [ShopPaymentProofController::class,'create'])->name('payments.create');
    Route::post('/orders/{order}/payment', [ShopPaymentProofController::class,'store'])->name('payments.store');
});

// ==========================================
// 🚑 ROUTE DARURAT: FIX DATA WAREHOUSE (ETL)
// ==========================================
Route::get('/debug-fill-dw', function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
    // 1. Reset Semua Tabel DW
    DB::table('fact_penjualan')->truncate();
    DB::table('fact_obat')->truncate();
    DB::table('fact_lifecycle_pesanan')->truncate(); 
    DB::table('dim_pelanggan')->truncate();
    DB::table('dim_produk')->truncate();
    DB::table('dim_status_akhir')->truncate();   // <--- KITA RESET JUGA
    DB::table('dim_metode_layanan')->truncate(); // <--- KITA RESET JUGA
    // dim_waktu jangan di reset biar gak capek generate kalender lagi
    
    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    // 2. AUTO-SCAN & ISI DIMENSI STATIS
    // Scan semua jenis status yang ada di tabel orders
    $statuses = DB::table('orders')->select('status')->distinct()->get();
    foreach($statuses as $s) {
        DB::table('dim_status_akhir')->insertOrIgnore([
            'status' => $s->status,
            'created_at' => now(), 'updated_at' => now()
        ]);
    }
    
    // Scan semua jenis kurir yang ada di tabel shipments
    $couriers = DB::table('shipments')->select('courier_name')->distinct()->get();
    foreach($couriers as $c) {
        DB::table('dim_metode_layanan')->insertOrIgnore([
            'nama_kurir' => $c->courier_name,
            'jenis_order' => 'Reguler', // Default, bisa diupdate logicnya jika ada data jenis layanan
            'created_at' => now(), 'updated_at' => now()
        ]);
    }
    
    // 3. MULAI PROSES UTAMA (Sama seperti sebelumnya)
    $orders = DB::table('orders')->get(); 
    
    $count = 0;
    foreach($orders as $order) {
        // --- PROSES WAKTU ---
        $tgl = Carbon::parse($order->created_at);
        $waktuKey = $tgl->format('Y-m-d');
        $cekWaktu = DB::table('dim_waktu')->where('full_date', $waktuKey)->first();
        if (!$cekWaktu) {
            $waktuId = DB::table('dim_waktu')->insertGetId([
                'full_date' => $waktuKey, 'hari' => $tgl->day, 
                'bulan' => $tgl->month, 'tahun' => $tgl->year,
                'nama_bulan' => $tgl->format('F'), 'nama_hari' => $tgl->format('l'),
                'quarter' => 'Q'.$tgl->quarter
            ]);
        } else {
            $waktuId = $cekWaktu->waktu_key;
        }

        // --- PROSES PELANGGAN ---
        $user = DB::table('users')->where('id', $order->user_id)->first();
        $kota = 'Unknown';
        if ($user && $user->address) {
            $parts = explode(',', $user->address); 
            $kota = trim(end($parts)); 
        }
        $existingPel = DB::table('dim_pelanggan')->where('user_id_asli', $order->user_id)->first();
        if ($existingPel) {
            $pelangganId = $existingPel->pelanggan_key;
        } else {
            $pelangganId = DB::table('dim_pelanggan')->insertGetId([
                'user_id_asli' => $order->user_id,
                'nama_kota' => $kota,
                'jenis_kelamin' => $user->gender ?? null,
                'umur' => $user->birth_date ? Carbon::parse($user->birth_date)->age : 0,
                'created_at' => now(), 'updated_at' => now()
            ]);
        }

        // --- PROSES ITEMS ---
        $items = DB::table('order_items')->where('order_id', $order->id)->get();
        foreach($items as $item) {
            $obat = DB::table('medicines')->where('id', $item->medicine_id)->first();
            $existingProd = DB::table('dim_produk')->where('id_obat_asli', $item->medicine_id)->first();
            if ($existingProd) {
                $produkId = $existingProd->produk_key;
            } else {
                $produkId = DB::table('dim_produk')->insertGetId([
                    'id_obat_asli' => $item->medicine_id,
                    'nama_obat' => $obat->name ?? 'Deleted Item',
                    'kategori' => 'Obat',
                    'resep' => ($obat && $obat->is_prescription_only) ? 'Resep' : 'Bebas',
                    'unit_price' => $obat->price ?? 0,
                    'created_at' => now(), 'updated_at' => now()
                ]);
            }
            
            DB::table('fact_penjualan')->insert([
                'waktu_key' => $waktuId,
                'produk_key' => $produkId,
                'pelanggan_key' => $pelangganId,
                'id_order' => (string) $order->id,
                'qty' => $item->qty,
                'harga_satuan' => $item->unit_price,
                'total' => $item->subtotal,
                'created_at' => $order->created_at,
                'updated_at' => now()
            ]);

            DB::table('fact_obat')->insert([
                'id_obat' => $produkId,
                'waktu_key' => $waktuId,
                'id_order' => $order->id,
                'quantity' => $item->qty,
                'total_penjualan' => $item->subtotal,
                'created_at' => $order->created_at
            ]);
        }

        // --- PROSES LOGISTIK ---
        $delivery = DB::table('shipments')->where('order_id', $order->id)->first();
        
        // Cari ID Layanan (Kurir)
        $layananId = 1; // Default jika tidak ada pengiriman (misal order baru)
        if ($delivery) {
            $dimLayanan = DB::table('dim_metode_layanan')
                            ->where('nama_kurir', 'LIKE', '%'.$delivery->courier_name.'%')
                            ->first();
            // Jika kurir ketemu di dimensi, pakai ID-nya
            if ($dimLayanan) $layananId = $dimLayanan->layanan_key;
        }

        // Cari ID Status
        $dimStatus = DB::table('dim_status_akhir')->where('status', $order->status)->first();
        // Fallback: Jika status belum ada (aneh, tapi jaga2), insert baru on the fly
        if (!$dimStatus) {
            $statusId = DB::table('dim_status_akhir')->insertGetId(['status' => $order->status]);
        } else {
            $statusId = $dimStatus->status_key;
        }

        $durasi = 0;
        if ($delivery && $delivery->delivered_at) {
            $start = Carbon::parse($order->created_at);
            $end = Carbon::parse($delivery->delivered_at);
            $durasi = $end->diffInHours($start);
        }

        DB::table('fact_lifecycle_pesanan')->insert([
            'order_id' => $order->id,
            'waktu_order_key' => $waktuId,
            'layanan_key' => $layananId,
            'status_key' => $statusId,
            'durasi_order' => $durasi,
            'jumlah_order' => 1,
            'track_number' => $delivery->tracking_number ?? null,
            'created_at' => $order->created_at,
            'updated_at' => now()
        ]);

        $count++;
    }
    
    return redirect()->route('admin.dashboard')
           ->with('success', "SUKSES! Berhasil update $count data.");
});