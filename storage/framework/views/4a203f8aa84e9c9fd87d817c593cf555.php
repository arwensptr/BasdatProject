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
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h2 class="font-display text-2xl font-bold text-slate-800 dark:text-white">Analisis Inventori</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Distribusi obat & kategori terlaris</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <form action="<?php echo e(route('admin.analytics.inventory')); ?>" method="GET" class="flex flex-wrap items-center gap-2">
                    <select name="quarter" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm bg-white dark:bg-slate-800 dark:text-white cursor-pointer focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Quarter</option>
                        <option value="Q1" <?php echo e(request('quarter') == 'Q1' ? 'selected' : ''); ?>>Q1 (Januari - Maret)</option>
                        <option value="Q2" <?php echo e(request('quarter') == 'Q2' ? 'selected' : ''); ?>>Q2 (April - Juni)</option>
                        <option value="Q3" <?php echo e(request('quarter') == 'Q3' ? 'selected' : ''); ?>>Q3 (Juli - September)</option>
                        <option value="Q4" <?php echo e(request('quarter') == 'Q4' ? 'selected' : ''); ?>>Q4 (Oktober - Desember)</option>
                    </select>
                    <select name="bulan" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm bg-white dark:bg-slate-800 dark:text-white cursor-pointer">
                        <option value="">Semua Bulan</option>
                        <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($m); ?>" <?php echo e(request('bulan') == $m ? 'selected' : ''); ?>><?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php if(request('bulan') || request('quarter')): ?>
                        <a href="<?php echo e(route('admin.analytics.inventory')); ?>" class="h-10 px-4 inline-flex items-center gap-2 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl text-sm font-medium hover:bg-red-100">Reset</a>
                    <?php endif; ?>
                </form>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="h-10 px-4 inline-flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-600 dark:text-slate-300 text-sm hover:bg-slate-50">&larr; Kembali</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <div class="admin-grid section">
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <div class="section">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                
                <div class="card p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl lg:col-span-1">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">💊 Top 5 Obat (Qty)</h3>
                    
                    <div class="relative h-80"> 
                        <canvas id="medicinePieChart"></canvas>
                    </div>
                </div>

                
                <div class="card p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl lg:col-span-2 flex flex-col justify-center">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-4">Insight: Obat Resep vs Bebas</h3>
                    <div class="grid grid-cols-2 gap-6">
                        <?php $__currentLoopData = $resepVsBebas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-6 rounded-2xl border <?php echo e($type->resep == 'Resep' ? 'bg-purple-50 border-purple-200 dark:bg-purple-900/20 dark:border-purple-800' : 'bg-orange-50 border-orange-200 dark:bg-orange-900/20 dark:border-orange-800'); ?>">
                                <div class="text-xs font-bold uppercase tracking-wider <?php echo e($type->resep == 'Resep' ? 'text-purple-600' : 'text-orange-600'); ?>"><?php echo e($type->resep); ?></div>
                                <div class="text-3xl font-bold text-slate-800 dark:text-white mt-2"><?php echo e($type->qty); ?> <span class="text-base font-normal text-slate-500">Unit</span></div>
                                <div class="text-sm text-slate-500 mt-1">Revenue: Rp <?php echo e(number_format($type->revenue, 0, ',', '.')); ?></div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                
                
                <div class="card p-0 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700">
                        <h3 class="font-bold text-lg text-slate-800 dark:text-white">🏆 Top 10 Kategori Terlaris</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-3">Kategori</th>
                                    <th class="px-6 py-3 text-center">Trx</th>
                                    <th class="px-6 py-3 text-right">Revenue</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                <?php $__empty_1 = true; $__currentLoopData = $top10Categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-white"><?php echo e($cat->kategori); ?></td>
                                        <td class="px-6 py-4 text-center"><?php echo e($cat->total_trx); ?></td>
                                        <td class="px-6 py-4 text-right text-blue-600">Rp <?php echo e(number_format($cat->total_revenue, 0, ',', '.')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="3" class="px-6 py-4 text-center">Tidak ada data</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                
                <div class="card p-0 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm rounded-2xl overflow-hidden">
                    <div class="p-4 border-b border-slate-200 dark:border-slate-700 bg-yellow-50 dark:bg-yellow-900/10">
                        <h3 class="font-bold text-lg text-yellow-800 dark:text-yellow-500">👑 Kategori Paling Laris / Bulan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-600 dark:text-slate-400">
                            <thead class="bg-slate-50 dark:bg-slate-900/50 text-xs uppercase font-semibold">
                                <tr>
                                    <th class="px-6 py-3">Bulan</th>
                                    <th class="px-6 py-3">Kategori Juara</th>
                                    <th class="px-6 py-3 text-right">Total Qty</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                <?php $__empty_1 = true; $__currentLoopData = $monthlyBestCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30">
                                        <td class="px-6 py-4 font-medium"><?php echo e($row->bulan); ?></td>
                                        <td class="px-6 py-4 font-bold text-slate-800 dark:text-white"><?php echo e($row->kategori); ?></td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">
                                                <?php echo e($row->total_qty); ?> Sold
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="3" class="px-6 py-4 text-center">Tidak ada data</td></tr>
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
        // 1. Deteksi Dark Mode
        const isDark = document.documentElement.classList.contains('dark');
        
        // 2. Warna Adaptive
        const textColor = isDark ? '#cbd5e1' : '#64748b';
        const tooltipBg = isDark ? '#1e293b' : '#ffffff';
        const tooltipText = isDark ? '#ffffff' : '#1e293b';
        const borderColor = isDark ? '#1e293b' : '#ffffff'; // Border antar slice pie mengikuti bg card

        const pieData = <?php echo json_encode($topMedicinesChart, 15, 512) ?>;

        new Chart(document.getElementById('medicinePieChart'), {
            type: 'pie',
            data: {
                labels: pieData.map(d => d.nama_obat),
                datasets: [{
                    data: pieData.map(d => d.total_qty),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                    borderColor: borderColor, // <--- Border Slice
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { color: textColor, padding: 20 } // <--- Warna Legend
                    },
                    tooltip: {
                        backgroundColor: tooltipBg,
                        titleColor: tooltipText,
                        bodyColor: tooltipText,
                        borderWidth: 1
                    }
                }
            }
        });
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
<?php endif; ?><?php /**PATH C:\laragon\www\farmacheat\resources\views/admin/analytics/inventory.blade.php ENDPATH**/ ?>