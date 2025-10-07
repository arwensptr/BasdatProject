<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl text-brand-800 dark:text-brand-300">Admin Dashboard</h2>
    </x-slot>

    <div class="admin-grid section">
        @include('admin.partials.sidebar')

        <div class="section">
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Card-card statistik --}}
                <div class="card pad">
                    <div class="text-sm text-gray-500 dark:text-slate-400">Resep Menunggu</div>
                    <div class="text-3xl font-bold dark:text-white">{{ $stats['rx_pending'] }}</div>
                </div>
                <div class="card pad">
                    <div class="text-sm text-gray-500 dark:text-slate-400">Pembayaran Menunggu</div>
                    <div class="text-3xl font-bold dark:text-white">{{ $stats['pay_pending'] }}</div>
                </div>
                <div class="card pad">
                    <div class="text-sm text-gray-500 dark:text-slate-400">Order Berjalan</div>
                    <div class="text-3xl font-bold dark:text-white">{{ $stats['orders_open'] }}</div>
                </div>
                <div class="card pad">
                    <div class="text-sm text-gray-500 dark:text-slate-400">Order Hari Ini</div>
                    <div class="text-3xl font-bold dark:text-white">{{ $stats['orders_today'] }}</div>
                </div>
            </div>

            <div class="card pad">
                <div class="flex items-center justify-between mb-4">
                    <div class="font-semibold text-lg dark:text-white">Order Terbaru</div>
                    <a href="{{ route('admin.orders.index') }}" class="text-brand-700 underline dark:text-brand-400">Lihat Semua</a>
                </div>
                <div class="table-wrap">
                    <table class="min-w-full text-sm table-ui">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Order</th>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Customer</th>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Tanggal</th>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Status</th>
                                <th class="px-4 py-3 text-right text-gray-600 dark:text-slate-300">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-slate-700">
                            @forelse($recentOrders as $o)
                                <tr class="hover:bg-brand-50/30 dark:hover:bg-slate-700/50">
                                    <td class="px-4 py-3 dark:text-slate-300">#{{ $o->id }}</td>
                                    <td class="px-4 py-3 dark:text-slate-300">{{ $o->user->name }}</td>
                                    <td class="px-4 py-3 dark:text-slate-300">{{ $o->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-3"><x-status-badge :status="$o->status"/></td>
                                    <td class="px-4 py-3 text-right dark:text-slate-300">Rp {{ number_format($o->total_amount,0,',','.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500 dark:text-slate-400">Belum ada order.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
