<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Pesanan Saya</h2>
            <a href="{{ route('shop.index') }}" class="btn btn-white px-3 py-1">← Katalog</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="card pad">
            <form method="GET" class="flex flex-wrap items-center gap-4">
                @php($status = request('status'))
                <label class="text-base font-medium text-gray-600 dark:text-slate-400">Filter:</label> {{-- [FIX] Ukuran teks diperbesar --}}

                {{-- [FIX] Padding vertikal (py-3) dan ukuran teks (text-base) ditambahkan --}}
                <select name="status" class="text-base rounded-lg border-gray-300 focus:border-brand-400 focus:ring-brand-300 py-3 dark:border-slate-700 dark:bg-slate-900 dark:focus:border-brand-500 dark:focus:ring-brand-500">
                    <option value="" {{ $status==='' || $status===null ? 'selected' : '' }}>Semua</option>
                    <option value="open"     {{ $status==='open'    ? 'selected' : '' }}>Masih Berjalan</option>
                    <option value="closed"   {{ $status==='closed'  ? 'selected' : '' }}>Selesai/Dibatalkan</option>

                    @foreach([
                        'awaiting_prescription_upload',
                        'prescription_under_review',
                        'prescription_rejected',
                        'awaiting_payment',
                        'payment_under_review',
                        'payment_rejected',
                        'paid',
                        'processing',
                        'shipped',
                        'delivered',
                        'cancelled'
                    ] as $s)
                        <option value="{{ $s }}" {{ $status===$s ? 'selected' : '' }}>{{ str_replace('_', ' ', Str::ucfirst($s)) }}</option>
                    @endforeach
                </select>

                {{-- [FIX] Padding vertikal (py-3) ditambahkan untuk menyesuaikan tinggi --}}
                <button class="btn btn-primary py-3">Terapkan</button>

                @if ($status)
                    <a href="{{ route('shop.orders.index') }}" class="text-base text-brand-700 dark:text-brand-400 underline">Reset</a> {{-- [FIX] Ukuran teks diperbesar --}}
                @endif
            </form>
        </div>

        {{-- Tabel pesanan --}}
        <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm w-full">
                    <thead class="bg-gray-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-slate-400 uppercase">Order</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-slate-400 uppercase">Tanggal</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-slate-400 uppercase">Status</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-slate-400 uppercase">Total</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-500 dark:text-slate-400 uppercase">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                        @forelse($orders as $o)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-slate-200">#{{ $o->id }}</td>
                                <td class="px-6 py-4 text-gray-600 dark:text-slate-400">{{ $o->created_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-gray-800 dark:text-slate-300 capitalize">{{ str_replace('_', ' ', $o->status) }}</td>
                                <td class="px-6 py-4 text-gray-800 dark:text-slate-300 font-semibold">Rp {{ number_format($o->total_amount,0,',','.') }}</td>
                                <td class="px-6 py-4">
                                    <a class="btn btn-white px-3 py-1" href="{{ route('shop.orders.show', $o) }}">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500 dark:text-slate-500">Tidak ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($orders->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $orders->links('vendor.pagination.tailwind') }}
            </div>
        @endif
    </div>
</x-app-layout>
