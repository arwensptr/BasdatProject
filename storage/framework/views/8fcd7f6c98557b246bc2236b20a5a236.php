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
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Upload Resep — Pesanan #<?php echo e($order->id); ?></h2>
            <a href="<?php echo e(route('shop.orders.show',$order)); ?>" class="btn btn-white">← Kembali ke Pesanan</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-lg dark:bg-amber-900/30 dark:border-amber-600 dark:text-amber-300">
                <p class="font-bold">Unggah File Resep Anda</p>
                <p class="text-sm">Unggah 1-3 file (JPG, PNG, atau PDF). Setelah terkirim, status pesanan akan ditinjau oleh admin kami.</p>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg">
                <form method="POST" action="<?php echo e(route('shop.prescriptions.store',$order)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="p-8 space-y-6">
                        <div>
                            <label for="file-upload" class="btn btn-white w-full h-32 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-700">
                                <span class="flex items-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span class="font-medium text-gray-600 dark:text-slate-400">
                                        Seret & lepas file, atau
                                        <span class="text-cyan-600 dark:text-cyan-400 underline">klik untuk memilih</span>
                                    </span>
                                </span>
                                <span id="file-names-display" class="text-sm text-gray-500 dark:text-slate-500 mt-2"></span>
                            </label>
                            <input id="file-upload" type="file" name="files[]" multiple class="sr-only" required>
                            <?php $__errorArgs = ['files.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Catatan (opsional)</label>
                            <textarea name="note" id="note" rows="3" class="w-full rounded-lg border-gray-200 bg-gray-50 text-sm shadow-sm focus:border-cyan-500 focus:ring-cyan-500" placeholder="Tinggalkan catatan untuk apoteker jika ada..."><?php echo e(old('note',$prescription->note ?? '')); ?></textarea>
                            <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-slate-900 px-6 py-6 flex items-center justify-end gap-4 rounded-b-lg">
                        <a href="<?php echo e(route('shop.orders.show',$order)); ?>" class="btn btn-white">Batal</a>
                        <button type="submit" class="btn btn-primary">Kirim Resep</button>
                    </div>
                </form>
            </div>

            <?php if(!empty($prescription) && !empty($prescription->attachments)): ?>
                <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4 border-b pb-3 dark:text-slate-200 dark:border-slate-700">Lampiran Terkirim</h3>
                    <ul class="space-y-2">
                        <?php $__currentLoopData = (array) ($prescription->attachments ?? []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <a href="<?php echo e(asset('storage/'.$p)); ?>" target="_blank" class="flex items-center gap-2 text-cyan-700 dark:text-cyan-400 hover:underline">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" /></svg>
                                    <span><?php echo e(basename($p)); ?></span>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('file-upload');
        const fileNamesDisplay = document.getElementById('file-names-display');
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                let fileNames = Array.from(this.files).map(file => file.name).join(', ');
                fileNamesDisplay.textContent = fileNames;
            } else {
                fileNamesDisplay.textContent = '';
            }
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\farmacheat\resources\views/shop/prescriptions/create.blade.php ENDPATH**/ ?>