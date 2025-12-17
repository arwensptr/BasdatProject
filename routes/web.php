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