<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl text-slate-800 dark:text-white font-bold">Manajemen Order</h2>
    </x-slot>

    <div class="admin-grid section">
        @include('admin.partials.sidebar')

        <div class="section">
            @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <div><strong class="font-bold">Berhasil!</strong> {{ session('success') }}</div>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 font-semibold uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap">Order ID</th>
                                <th class="px-6 py-4 whitespace-nowrap">Customer</th>
                                <th class="px-6 py-4 whitespace-nowrap">Status</th>
                                <th class="px-6 py-4 whitespace-nowrap text-right">Total</th>
                                <th class="px-6 py-4 whitespace-nowrap">Pengiriman</th>
                                <th class="px-6 py-4">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @foreach($orders as $o)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                    {{-- 1. ORDER ID (1 Baris) --}}
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white whitespace-nowrap">
                                        #{{ $o->id }} <span class="text-slate-400 mx-1">|</span> <span class="text-xs text-slate-500">{{ $o->created_at->format('d/m/y H:i') }}</span>
                                    </td>

                                    {{-- 2. CUSTOMER (1 Baris) --}}
                                    <td class="px-6 py-4 dark:text-slate-300 whitespace-nowrap">
                                        {{ $o->user->name }}
                                    </td>

                                    {{-- 3. STATUS (1 Baris) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-status-badge :status="$o->status"/>
                                    </td>

                                    {{-- 4. TOTAL (1 Baris) --}}
                                    <td class="px-6 py-4 text-right font-bold text-slate-700 dark:text-slate-200 whitespace-nowrap">
                                        Rp {{ number_format($o->total_amount, 0, ',', '.') }}
                                    </td>

                                    {{-- 5. PENGIRIMAN (1 Baris - Sebelahan) --}}
                                    <td class="px-6 py-4 dark:text-slate-300 whitespace-nowrap">
                                        @if($o->shipment)
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-xs font-bold border border-blue-100 dark:border-blue-800">
                                                    {{ $o->shipment->courier_name }}
                                                </span>
                                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">
                                                    {{ $o->shipment->tracking_number }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-slate-400 text-xl leading-none">&minus;</span>
                                        @endif
                                    </td>

                                    {{-- 6. UPDATE STATUS (Boleh 2 Baris agar hemat lebar) --}}
                                    <td class="px-6 py-4">
                                        <form method="POST" action="{{ route('admin.orders.updateStatus', $o) }}">
                                            @csrf
                                            <div class="flex flex-col gap-2 w-full max-w-[280px]">
                                                
                                                {{-- Baris 1: Status + Tombol --}}
                                                <div class="flex gap-2">
                                                    <select name="action" class="flex-1 rounded-lg border-slate-300 dark:border-slate-600 text-xs py-1.5 px-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white">
                                                        <option value="processing" {{ $o->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                                        <option value="ship" {{ $o->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                        <option value="deliver" {{ $o->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                        <option value="cancel" {{ $o->status == 'cancelled' ? 'selected' : '' }}>Cancel</option>
                                                    </select>
                                                    <button class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                                                        Update
                                                    </button>
                                                </div>

                                                {{-- Baris 2: Kurir + Resi --}}
                                                <div class="flex gap-2">
                                                    <select name="courier_name" class="w-1/3 rounded-lg border-slate-300 dark:border-slate-600 text-[11px] py-1.5 px-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white">
                                                        <option value="" disabled {{ !$o->shipment ? 'selected' : '' }}>Kurir</option>
                                                        @php $couriers = ['JNE', 'TiKi', 'SiCepat', 'J&T', 'Pos', 'GoSend', 'Grab']; @endphp
                                                        @foreach($couriers as $courier)
                                                            <option value="{{ $courier }}" {{ ($o->shipment->courier_name ?? '') == $courier ? 'selected' : '' }}>{{ $courier }}</option>
                                                        @endforeach
                                                    </select>
                                                    <input type="text" name="tracking_number" placeholder="Input Resi..." 
                                                           class="flex-1 rounded-lg border-slate-300 dark:border-slate-600 text-[11px] py-1.5 px-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white"
                                                           value="{{ $o->shipment->tracking_number ?? '' }}">
                                                </div>

                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                {{ $orders->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-app-layout>
