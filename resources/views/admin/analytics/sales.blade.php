<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-bold text-slate-800 dark:text-white">Analisis Penjualan</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Monitoring omzet, pelanggan, dan kategori</p>
            </div>
            {{-- FILTER FORM (Sama seperti sebelumnya) --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <form action="{{ route('admin.analytics.sales') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    <select name="quarter" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm bg-white dark:bg-slate-800 dark:text-white cursor-pointer focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Quarter</option>
                        <option value="Q1" {{ request('quarter') == 'Q1' ? 'selected' : '' }}>Q1 (Januari - Maret)</option>
                        <option value="Q2" {{ request('quarter') == 'Q2' ? 'selected' : '' }}>Q2 (April - Juni)</option>
                        <option value="Q3" {{ request('quarter') == 'Q3' ? 'selected' : '' }}>Q3 (Juli - September)</option>
                        <option value="Q4" {{ request('quarter') == 'Q4' ? 'selected' : '' }}>Q4 (Oktober - Desember)</option>
                    </select>
                    <select name="bulan" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm focus:border-blue-500 bg-white dark:bg-slate-800 dark:text-white cursor-pointer">
                        <option value="">Semua Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                        @endforeach
                    </select>
                    @if(request('bulan') || request('quarter'))
                        <a href="{{ route('admin.analytics.sales') }}" class="h-10 px-4 inline-flex items-center gap-2 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl text-sm font-medium hover:bg-red-100">Reset</a>
                    @endif
                </form>
                <a href="{{ route('admin.dashboard') }}" class="h-10 px-4 inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 text-sm hover:bg-slate-50">&larr; Kembali</a>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="admin-grid section">
        @include('admin.partials.sidebar')
        <div class="section">

            {{-- 1. CHART: TREN PENJUALAN --}}
            <div class="card p-6 mb-8 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl">
                <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-6">Tren Pendapatan & Transaksi</h3>
                <div class="relative h-80 w-full">
                    <canvas id="salesTrendChart"></canvas>
                </div>
            </div>

            {{-- GRID 2 KOLOM: TOP CUSTOMER & TOP KATEGORI --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                {{-- 2. TOP 5 PELANGGAN --}}
                <div class="card p-0 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">🏆 Top 5 Pelanggan Sultan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-3">Nama Pelanggan</th>
                                    <th class="px-6 py-3 text-center">Jml Transaksi</th>
                                    <th class="px-6 py-3 text-right">Total Spend</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($topCustomers as $cust)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $cust->name }}</td>
                                        <td class="px-6 py-4 text-center">{{ $cust->total_trx }}x</td>
                                        <td class="px-6 py-4 text-right font-bold text-emerald-600">Rp {{ number_format($cust->total_spend, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-4 text-center">Tidak ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 3. TOP 5 KATEGORI --}}
                <div class="card p-0 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">📦 Top 5 Kategori Terlaris</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-3">Kategori</th>
                                    <th class="px-6 py-3 text-center">Trx</th>
                                    <th class="px-6 py-3 text-center">Qty</th>
                                    <th class="px-6 py-3 text-right">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                @forelse($topCategories as $cat)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $cat->kategori }}</td>
                                        <td class="px-6 py-4 text-center">{{ $cat->total_trx }}</td>
                                        <td class="px-6 py-4 text-center">{{ $cat->total_qty }}</td>
                                        <td class="px-6 py-4 text-right text-blue-600">Rp {{ number_format($cat->total_revenue, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-6 py-4 text-center">Tidak ada data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- 4. REKAP BULANAN --}}
            <div class="card p-0 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white">📅 Rekapitulasi Per Bulan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600 dark:text-slate-400">
                        <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3">Bulan</th>
                                <th class="px-6 py-3 text-center">Total Transaksi</th>
                                <th class="px-6 py-3 text-right">Total Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($monthlyRecap as $row)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white">{{ $row->nama_bulan }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $row->total_trx }} Order
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-800 dark:text-white">Rp {{ number_format($row->total_revenue, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-4 text-center">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- CHART SCRIPT --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Deteksi Dark Mode
        const isDark = document.documentElement.classList.contains('dark');
        
        // 2. Tentukan Warna Berdasarkan Mode
        const textColor = isDark ? '#cbd5e1' : '#64748b'; // Slate-300 (Dark) vs Slate-500 (Light)
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
        const tooltipBg = isDark ? '#1e293b' : '#ffffff'; // Slate-800 vs White
        const tooltipText = isDark ? '#ffffff' : '#1e293b';

        const chartData = @json($chartData);

        new Chart(document.getElementById('salesTrendChart'), {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Pendapatan (Rp)',
                        data: chartData.data1,
                        borderColor: '#3b82f6', // Blue-500
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Transaksi',
                        data: chartData.data2,
                        borderColor: '#10b981', // Emerald-500
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.4,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        labels: { color: textColor } // <--- Warna Teks Legend
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderColor: gridColor,
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        ticks: { color: textColor }, // <--- Warna Teks Sumbu X
                        grid: { display: false }
                    },
                    y: {
                        position: 'left',
                        beginAtZero: true,
                        ticks: { color: textColor }, // <--- Warna Teks Sumbu Y Kiri
                        grid: { color: gridColor }   // <--- Warna Garis Grid
                    },
                    y1: {
                        position: 'right',
                        beginAtZero: true,
                        ticks: { color: textColor }, // <--- Warna Teks Sumbu Y Kanan
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
</x-app-layout>