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
        <h2 class="font-display text-2xl text-slate-800 dark:text-white font-bold">Manajemen Order</h2>
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

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-500 dark:text-slate-400 font-semibold uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4 whitespace-nowrap">Order ID</th>
                                <th class="px-6 py-4 whitespace-nowrap">Customer</th>
                                <th class="px-6 py-4 whitespace-nowrap">Status</th>
                                <th class="px-6 py-4 whitespace-nowrap text-right">Total</th>
                                <th class="px-6 py-4 whitespace-nowrap">Pengiriman</th>
                                <th class="px-6 py-4">Update Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                    
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white whitespace-nowrap">
                                        #<?php echo e($o->id); ?> <span class="text-slate-400 mx-1">|</span> <span class="text-xs text-slate-500"><?php echo e($o->created_at->format('d/m/y H:i')); ?></span>
                                    </td>

                                    
                                    <td class="px-6 py-4 dark:text-slate-300 whitespace-nowrap">
                                        <?php echo e($o->user->name); ?>

                                    </td>

                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $o->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($o->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
                                    </td>

                                    
                                    <td class="px-6 py-4 text-right font-bold text-slate-700 dark:text-slate-200 whitespace-nowrap">
                                        Rp <?php echo e(number_format($o->total_amount, 0, ',', '.')); ?>

                                    </td>

                                    
                                    <td class="px-6 py-4 dark:text-slate-300 whitespace-nowrap">
                                        <?php if($o->shipment): ?>
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 text-xs font-bold border border-blue-100 dark:border-blue-800">
                                                    <?php echo e($o->shipment->courier_name); ?>

                                                </span>
                                                <span class="text-xs font-mono text-slate-600 dark:text-slate-400">
                                                    <?php echo e($o->shipment->tracking_number); ?>

                                                </span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-slate-400 text-xl leading-none">&minus;</span>
                                        <?php endif; ?>
                                    </td>

                                    
                                    <td class="px-6 py-4">
                                        <form method="POST" action="<?php echo e(route('admin.orders.updateStatus', $o)); ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="flex flex-col gap-2 w-full max-w-[280px]">
                                                
                                                
                                                <div class="flex gap-2">
                                                    <select name="action" class="flex-1 rounded-lg border-slate-300 dark:border-slate-600 text-xs py-1.5 px-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white">
                                                        <option value="processing" <?php echo e($o->status == 'processing' ? 'selected' : ''); ?>>Processing</option>
                                                        <option value="ship" <?php echo e($o->status == 'shipped' ? 'selected' : ''); ?>>Shipped</option>
                                                        <option value="deliver" <?php echo e($o->status == 'delivered' ? 'selected' : ''); ?>>Delivered</option>
                                                        <option value="cancel" <?php echo e($o->status == 'cancelled' ? 'selected' : ''); ?>>Cancel</option>
                                                    </select>
                                                    <button class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                                                        Update
                                                    </button>
                                                </div>

                                                
                                                <div class="flex gap-2">
                                                    <select name="courier_name" class="w-1/3 rounded-lg border-slate-300 dark:border-slate-600 text-[11px] py-1.5 px-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white">
                                                        <option value="" disabled <?php echo e(!$o->shipment ? 'selected' : ''); ?>>Kurir</option>
                                                        <?php $couriers = ['JNE', 'TiKi', 'SiCepat', 'J&T', 'Pos', 'GoSend', 'Grab']; ?>
                                                        <?php $__currentLoopData = $couriers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courier): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($courier); ?>" <?php echo e(($o->shipment->courier_name ?? '') == $courier ? 'selected' : ''); ?>><?php echo e($courier); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    <input type="text" name="tracking_number" placeholder="Input Resi..." 
                                                           class="flex-1 rounded-lg border-slate-300 dark:border-slate-600 text-[11px] py-1.5 px-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-800 dark:text-white"
                                                           value="<?php echo e($o->shipment->tracking_number ?? ''); ?>">
                                                </div>

                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <?php echo e($orders->links('vendor.pagination.tailwind')); ?>

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
<?php endif; ?><?php /**PATH C:\laragon\www\farmacheat\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>