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
        <h2 class="text-2xl font-semibold dark:text-slate-200">Stok Obat</h2>
     <?php $__env->endSlot(); ?>

    <div class="admin-grid section">
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="section">
            <?php if(session('success')): ?> <div class="card pad text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300"><?php echo e(session('success')); ?></div> <?php endif; ?>
            <?php if(session('error')): ?>   <div class="card pad text-red-700 dark:bg-red-900/50 dark:text-red-300"><?php echo e(session('error')); ?></div> <?php endif; ?>

            <div class="card pad mb-4">
                <div class="flex items-center justify-between">
                    <form method="GET" action="<?php echo e(route('admin.medicines.index')); ?>">
                        <div class="flex items-center gap-2">
                            <input type="text" name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari nama obat..." class="w-full rounded-lg border-gray-300 dark:bg-slate-900 dark:border-slate-700">
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </div>
                    </form>
                    <a href="<?php echo e(route('admin.medicines.create')); ?>" class="btn btn-primary">+ Tambah Obat</a>
                </div>
            </div>

            <div class="table-wrap">
                <table class="min-w-full text-sm table-ui">
                    <thead class="bg-gray-50 dark:bg-slate-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300 w-20">Gambar</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Obat</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Kategori</th>
                            
                            <th class="px-4 py-3 text-right text-gray-600 dark:text-slate-300">Harga</th>
                            <th class="px-4 py-3 text-center text-gray-600 dark:text-slate-300">Resep</th>
                            <th class="px-4 py-3 text-center text-gray-600 dark:text-slate-300">Stok</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Tambah Stok</th>
                            <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-slate-700">
                        <?php $__empty_1 = true; $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-brand-50/30 dark:hover:bg-slate-700/50">
                                <td class="px-4 py-3">
                                    <img src="<?php echo e($m->image ? asset('storage/' . $m->image) : 'https://placehold.co/100x100/e2e8f0/e2e8f0'); ?>" alt="<?php echo e($m->name); ?>" class="w-16 h-16 object-cover rounded-md">
                                </td>
                                <td class="px-4 py-3 font-medium dark:text-slate-200"><?php echo e($m->name); ?></td>
                                <td class="px-4 py-3 text-left dark:text-slate-300"><?php echo e($m->category->name ?? '-'); ?></td>
                                <td class="px-4 py-3 text-right dark:text-slate-300 whitespace-nowrap">Rp <?php echo e(number_format($m->price,0,',','.')); ?></td>
                                
                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    <?php if($m->is_prescription_only): ?>
                                        <span class="badge-rx">Perlu Resep</span>
                                    <?php else: ?>
                                        <span class="badge-ok">Bebas</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-center font-semibold dark:text-slate-200"><?php echo e($m->stock); ?></td>
                                <td class="px-4 py-3">
                                    <form method="POST" action="<?php echo e(route('admin.medicines.addStock', $m)); ?>" class="flex items-center gap-2">
                                        <?php echo csrf_field(); ?>
                                        <input type="number" name="qty" min="1" value="1" class="w-16 border rounded-xl px-3 py-2 dark:bg-slate-900 dark:border-slate-700">
                                        <button class="btn btn-primary px-3 py-2">Tambah Stok</button>
                                    </form>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="<?php echo e(route('admin.medicines.edit', $m)); ?>" class="btn btn-primary px-3 py-2">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            
                            <tr>
                                <td colspan="8" class="py-6 text-center text-gray-500 dark:text-slate-400">
                                    <?php if(request('q')): ?>
                                        Obat dengan nama "<?php echo e(request('q')); ?>" tidak ditemukan.
                                    <?php else: ?>
                                        Belum ada data obat.
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($medicines->hasPages()): ?>
                <div class="mt-4">
                    <?php echo e($medicines->links('vendor.pagination.tailwind')); ?>

                </div>
            <?php endif; ?>

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
<?php endif; ?>

<?php /**PATH C:\laragon\www\farmacheat\resources\views/admin/medicines/index.blade.php ENDPATH**/ ?>