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

        return back()->with('success', 'Status order diperbarui berhasil.');
    }
}