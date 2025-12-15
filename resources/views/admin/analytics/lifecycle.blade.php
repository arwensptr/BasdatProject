<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-bold text-slate-800 dark:text-white">Analisis Lifecycle</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Status pesanan & performa kurir</p>
            </div>
            {{-- Filter Area --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <form action="{{ route('admin.analytics.lifecycle') }}" method="GET" class="flex flex-wrap items-center gap-2">
                    
                    {{-- Dropdown Quarter (Updated Text) --}}
                    <div class="relative group">
                        <select name="quarter" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm bg-white dark:bg-slate-800 dark:text-white cursor-pointer focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Quarter</option>
                            <option value="Q1" {{ request('quarter') == 'Q1' ? 'selected' : '' }}>Q1 (Januari - Maret)</option>
                            <option value="Q2" {{ request('quarter') == 'Q2' ? 'selected' : '' }}>Q2 (April - Juni)</option>
                            <option value="Q3" {{ request('quarter') == 'Q3' ? 'selected' : '' }}>Q3 (Juli - September)</option>
                            <option value="Q4" {{ request('quarter') == 'Q4' ? 'selected' : '' }}>Q4 (Oktober - Desember)</option>
                        </select>
                    </div>

                    {{-- Dropdown Bulan --}}
                    <div class="relative group">
                        <select name="bulan" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm bg-white dark:bg-slate-800 dark:text-white cursor-pointer focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if(request('bulan') || request('quarter'))
                        <a href="{{ route('admin.analytics.lifecycle') }}" class="h-10 px-4 inline-flex items-center gap-2 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl text-sm font-medium hover:bg-red-100 border border-red-200 dark:border-red-800 transition-colors">Reset</a>
                    @endif
                </form>
                <a href="{{ route('admin.dashboard') }}" class="h-10 px-4 inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 text-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">&larr; Kembali</a>
            </div>
        </div>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="admin-grid section">
        @include('admin.partials.sidebar')
        <div class="section">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                {{-- 1. PIE CHART: STATUS --}}
                <div class="card p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Distribusi Status Pesanan</h3>
                    <div class="relative h-64">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                {{-- 2. BAR CHART: KURIR --}}
                <div class="card p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Penggunaan Kurir (Jumlah Order)</h3>
                    <div class="relative h-64">
                        <canvas id="courierChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- 3. TABEL DETAIL KURIR --}}
            <div class="card p-0 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl overflow-hidden">
                <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white">🚚 Detail Performa Kurir</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600 dark:text-slate-400">
                        <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-3">Nama Kurir</th>
                                <th class="px-6 py-3 text-center">Total Order Diantar</th>
                                <th class="px-6 py-3 text-center">Rata-rata Durasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse($courierTable as $row)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                    <td class="px-6 py-4 font-bold text-slate-800 dark:text-white">{{ $row->nama_kurir }}</td>
                                    <td class="px-6 py-4 text-center">{{ $row->total_order }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ number_format($row->avg_duration, 1) }} Jam
                                        </span>
                                    </td>
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

    {{-- SCRIPT CHART JS --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Deteksi Dark Mode
        const isDark = document.documentElement.classList.contains('dark');
        
        // 2. Warna Adaptive
        const textColor = isDark ? '#cbd5e1' : '#64748b';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
        const tooltipBg = isDark ? '#1e293b' : '#ffffff';
        const tooltipText = isDark ? '#ffffff' : '#1e293b';
        const sliceBorder = isDark ? '#1e293b' : '#ffffff';

        // --- CHART 1: STATUS (DOUGHNUT) ---
        const statusData = @json($statusChart);
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: statusData.map(d => d.status.replace('_',' ').toUpperCase()),
                datasets: [{
                    data: statusData.map(d => d.total),
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderColor: sliceBorder, // <--- Border Slice
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: { color: textColor } // <--- Warna Legend
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText
                    }
                }
            }
        });

        // --- CHART 2: KURIR (BAR) ---
        const courierData = @json($courierChart);
        new Chart(document.getElementById('courierChart'), {
            type: 'bar',
            data: {
                labels: courierData.map(d => d.nama_kurir),
                datasets: [{
                    label: 'Total Order',
                    data: courierData.map(d => d.total),
                    backgroundColor: '#6366f1', // Indigo-500
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: textColor }, // <--- Warna Teks Y
                        grid: { color: gridColor }   // <--- Warna Grid
                    },
                    x: {
                        ticks: { color: textColor }, // <--- Warna Teks X
                        grid: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText
                    }
                }
            }
        });
    });
</script>
</x-app-layout>