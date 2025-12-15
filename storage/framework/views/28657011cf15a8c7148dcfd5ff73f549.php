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
        <h2 class="font-display text-2xl text-slate-800 dark:text-slate-200 font-bold">
            Admin Dashboard
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="admin-grid section">
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="section">
            
            <?php if(session('success')): ?>
                <div class="bg-emerald-100 border border-emerald-200 text-emerald-800 dark:bg-emerald-900/30 dark:border-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-xl relative mb-6 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <div><strong class="font-bold">Berhasil!</strong> <?php echo e(session('success')); ?></div>
                </div>
            <?php endif; ?>

            
            <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-8 gap-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full xl:w-auto">
                    <div class="flex items-center gap-2">
                         <a href="<?php echo e(route('admin.orders.index')); ?>" class="h-10 inline-flex items-center px-4 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm font-medium rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                            Kelola Order
                        </a>
                        <a href="<?php echo e(route('admin.medicines.index')); ?>" class="h-10 inline-flex items-center px-4 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 text-sm font-medium rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                            Kelola Stok
                        </a>
                    </div>
                    
                    
                    <div class="hidden sm:block h-8 w-px bg-slate-300 dark:bg-slate-600 mx-1"></div>
                    
                    
                    <form action="<?php echo e(route('admin.dashboard')); ?>" method="GET" class="flex flex-wrap items-center gap-2">
                        <div class="relative">
                            <select name="quarter" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm bg-white dark:bg-slate-800 dark:text-white cursor-pointer focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Quarter</option>
                                <option value="Q1" <?php echo e(request('quarter') == 'Q1' ? 'selected' : ''); ?>>Q1 (Januari - Maret)</option>
                                <option value="Q2" <?php echo e(request('quarter') == 'Q2' ? 'selected' : ''); ?>>Q2 (April - Juni)</option>
                                <option value="Q3" <?php echo e(request('quarter') == 'Q3' ? 'selected' : ''); ?>>Q3 (Juli - September)</option>
                                <option value="Q4" <?php echo e(request('quarter') == 'Q4' ? 'selected' : ''); ?>>Q4 (Oktober - Desember)</option>
                            </select>
                        </div>
                        <div class="relative">
                            <select name="bulan" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-slate-200 dark:border-slate-700 rounded-xl shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-white dark:bg-slate-800 dark:text-slate-200 cursor-pointer">
                                <option value="">Semua Bulan</option>
                                <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e(request('bulan') == $m ? 'selected' : ''); ?>><?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php if(request('bulan') || request('quarter')): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="h-10 inline-flex items-center gap-1.5 px-3 bg-red-50 text-red-600 border border-red-200 rounded-xl text-sm font-medium hover:bg-red-100 transition-all dark:bg-red-900/20 dark:border-red-800 dark:text-red-400">
                                Reset
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>

            
            <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-4">Operasional Hari Ini</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                
                <div class="p-5 flex items-center gap-4 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border-l-4 border-l-blue-500 dark:border-slate-700">
                    <div class="p-3 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h6M9 8h6M5 4h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V4z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Antrian Resep</div>
                        <div class="text-2xl font-bold text-slate-800 dark:text-white"><?php echo e($oltpStats['rx_pending'] ?? 0); ?></div>
                    </div>
                </div>
                
                
                <div class="p-5 flex items-center gap-4 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border-l-4 border-l-amber-500 dark:border-slate-700">
                    <div class="p-3 rounded-full bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Perlu Review</div>
                        <div class="text-2xl font-bold text-slate-800 dark:text-white"><?php echo e($oltpStats['pay_pending'] ?? 0); ?></div>
                    </div>
                </div>

                
                <div class="p-5 flex items-center gap-4 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border-l-4 border-l-blue-500 dark:border-slate-700">
                    <div class="p-3 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Dalam Proses</div>
                        <div class="text-2xl font-bold text-slate-800 dark:text-white"><?php echo e($oltpStats['orders_open'] ?? 0); ?></div>
                    </div>
                </div>

                
                <div class="p-5 flex items-center gap-4 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border-l-4 border-l-emerald-500 dark:border-slate-700">
                    <div class="p-3 rounded-full bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-slate-500 dark:text-slate-400">Order Hari Ini</div>
                        <div class="text-2xl font-bold text-slate-800 dark:text-white"><?php echo e($oltpStats['orders_today'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            
            <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-4">
                Ringkasan Kinerja <?php echo e(request('quarter') ? request('quarter') : ''); ?> <?php echo e(request('bulan') ? date('F', mktime(0,0,0,request('bulan'),1)) : ''); ?> (2025)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                
                <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-between transition-colors">
                    
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Pendapatan</p>
                        <h4 class="text-3xl font-bold text-slate-800 dark:text-white mt-1">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h4>
                        <div class="mt-2 inline-flex items-center text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-1 rounded">
                            Fact Penjualan
                        </div>
                    </div>
                    
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-full text-blue-600 dark:text-blue-400">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>

                
                <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-between transition-colors">
                    
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Pesanan Diproses</p>
                        <h4 class="text-3xl font-bold text-slate-800 dark:text-white mt-1"><?php echo e(number_format($totalOrdersDW, 0, ',', '.')); ?> <span class="text-lg font-normal text-slate-400">Order</span></h4>
                        <div class="mt-2 inline-flex items-center text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded">
                            Fact Lifecycle
                        </div>
                    </div>
                    
                    <div class="p-4 bg-emerald-50 dark:bg-emerald-900/30 rounded-full text-emerald-600 dark:text-emerald-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                    </div>
                </div>

                
                <div class="p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex items-center justify-between transition-colors">
                    
                    <div>
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Item Terjual</p>
                        <h4 class="text-3xl font-bold text-slate-800 dark:text-white mt-1"><?php echo e(number_format($totalQtySold, 0, ',', '.')); ?> <span class="text-lg font-normal text-slate-400">Unit</span></h4>
                        <div class="mt-2 inline-flex items-center text-xs font-medium text-purple-600 dark:text-purple-400 bg-purple-50 dark:bg-purple-900/30 px-2 py-1 rounded">
                            Fact Obat
                        </div>
                    </div>
                    
                    <div class="p-4 bg-purple-50 dark:bg-purple-900/30 rounded-full text-purple-600 dark:text-purple-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                    </div>
                </div>
            </div>

            
            <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-4">Detail Analisis Data Warehouse</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                
                <a href="<?php echo e(route('admin.analytics.sales')); ?>" class="group p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-blue-500 dark:hover:border-blue-500 transition-all cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-xl font-bold text-slate-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Fact Penjualan</h4>
                        <div class="p-2 rounded-lg bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 h-10 line-clamp-2">Analisis tren pendapatan, penjualan per kategori, dan perbandingan target.</p>
                    <div class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                        Lihat Detail <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>

                
                <a href="<?php echo e(route('admin.analytics.lifecycle')); ?>" class="group p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-emerald-500 dark:hover:border-emerald-500 transition-all cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-xl font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">Fact Lifecycle</h4>
                        <div class="p-2 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 h-10 line-clamp-2">Monitoring durasi pengiriman, performa kurir, dan status pesanan.</p>
                    <div class="inline-flex items-center text-emerald-600 dark:text-emerald-400 font-medium hover:underline">
                        Lihat Detail <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>

                
                <a href="<?php echo e(route('admin.analytics.inventory')); ?>" class="group p-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:border-purple-500 dark:hover:border-purple-500 transition-all cursor-pointer">
                    <div class="flex items-center justify-between mb-4">
                        <h4 class="text-xl font-bold text-slate-800 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Fact Obat</h4>
                        <div class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                    </div>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 h-10 line-clamp-2">Analisis stok terlaris, kategori produk favorit, dan perbandingan obat.</p>
                    <div class="inline-flex items-center text-purple-600 dark:text-purple-400 font-medium hover:underline">
                        Lihat Detail <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
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