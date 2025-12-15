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
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Checkout</h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('shop.cart.index')); ?>" class="btn btn-white">← Kembali ke Keranjang</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="space-y-6 pt-6">
            <?php if($hasRx): ?>
                <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-lg dark:bg-amber-900/30 dark:border-amber-600 dark:text-amber-300">
                    <p class="font-bold">Perhatian: Diperlukan Resep Dokter</p>
                    <p class="text-sm">Pesanan ini mengandung obat yang memerlukan resep. Anda harus mengunggah resep setelah membuat pesanan agar dapat kami proses lebih lanjut.</p>
                </div>
            <?php endif; ?>

            <form id="checkout-form" method="POST" action="<?php echo e(route('shop.checkout.place')); ?>" class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                <?php echo csrf_field(); ?>

                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-6">
                        <h3 class="text-xl font-semibold mb-6 border-b pb-3 dark:text-slate-200 dark:border-slate-700">Detail Pengiriman</h3>
                        <div class="space-y-6">

                            <div>
                                <label for="recipient_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Nama Penerima</label>
                                
                                <div class="flex items-center gap-3 rounded-lg bg-gray-50 px-4 py-3 shadow-sm dark:bg-transparent dark:border dark:border-slate-700 focus-within:ring-2 focus-within:ring-cyan-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-slate-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                    <input type="text" id="recipient_name" name="recipient_name" class="w-full text-sm border-none focus:ring-0 rounded-lg p-1" required value="<?php echo e(old('recipient_name')); ?>" placeholder="Masukkan nama lengkap">
                                </div>
                                <?php $__errorArgs = ['recipient_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="recipient_phone" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">No. HP Penerima</label>
                                
                                <div class="flex items-center gap-3 rounded-lg bg-gray-50 px-4 py-3 shadow-sm dark:bg-transparent dark:border dark:border-slate-700 focus-within:ring-2 focus-within:ring-cyan-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-slate-500" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                                    <input type="text" id="recipient_phone" name="recipient_phone" class="w-full text-sm border-none focus:ring-0 rounded-lg p-1" required value="<?php echo e(old('recipient_phone')); ?>" placeholder="Contoh: 08123456789">
                                </div>
                                <?php $__errorArgs = ['recipient_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Alamat Pengiriman</label>
                                
                                <div class="flex items-start gap-3 rounded-lg bg-gray-50 px-4 py-3 shadow-sm dark:bg-transparent dark:border dark:border-slate-700 focus-within:ring-2 focus-within:ring-cyan-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 dark:text-slate-500 mt-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg>
                                    <textarea id="shipping_address" name="shipping_address" class="w-full bg-transparent p-0 text-sm border-none focus:ring-0" rows="3" required placeholder="Masukkan alamat lengkap, kecamatan, dan kota"><?php echo e(old('shipping_address')); ?></textarea>
                                </div>
                                <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-red-600 text-sm mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-6 space-y-4">
                        <h3 class="text-xl font-semibold mb-4 border-b pb-3 dark:text-slate-200 dark:border-slate-700">Ringkasan Pesanan</h3>
                        <div class="space-y-3 max-h-60 overflow-y-auto pr-2">
                            <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex justify-between items-center text-sm">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-slate-200"><?php echo e($it['name']); ?></p>
                                    <p class="text-gray-500 dark:text-slate-400">Qty: <?php echo e($it['qty']); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold dark:text-slate-200">Rp <?php echo e(number_format($it['price']*$it['qty'],0,',','.')); ?></p>
                                    <?php if($it['is_rx']): ?> <span class="text-xs bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-300 px-2 py-0.5 rounded-full font-medium">Resep</span> <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="border-t pt-4 flex justify-between items-center text-lg dark:border-slate-700">
                            <span class="font-semibold text-gray-900 dark:text-slate-200">Total Pembayaran</span>
                            <span class="font-bold text-cyan-600 dark:text-cyan-400">Rp <?php echo e(number_format($total,0,',','.')); ?></span>
                        </div>
                        <button type="submit" form="checkout-form" class="btn btn-white w-full">Buat Pesanan</button>
                    </div>
                </div>
            </form>
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

<?php /**PATH C:\laragon\www\farmacheat\resources\views/shop/checkout.blade.php ENDPATH**/ ?>