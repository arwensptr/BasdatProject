<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-display text-2xl text-brand-800 dark:text-brand-300">Admin Dashboard</h2>
     <?php $__env->endSlot(); ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="admin-grid section">
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="section">
            
            
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-200 text-green-800 dark:bg-green-900/50 dark:border-green-600 dark:text-green-300 px-4 py-3 rounded-lg relative mb-6 shadow-sm transition-colors duration-200" role="alert">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <strong class="font-bold mr-2">Berhasil!</strong>
                        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            
            <div class="flex flex-wrap items-center justify-between mb-6 gap-4">
                <div class="flex items-center gap-3">
                    <a href="<?php echo e(route('admin.orders.index')); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-600 text-white rounded-lg shadow-sm hover:bg-brand-700 transition-colors">
                        Lihat Order
                    </a>
                    <a href="<?php echo e(route('admin.medicines.index')); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 dark:bg-slate-700 text-sm text-gray-700 dark:text-white rounded-lg border shadow-sm hover:shadow-md hover:bg-gray-50 dark:hover:bg-slate-600 transition-all">
                        Stok
                    </a>
                </div>
                
                <a href="<?php echo e(url('/debug-fill-dw')); ?>" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white/60 dark:bg-slate-700 text-sm text-brand-700 dark:text-white rounded-lg border border-brand-200 dark:border-slate-500 shadow-sm hover:shadow-md hover:bg-brand-50 dark:hover:bg-slate-600 transition-all" 
                   onclick="return confirm('Proses ini akan menyinkronkan ulang data transaksi ke Data Warehouse. Lanjutkan?')"
                   title="Sinkronkan Data Warehouse">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    Update Data
                </a>
            </div>

            
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="card pad flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-brand-50 dark:bg-brand-500/20">
                        <svg class="h-6 w-6 text-brand-700 dark:text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h6M9 8h6M5 4h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V4z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">Antrian Resep</div>
                        <div class="text-3xl font-bold dark:text-white"><?php echo e($stats['rx_pending'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="card pad flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/10">
                        <svg class="h-6 w-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20"><path d="M8.257 3.099c.765-1.36 2.72-1.36 3.485 0l1.082 1.923A1 1 0 0013.95 7H6.05a1 1 0 00-.874-1.978l1.082-1.923z"></path><path d="M3 13a7 7 0 0114 0v1H3v-1z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">Antrian Pembayaran</div>
                        <div class="text-3xl font-bold dark:text-white"><?php echo e($stats['pay_pending'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="card pad flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-brand-50 dark:bg-brand-500/20">
                        <svg class="h-6 w-6 text-brand-700 dark:text-brand-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M7 7v10a2 2 0 002 2h6a2 2 0 002-2V7"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">Proses Orderan</div>
                        <div class="text-3xl font-bold dark:text-white"><?php echo e($stats['orders_open'] ?? 0); ?></div>
                    </div>
                </div>
                <div class="card pad flex items-center gap-4">
                    <div class="p-3 rounded-lg bg-green-50 dark:bg-green-900/10">
                        <svg class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 8v8M8 12h8"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500 dark:text-slate-400">Order Hari Ini</div>
                        <div class="text-3xl font-bold dark:text-white"><?php echo e($stats['orders_today'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="card pad lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg dark:text-white">Tren Pendapatan (2025)</h3>
                    </div>
                    <div class="relative h-64 w-full">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>

                <div class="card pad">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg dark:text-white">Top 5 Obat Terlaris</h3>
                    </div>
                    <div class="relative h-64 w-full flex justify-center items-center" id="productChartContainer">
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>

            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                
                
                <div class="card pad">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-lg dark:text-white">Status Pesanan</h3>
                    </div>
                    <div class="relative h-64 w-full">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                
                <div class="card pad lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <div class="font-semibold text-lg dark:text-white">Order Terbaru</div>
                        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-brand-700 underline dark:text-brand-400 hover:text-brand-800 transition-colors">Lihat Semua</a>
                    </div>
                    <div class="table-wrap overflow-x-auto">
                        <table class="min-w-full text-sm table-ui">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-slate-300">Order</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-slate-300">Customer</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-600 dark:text-slate-300">Status</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-600 dark:text-slate-300">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y dark:divide-slate-700">
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-brand-50/30 dark:hover:bg-slate-700/50 transition-colors">
                                        <td class="px-4 py-3 dark:text-slate-300 font-medium">#<?php echo e($o->id); ?></td>
                                        <td class="px-4 py-3 dark:text-slate-300"><?php echo e($o->user->name); ?></td>
                                        <td class="px-4 py-3">
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize
                                                <?php echo e($o->status == 'delivered' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                                                  ($o->status == 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : 
                                                  ($o->status == 'shipped' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400'))); ?>">
                                                <?php echo e(str_replace('_', ' ', $o->status)); ?>

                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right dark:text-slate-300 font-medium">Rp <?php echo e(number_format($o->total_amount,0,',','.')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-gray-500 dark:text-slate-400 italic">Belum ada order.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari Controller
            const salesData = <?php echo json_encode($salesTrend ?? [], 15, 512) ?>;
            const productData = <?php echo json_encode($topProducts ?? [], 15, 512) ?>;
            const statusData = <?php echo json_encode($orderStatus ?? [], 15, 512) ?>; // DATA BARU

            let salesChart = null;
            let productChart = null;
            let statusChart = null; // CHART BARU

            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
            }

            // 1. CHART PENJUALAN (Line)
            const ctxSales = document.getElementById('salesChart');
            if (ctxSales && salesData.length > 0) {
                salesChart = new Chart(ctxSales, {
                    type: 'line',
                    data: {
                        labels: salesData.map(d => d.nama_bulan),
                        datasets: [{
                            label: 'Total Pendapatan',
                            data: salesData.map(d => d.total_revenue),
                            borderColor: '#4f46e5',
                            backgroundColor: (ctx) => {
                                const g = ctx.chart.ctx.createLinearGradient(0,0,0,300);
                                g.addColorStop(0, 'rgba(79, 70, 229, 0.2)');
                                g.addColorStop(1, 'rgba(79, 70, 229, 0.0)');
                                return g;
                            },
                            borderWidth: 2.5,
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: { 
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true }, x: { grid: { display: false } } }
                    }
                });
            } else if(ctxSales) {
                ctxSales.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm">Data Penjualan Kosong</div>';
            }

            // 2. CHART PRODUK (Doughnut)
            const ctxProduct = document.getElementById('productChart');
            if (ctxProduct && productData.length > 0) {
                productChart = new Chart(ctxProduct, {
                    type: 'doughnut',
                    data: {
                        labels: productData.map(d => d.nama_obat),
                        datasets: [{
                            data: productData.map(d => d.total_sold),
                            backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                            borderWidth: 2
                        }]
                    },
                    options: { 
                        responsive: true, maintainAspectRatio: false, cutout: '65%',
                        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, boxWidth: 8, padding: 10 } } }
                    }
                });
            } else if(ctxProduct) {
                document.getElementById('productChartContainer').innerHTML = '<div class="flex items-center justify-center text-gray-400 text-sm">Data Produk Kosong</div>';
            }

            // 3. [BARU] CHART STATUS (Bar)
            const ctxStatus = document.getElementById('statusChart');
            if (ctxStatus && statusData.length > 0) {
                statusChart = new Chart(ctxStatus, {
                    type: 'bar',
                    data: {
                        labels: statusData.map(d => d.status.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())), // Format text rapi
                        datasets: [{
                            label: 'Jumlah Order',
                            data: statusData.map(d => d.total),
                            backgroundColor: statusData.map(d => {
                                // Warna dinamis berdasarkan status
                                if(d.status.includes('delivered')) return '#10b981'; // Hijau
                                if(d.status.includes('shipped')) return '#3b82f6';   // Biru
                                if(d.status.includes('cancel')) return '#ef4444';    // Merah
                                return '#f59e0b'; // Kuning (Processing/Pending)
                            }),
                            borderRadius: 6,
                            borderWidth: 0
                        }]
                    },
                    options: { 
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } }, // Gak perlu legend krn warnanya beda2
                        scales: { 
                            y: { beginAtZero: true, ticks: { stepSize: 1 } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            } else if(ctxStatus) {
                ctxStatus.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-400 text-sm">Data Status Kosong</div>';
            }

            // --- THEME UPDATE FUNCTION ---
            function updateChartTheme() {
                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#f8fafc' : '#64748b';
                const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)';
                const borderColor = isDark ? '#1e293b' : '#ffffff';

                [salesChart, statusChart].forEach(chart => {
                    if (chart) {
                        chart.options.scales.x.ticks.color = textColor;
                        chart.options.scales.y.ticks.color = textColor;
                        chart.options.scales.y.grid.color = gridColor;
                        chart.update();
                    }
                });

                if (productChart) {
                    productChart.options.plugins.legend.labels.color = textColor;
                    productChart.data.datasets[0].borderColor = borderColor;
                    productChart.update();
                }
            }

            updateChartTheme();
            new MutationObserver(m => m.forEach(x => x.attributeName === 'class' && updateChartTheme()))
                .observe(document.documentElement, { attributes: true });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\farmacheat\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>