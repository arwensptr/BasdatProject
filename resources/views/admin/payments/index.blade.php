<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display text-2xl text-brand-800 dark:text-brand-300">Review Pembayaran</h2>
    </x-slot>

    <div class="admin-grid section">
        @include('admin.partials.sidebar')

        <div class="section">
            @if(session('success'))
                <div class="card pad text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">{{ session('success') }}</div>
            @endif

            <div class="card pad">
                <div class="font-semibold text-lg mb-4 dark:text-white">Daftar Bukti Menunggu</div>

                <div class="table-wrap">
                    <table class="min-w-full text-sm table-ui">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Order</th>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Customer</th>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Diunggah</th>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Status</th>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-slate-700">
                            @forelse($pending as $p)
                                <tr class="hover:bg-brand-50/30 dark:hover:bg-slate-700/50">
                                    <td class="px-4 py-3 dark:text-slate-300">#{{ $p->order_id }}</td>
                                    <td class="px-4 py-3 dark:text-slate-300">{{ $p->order->user->name }} <span class="text-xs text-gray-500 dark:text-slate-400">({{ $p->order->user->email }})</span></td>
                                    <td class="px-4 py-3 dark:text-slate-300">{{ $p->created_at?->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-3"><x-status-badge :status="$p->status" /></td>
                                    <td class="px-4 py-3">
                                        <a class="btn btn-primary px-3 py-1" href="{{ route('admin.payments.show',$p) }}">Lihat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="py-6 text-center text-gray-500 dark:text-slate-400">Tidak ada bukti pembayaran menunggu.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ method_exists($pending,'links') ? $pending->links('vendor.pagination.tailwind') : '' }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
