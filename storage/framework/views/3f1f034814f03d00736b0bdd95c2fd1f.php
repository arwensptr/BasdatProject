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
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-slate-200">Keranjang Belanja</h2>
            <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-white">← Lanjut Belanja</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                
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
                
                <div id="client-error" class="hidden p-4 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0">
                    <div class="flex items-start justify-between gap-4">
                        <p id="client-error-text" class="flex-1"></p>
                        <button type="button" id="client-error-close" class="text-red-600 hover:text-red-800">&times;</button>
                    </div>
                </div>

                <?php if(count($items) === 0): ?>
                    
                    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg p-8 text-center">
                        <h3 class="text-xl font-semibold text-gray-700 dark:text-slate-300">Keranjang Anda Kosong</h3>
                        <p class="text-gray-500 dark:text-slate-400 mt-2">Sepertinya Anda belum menambahkan obat apapun ke keranjang.</p>
                        <a href="<?php echo e(route('shop.index')); ?>" class="mt-6 inline-block px-6 py-2 bg-cyan-500 text-white font-bold rounded-lg shadow-md hover:bg-cyan-600 transition-colors">
                            Mulai Belanja
                        </a>
                    </div>
                <?php else: ?>
                    
                    <?php if($hasRx): ?>
                        <div class="p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-800 rounded-r-lg dark:bg-amber-900/30 dark:border-amber-600 dark:text-amber-300">
                            <p class="font-bold">Mengandung Obat Resep</p>
                            <p class="text-sm">Pesanan akan diproses setelah resep dokter disetujui.</p>
                        </div>
                    <?php endif; ?>

                    <div class="bg-white dark:bg-slate-800 shadow-lg rounded-lg overflow-hidden">
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                                <thead class="bg-gray-50 dark:bg-slate-900">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Obat</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Kuantitas</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Harga Satuan</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Subtotal</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Hapus</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $it): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr data-stock="<?php echo e($it['stock'] ?? 0); ?>">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-slate-200">
                                                    <a href="<?php echo e(route('shop.product.show',$it['slug'])); ?>" class="text-cyan-600 hover:text-cyan-800 dark:text-cyan-400 dark:hover:text-cyan-300"><?php echo e($it['name']); ?></a>
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-slate-400 mt-1">Stok: <?php echo e($it['stock'] ?? 0); ?></div>
                                                <?php if($it['is_rx']): ?>
                                                    <div class="text-xs text-red-600 dark:text-red-400">Perlu Resep</div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form method="POST" action="<?php echo e(route('shop.cart.update')); ?>" class="flex items-center gap-2 cart-update-form">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?php echo e($it['id']); ?>">
                                                    <input type="number" name="qty" value="<?php echo e($it['qty']); ?>" min="1" class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-cyan-500 focus:border-cyan-500 text-sm cart-qty-input">
                                                    <button class="btn btn-white">Update</button>
                                                </form>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-slate-400">Rp <?php echo e(number_format($it['price'],0,',','.')); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800 dark:text-slate-200">Rp <?php echo e(number_format($it['price']*$it['qty'],0,',','.')); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form method="POST" action="<?php echo e(route('shop.cart.remove')); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="id" value="<?php echo e($it['id']); ?>">
                                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs font-semibold rounded-md hover:bg-red-700 transition-colors">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-gray-50 dark:bg-slate-900 px-6 py-6 flex items-center justify-between">
                            <form method="POST" action="<?php echo e(route('shop.cart.clear')); ?>">
                                <?php echo csrf_field(); ?>
                                <button class="btn btn-white">Kosongkan Keranjang</button>
                            </form>
                            <div class="text-right">
                                <div class="text-sm text-gray-600 dark:text-slate-400">Total Belanja</div>
                                <div class="text-xl font-bold text-gray-900 dark:text-slate-200 mb-4">Rp <?php echo e(number_format($total,0,',','.')); ?></div>
                                <a href="<?php echo e(route('shop.checkout.show')); ?>" id="checkout-button" class="btn btn-white">Lanjut ke Checkout</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
        // Client-side validation: pastikan qty tidak melebihi stock.
        document.addEventListener('DOMContentLoaded', function () {
            const checkoutBtn = document.getElementById('checkout-button');
            const qtyInputs = document.querySelectorAll('.cart-qty-input');

            function validateAll() {
                const rows = document.querySelectorAll('tr[data-stock]');
                for (const row of rows) {
                    const stock = parseInt(row.getAttribute('data-stock')||'0', 10);
                    const input = row.querySelector('.cart-qty-input');
                    if (!input) continue;
                    const val = parseInt(input.value||'0', 10);
                    if (val > stock) {
                        return {ok:false, stock, val, row};
                    }
                }
                return {ok:true};
            }

            function showClientError(msg) {
                const el = document.getElementById('client-error');
                const txt = document.getElementById('client-error-text');
                if (!el || !txt) return;
                txt.textContent = msg;
                // show with animation
                el.classList.remove('hidden');
                // force reflow then remove opacity/translate
                void el.offsetWidth;
                el.classList.remove('-translate-y-2','opacity-0');
                // auto-hide after 5s
                clearTimeout(el._hideTimeout);
                el._hideTimeout = setTimeout(() => {
                    el.classList.add('-translate-y-2','opacity-0');
                    setTimeout(()=> el.classList.add('hidden'), 300);
                }, 5000);
                el.scrollIntoView({behavior: 'smooth', block: 'center'});
            }

            // Blok update form submission jika qty > stock
            document.querySelectorAll('form.cart-update-form').forEach(f=>{
                f.addEventListener('submit', function (e) {
                    const row = this.closest('tr[data-stock]');
                    if (!row) return;
                    const stock = parseInt(row.getAttribute('data-stock')||'0',10);
                    const input = row.querySelector('.cart-qty-input');
                    const val = parseInt(input.value||'0',10);
                    if (val > stock) {
                        e.preventDefault();
                        showClientError('maaf stock tidak mencukupi');
                    }
                })
            });

            // Prevent checkout if any item exceeds stock
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', function (e) {
                    const res = validateAll();
                    if (!res.ok) {
                            e.preventDefault();
                            showClientError('maaf stock tidak mencukupi');
                        }
                });
            }

                // close button for client error
                const clientClose = document.getElementById('client-error-close');
                if (clientClose) clientClose.addEventListener('click', function(){
                    const el = document.getElementById('client-error');
                    if (!el) return;
                    clearTimeout(el._hideTimeout);
                    el.classList.add('-translate-y-2','opacity-0');
                    setTimeout(()=> el.classList.add('hidden'), 300);
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
<?php /**PATH C:\laragon\www\farmacheat\resources\views/shop/cart.blade.php ENDPATH**/ ?>