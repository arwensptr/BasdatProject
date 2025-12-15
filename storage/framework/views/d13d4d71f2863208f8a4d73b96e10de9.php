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
        <h2 class="font-display text-2xl text-brand-800 dark:text-brand-300">Resep — Order #<?php echo e($prescription->order_id); ?></h2>
     <?php $__env->endSlot(); ?>

    <div class="admin-grid section">
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="section">
            <div class="grid lg:grid-cols-2 gap-6">
                <div class="card pad">
                    <div class="font-semibold mb-3 dark:text-white">Informasi</div>
                    <div class="text-sm space-y-2 dark:text-slate-300">
                        <div>Pemilik: <b><?php echo e($prescription->user->name); ?></b> <span class="text-gray-500 dark:text-slate-400">(<?php echo e($prescription->user->email); ?>)</span></div>
                        <div>Status Resep: <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $prescription->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prescription->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></div>
                        <div>Status Order: <?php if (isset($component)) { $__componentOriginal8c81617a70e11bcf247c4db924ab1b62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.status-badge','data' => ['status' => $prescription->order->status]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('status-badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($prescription->order->status)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $attributes = $__attributesOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__attributesOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62)): ?>
<?php $component = $__componentOriginal8c81617a70e11bcf247c4db924ab1b62; ?>
<?php unset($__componentOriginal8c81617a70e11bcf247c4db924ab1b62); ?>
<?php endif; ?></div>
                        <?php if($prescription->note): ?>
                            <div class="p-3 bg-gray-50 rounded-xl dark:bg-slate-700 dark:text-slate-300">Catatan: <?php echo e($prescription->note); ?></div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card pad">
                    <div class="font-semibold mb-3 dark:text-white">Lampiran</div>
                    <ul class="list-disc ml-6 text-sm space-y-1">
                        <?php $__empty_1 = true; $__currentLoopData = ($prescription->attachments ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li>
                                <a class="btn btn-primary" href="<?php echo e(asset('storage/'.$path)); ?>" target="_blank">Buka Resep</a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="text-gray-500 dark:text-slate-400">Tidak ada lampiran.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="card pad">
                <div class="font-semibold mb-3 dark:text-white">Item pada Order</div>
                <div class="table-wrap">
                    <table class="min-w-full text-sm table-ui">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-gray-600 dark:text-slate-300">Obat</th>
                                <th class="px-4 py-3 text-center text-gray-600 dark:text-slate-300">Qty</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y dark:divide-slate-700">
                            <?php $__currentLoopData = $prescription->order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-4 py-3 dark:text-slate-300"><?php echo e($it->medicine->name ?? 'Unknown'); ?></td>
                                    <td class="px-4 py-3 text-center dark:text-slate-300"><?php echo e($it->qty); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card pad">
                <div class="font-semibold mb-3 dark:text-white">Aksi</div>
                <div class="flex flex-wrap gap-3">
                    <form method="POST" action="<?php echo e(route('admin.prescriptions.approve',$prescription)); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="note" placeholder="Catatan (opsional)" class="border rounded-xl px-3 py-2 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400">
                        <button class="btn btn-primary px-5">Approve</button>
                    </form>

                    <form method="POST" action="<?php echo e(route('admin.prescriptions.reject',$prescription)); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="note" placeholder="Alasan tolak (wajib)" class="border rounded-xl px-3 py-2 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-slate-400" required>
                        <button class="btn px-5 bg-red-600 text-white hover:bg-red-700">Reject</button>
                    </form>
                </div>
            </div>

            <a class="text-brand-700 underline dark:text-brand-400" href="<?php echo e(route('admin.prescriptions.index')); ?>">← Kembali</a>
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
<?php /**PATH C:\laragon\www\farmacheat\resources\views/admin/prescriptions/show.blade.php ENDPATH**/ ?>