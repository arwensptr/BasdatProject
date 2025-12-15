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
        <h2 class="font-display text-2xl text-brand-800 dark:text-brand-300">
            Analytics Dashboard
        </h2>
     <?php $__env->endSlot(); ?>

    

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

            
            <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-8 gap-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full xl:w-auto">
                    
                    <div class="flex items-center gap-2">
                         <a href="<?php echo e(route('admin.orders.index')); ?>" class="h-10 inline-flex items-center px-4 bg-white/60 dark:bg-slate-700 text-gray-700 dark:text-white text-sm font-medium rounded-lg border border-gray-200 dark:border-slate-600 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-600 transition-all">
                            Kelola Order
                        </a>
                        <a href="<?php echo e(route('admin.medicines.index')); ?>" class="h-10 inline-flex items-center px-4 bg-white/60 dark:bg-slate-700 text-gray-700 dark:text-white text-sm font-medium rounded-lg border border-gray-200 dark:border-slate-600 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-600 transition-all">
                            Kelola Stok
                        </a>
                    </div>

                    
                    <div class="hidden sm:block h-8 w-px bg-gray-300 dark:bg-slate-600 mx-1"></div>

                    
                    <form action="<?php echo e(route('admin.dashboard')); ?>" method="GET" class="flex flex-wrap items-center gap-2">
                        <div class="relative">
                            <select name="quarter" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-gray-300 rounded-lg shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200 cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                                <option value="">Semua Quarter</option>
                                <option value="Q1" <?php echo e(request('quarter') == 'Q1' ? 'selected' : ''); ?>>Q1 (Jan-Mar)</option>
                                <option value="Q2" <?php echo e(request('quarter') == 'Q2' ? 'selected' : ''); ?>>Q2 (Apr-Jun)</option>
                                <option value="Q3" <?php echo e(request('quarter') == 'Q3' ? 'selected' : ''); ?>>Q3 (Jul-Sep)</option>
                                <option value="Q4" <?php echo e(request('quarter') == 'Q4' ? 'selected' : ''); ?>>Q4 (Oct-Dec)</option>
                            </select>
                        </div>
                        <div class="relative">
                            <select name="bulan" onchange="this.form.submit()" class="h-10 pl-3 pr-8 text-sm border-gray-300 rounded-lg shadow-sm focus:border-brand-500 focus:ring-brand-500 dark:bg-slate-700 dark:border-slate-600 dark:text-gray-200 cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-600 transition-colors">
                                <option value="">Semua Bulan</option>
                                <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($m); ?>" <?php echo e(request('bulan') == $m ? 'selected' : ''); ?>>
                                        <?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <?php if(request('bulan') || request('quarter')): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>"
                               class="h-10 inline-flex items-center gap-1.5 px-3 bg-red-50 text-red-600 border border-red-200 rounded-lg text-sm font-medium hover:bg-red-100 hover:border-red-300 hover:text-red-800 transition-all dark:bg-red-900/20 dark:border-red-800 dark:text-red-400 dark:hover:bg-red-900/40"
                               title="Hapus Filter">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                Reset
                            </a>
                        <?php endif; ?>
                    </form>
                </div>
                
                <div class="w-full xl:w-auto flex justify-start xl:justify-end">
                    <a href="<?php echo e(url('/debug-fill-dw')); ?>"
                       class="h-10 inline-flex items-center gap-2 px-4 bg-brand-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-brand-700 transition-colors"
                       onclick="return confirm('Sinkronisasi ulang Data Warehouse?')"
                       title="Sinkronkan Data Warehouse">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                        Update Data
                    </a>
                </div>
            </div>

            
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Operasional Hari Ini</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                
                <div class="card pad flex items-center gap-4 border-l-4 border-brand-500">
                    <div class="p-3 rounded-full bg-brand-100 dark:bg-brand-900/30">
                        <svg class="h-6 w-6 text-brand-600 dark:text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6M9 16h6M9 8h6M5 4h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V4z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-slate-400">Antrian Resep</div>
                        <div class="text-2xl font-bold dark:text-white"><?php echo e($oltpStats['rx_pending'] ?? 0); ?></div>
                    </div>
                </div>
                
                <div class="card pad flex items-center gap-4 border-l-4 border-yellow-500">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900/30">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-slate-400">Perlu Review</div>
                        <div class="text-2xl font-bold dark:text-white"><?php echo e($oltpStats['pay_pending'] ?? 0); ?></div>
                    </div>
                </div>
                 
                 <div class="card pad flex items-center gap-4 border-l-4 border-blue-500">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900/30">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-slate-400">Dalam Proses</div>
                        <div class="text-2xl font-bold dark:text-white"><?php echo e($oltpStats['orders_open'] ?? 0); ?></div>
                    </div>
                </div>
                 
                 <div class="card pad flex items-center gap-4 border-l-4 border-green-500">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900/30">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-500 dark:text-slate-400">Order Hari Ini</div>
                        <div class="text-2xl font-bold dark:text-white"><?php echo e($oltpStats['orders_today'] ?? 0); ?></div>
                    </div>
                </div>
            </div>

            
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">
                Ringkasan Kinerja <?php echo e(request('quarter') ? request('quarter') : ''); ?> <?php echo e(request('bulan') ? date('F', mktime(0,0,0,request('bulan'),1)) : ''); ?> (2025)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                
                
                <div class="rounded-2xl p-6 bg-gradient-to-br from-blue-600 to-blue-800 text-white shadow-lg transform hover:scale-[1.02] transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-blue-100 font-medium mb-1">Total Pendapatan</p>
                            <h4 class="text-3xl font-bold">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></h4>
                        </div>
                        <div class="p-3 bg-blue-500/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                    <p class="text-sm text-blue-200 mt-4">Sumber: Fact Penjualan</p>
                </div>

                
                <div class="rounded-2xl p-6 bg-gradient-to-br from-emerald-600 to-emerald-800 text-white shadow-lg transform hover:scale-[1.02] transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-emerald-100 font-medium mb-1">Total Pesanan Diproses</p>
                            <h4 class="text-3xl font-bold"><?php echo e(number_format($totalOrdersDW, 0, ',', '.')); ?> <span class="text-lg font-normal">Order</span></h4>
                        </div>
                        <div class="p-3 bg-emerald-500/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        </div>
                    </div>
                     <p class="text-sm text-emerald-200 mt-4">Sumber: Fact Lifecycle Pesanan</p>
                </div>

                
                <div class="rounded-2xl p-6 bg-gradient-to-br from-purple-600 to-purple-800 text-white shadow-lg transform hover:scale-[1.02] transition-all">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-purple-100 font-medium mb-1">Total Item Terjual</p>
                            <h4 class="text-3xl font-bold"><?php echo e(number_format($totalQtySold, 0, ',', '.')); ?> <span class="text-lg font-normal">Unit</span></h4>
                        </div>
                        <div class="p-3 bg-purple-500/30 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-100" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                        </div>
                    </div>
                     <p class="text-sm text-purple-200 mt-4">Sumber: Fact Obat</p>
                </div>
            </div>

            
             <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Detail Analisis Data</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                
                <a href="<?php echo e(route('admin.analytics.sales')); ?>" class="group card pad flex flex-col hover:border-brand-500 dark:hover:border-brand-400 transition-all cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 text-gray-100 dark:text-slate-800/50 transition-all group-hover:text-brand-100 dark:group-hover:text-brand-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" /></svg>
                    </div>
                    <div class="relative z-10 flex items-center gap-4 mb-3">
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400 group-hover:bg-brand-600 group-hover:text-white transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-brand-700 dark:group-hover:text-brand-300">Analisis Penjualan</h4>
                    </div>
                    <p class="relative z-10 text-sm text-gray-500 dark:text-slate-400">Detail tren pendapatan, penjualan per kategori, dan perbandingan target.</p>
                     <div class="relative z-10 mt-4 flex items-center text-sm font-medium text-brand-600 dark:text-brand-400 group-hover:underline">
                        Lihat Detail <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </div>
                </a>

                
                <a href="<?php echo e(route('admin.analytics.lifecycle')); ?>" class="group card pad flex flex-col hover:border-emerald-500 dark:hover:border-emerald-400 transition-all cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 text-gray-100 dark:text-slate-800/50 transition-all group-hover:text-emerald-100 dark:group-hover:text-emerald-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
                    </div>
                    <div class="relative z-10 flex items-center gap-4 mb-3">
                        <div class="p-3 rounded-lg bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-emerald-700 dark:group-hover:text-emerald-300">Analisis Lifecycle & Logistik</h4>
                    </div>
                    <p class="relative z-10 text-sm text-gray-500 dark:text-slate-400">Monitoring durasi pengiriman, performa kurir, dan status pesanan.</p>
                    <div class="relative z-10 mt-4 flex items-center text-sm font-medium text-emerald-600 dark:text-emerald-400 group-hover:underline">
                        Lihat Detail <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                    </div>
                </a>

                
                <a href="<?php echo e(route('admin.analytics.inventory')); ?>" class="group card pad flex flex-col hover:border-purple-500 dark:hover:border-purple-400 transition-all cursor-pointer relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 text-gray-100 dark:text-slate-800/50 transition-all group-hover:text-purple-100 dark:group-hover:text-purple-900/20">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <div class="relative z-10 flex items-center gap-4 mb-3">
                        <div class="p-3 rounded-lg bg-purple-100 text-purple-600 dark:bg-purple-900/30 dark:text-purple-400 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-800 dark:text-white group-hover:text-purple-700 dark:group-hover:text-purple-300">Analisis Inventori Obat</h4>
                    </div>
                    <p class="relative z-10 text-sm text-gray-500 dark:text-slate-400">Detail obat terlaris, pergerakan stok, dan analisis kategori produk.</p>
                     <div class="relative z-10 mt-4 flex items-center text-sm font-medium text-purple-600 dark:text-purple-400 group-hover:underline">
                        Lihat Detail <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
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
<?php endif; ?><?php /**PATH C:\laragon\www\farmacheat\resources\views/admin/analytics/index.blade.php ENDPATH**/ ?>