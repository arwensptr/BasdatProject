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
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Detail Pesanan #<?php echo e($order->id); ?></h2>
            <div class="flex items-center gap-2">
                <a href="<?php echo e(route('shop.orders.index')); ?>" class="btn btn-white">← Semua Pesanan</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <?php if(session('success')): ?>
                <div class="p-4 bg-green-50 border-l-4 border-green-400 text-green-800 rounded-r-lg dark:bg-green-900/30 dark:border-green-600 dark:text-green-300">
                    <p><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300">
                    <p><?php echo e(session('error')); ?></p>
                </div>
            <?php endif; ?>

            
            <?php if(optional($order->prescription)->status === 'rejected' && optional($order->prescription)->note): ?>
                <div id="rejection-flash" class="hidden p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0 max-w-3xl mx-auto">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-semibold">Resep Anda ditolak oleh admin</p>
                            <p class="text-sm mt-1"><?php echo e($order->prescription->note); ?></p>
                        </div>
                        <button type="button" id="rejection-flash-close" class="text-red-700 hover:text-red-900">&times;</button>
                    </div>
                </div>
            <?php elseif($order->paymentProofs->where('status','rejected')->isNotEmpty()): ?>
                <?php $rejectedPay = $order->paymentProofs->where('status','rejected')->sortByDesc('id')->first(); ?>
                <?php if($rejectedPay && $rejectedPay->reviewer_note): ?>
                    <div id="rejection-flash" class="hidden p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0 max-w-3xl mx-auto">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="font-semibold">Bukti pembayaran Anda ditolak oleh admin</p>
                                <p class="text-sm mt-1"><?php echo e($rejectedPay->reviewer_note); ?></p>
                            </div>
                            <button type="button" id="rejection-flash-close" class="text-red-700 hover:text-red-900">&times;</button>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-slate-200 mb-2">Status & Aksi</h3>
                <div class="text-center sm:text-left sm:flex sm:items-center sm:justify-between p-4 bg-gray-50 dark:bg-slate-900 rounded-lg">
                    <div>
                        <p class="font-bold text-cyan-600 dark:text-cyan-400 capitalize text-xl mb-1"><?php echo e(str_replace('_', ' ', $order->status)); ?></p>
                        <p class="text-gray-600 dark:text-slate-400 text-sm">
                            <?php switch($order->status):
                                case ('awaiting_prescription_upload'): ?> Order ini membutuhkan resep. Silakan upload resep untuk melanjutkan. <?php break; ?>
                                <?php case ('prescription_rejected'): ?> Resep ditolak. Silakan upload ulang resep. <?php break; ?>
                                <?php case ('prescription_under_review'): ?> Resep sedang ditinjau admin. Mohon tunggu. <?php break; ?>
                                <?php case ('awaiting_payment'): ?> Silakan lakukan pembayaran dalam 24 jam, lalu upload bukti. <?php break; ?>
                                <?php case ('payment_rejected'): ?> Bukti pembayaran ditolak. Silakan upload ulang. <?php break; ?>
                                <?php case ('payment_under_review'): ?> Bukti pembayaran sedang ditinjau admin. Mohon tunggu. <?php break; ?>
                                <?php case ('paid'): ?> Pembayaran diterima. Pesanan akan segera diproses. <?php break; ?>
                                <?php case ('processing'): ?> Pesanan sedang disiapkan. <?php break; ?>
                                <?php case ('shipped'): ?> Pesanan telah dikirim. <?php break; ?>
                                <?php case ('delivered'): ?> Pesanan selesai. Terima kasih! <?php break; ?>
                                <?php case ('cancelled'): ?> Pesanan telah dibatalkan. <?php break; ?>
                                <?php default: ?> Status: <?php echo e($order->status); ?>

                            <?php endswitch; ?>
                        </p>
                    </div>
                    
                    <div class="mt-4 sm:mt-0 sm:ml-4 flex-shrink-0">
                        <?php if(optional($order->prescription)->status === 'rejected' && optional($order->prescription)->note): ?>
                            <div class="p-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 max-w-md">
                                <p class="font-semibold">Alasan penolakan resep:</p>
                                <p class="text-sm mt-1"><?php echo e($order->prescription->note); ?></p>
                            </div>
                        <?php elseif($order->paymentProofs->where('status','rejected')->isNotEmpty()): ?>
                            <?php
                                $rejectedPay = $order->paymentProofs->where('status','rejected')->sortByDesc('id')->first();
                            ?>
                            <?php if($rejectedPay && $rejectedPay->reviewer_note): ?>
                                <div class="p-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 max-w-md">
                                    <p class="font-semibold">Alasan penolakan pembayaran:</p>
                                    <p class="text-sm mt-1"><?php echo e($rejectedPay->reviewer_note); ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4 flex-shrink-0">
                        <?php $actionRoute = null; $actionText = ''; ?>
                        <?php switch($order->status):
                            case ('awaiting_prescription_upload'): ?> <?php $actionRoute = route('shop.prescriptions.create', $order); $actionText = 'Upload Resep'; ?> <?php break; ?>
                            <?php case ('prescription_rejected'): ?> <?php $actionRoute = route('shop.prescriptions.create', $order); $actionText = 'Upload Ulang Resep'; ?> <?php break; ?>
                            <?php case ('awaiting_payment'): ?> <?php $actionRoute = route('shop.payments.create', $order); $actionText = 'Upload Bukti Bayar'; ?> <?php break; ?>
                            <?php case ('payment_rejected'): ?> <?php $actionRoute = route('shop.payments.create', $order); $actionText = 'Upload Ulang Bukti'; ?> <?php break; ?>
                        <?php endswitch; ?>
                        <?php if($actionRoute): ?>
                            <a href="<?php echo e($actionRoute); ?>" class="btn btn-white"><?php echo e($actionText); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-4 border-b pb-3 dark:text-slate-200 dark:border-slate-700">Ringkasan Pesanan</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                    <div class="sm:col-span-2">
                        <dt class="font-medium text-gray-500 dark:text-slate-400">Penerima</dt>
                        <dd class="mt-1 text-gray-900 dark:text-slate-200"><?php echo e($order->recipient_name); ?> (<?php echo e($order->recipient_phone); ?>)</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="font-medium text-gray-500 dark:text-slate-400">Alamat Pengiriman</dt>
                        <dd class="mt-1 text-gray-900 dark:text-slate-200"><?php echo e($order->shipping_address); ?></dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500 dark:text-slate-400">Tanggal Pesan</dt>
                        <dd class="mt-1 text-gray-900 dark:text-slate-200"><?php echo e($order->created_at->format('d M Y H:i')); ?></dd>
                    </div>
                    <div>
                        <dt class="font-medium text-gray-500 dark:text-slate-400">Total Pembayaran</dt>
                        <dd class="mt-1 font-bold text-gray-900 dark:text-slate-200 text-base">Rp <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg overflow-hidden">
                <h3 class="text-xl font-semibold px-6 pt-6 pb-4 dark:text-slate-200">Item yang Dipesan</h3>
                <table class="min-w-full w-full divide-y divide-gray-200 dark:divide-slate-700">
                    <thead class="bg-gray-50 dark:bg-slate-900">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Obat</th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Qty</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Harga Satuan</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-slate-400 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-6 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-slate-200"><?php echo e($it->medicine->name ?? 'Unknown'); ?></td>
                                <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 text-center"><?php echo e($it->qty); ?></td>
                                <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400 text-right">Rp <?php echo e(number_format($it->unit_price, 0, ',', '.')); ?></td>
                                <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-800 dark:text-slate-200 font-semibold text-right">Rp <?php echo e(number_format($it->subtotal, 0, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const flash = document.getElementById('rejection-flash');
            const closeBtn = document.getElementById('rejection-flash-close');
            if (!flash) return;
            // animate in
            flash.classList.remove('hidden');
            void flash.offsetWidth;
            flash.classList.remove('-translate-y-2','opacity-0');
            // auto-hide after 6s
            clearTimeout(flash._hideTimeout);
            flash._hideTimeout = setTimeout(()=>{
                flash.classList.add('-translate-y-2','opacity-0');
                setTimeout(()=> flash.classList.add('hidden'), 300);
            }, 6000);
            if (closeBtn) closeBtn.addEventListener('click', function(){
                clearTimeout(flash._hideTimeout);
                flash.classList.add('-translate-y-2','opacity-0');
                setTimeout(()=> flash.classList.add('hidden'), 300);
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
<?php endif; ?>
<?php /**PATH C:\laragon\www\farmacheat\resources\views/shop/order_show.blade.php ENDPATH**/ ?>