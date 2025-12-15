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
      <h2 class="font-display text-3xl text-brand-800">Kategori Obat</h2>
      <form method="GET" class="flex gap-2">
        <input type="hidden" name="category" value="<?php echo e(request('category')); ?>">
        <input name="q" value="<?php echo e(request('q')); ?>" placeholder="Cari obat..."
               class="rounded-full border-gray-200 bg-white/70 px-4 py-2 focus:ring-brand-300 focus:border-brand-400">
        <button class="btn btn-primary">Cari</button>
      </form>
    </div>
   <?php $__env->endSlot(); ?>

  <div class="grid md:grid-cols-[18rem_1fr] gap-6">
    <?php echo $__env->make('shop.partials.category-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="section">
      <?php if($activeCategory): ?>
        <div class="card pad">
          <div class="text-sm text-gray-600"><?php echo e($activeCategory->parent?->name ?? 'Kategori'); ?></div>
          <div class="text-2xl font-display"><?php echo e($activeCategory->name); ?></div>
        </div>
      <?php endif; ?>

      <?php if(session('success')): ?> <div class="card pad text-emerald-700"><?php echo e(session('success')); ?></div> <?php endif; ?>
      <?php if(session('error')): ?>   <div class="card pad text-red-700"><?php echo e(session('error')); ?></div> <?php endif; ?>

      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php $__empty_1 = true; $__currentLoopData = $medicines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        
          <div class="card overflow-hidden flex flex-col justify-between h-full">
            
            <a href="<?php echo e(route('shop.product.show', $m)); ?>">
                <img src="<?php echo e($m->image ? asset('storage/' . $m->image) : 'https://via.placeholder.com/300'); ?>" 
                    alt="<?php echo e($m->name); ?>" 
                    class="w-full h-40 object-contain p-4">
            </a>

            
            <div class="pad">
                
                <div>
                    <div class="text-lg font-semibold"><?php echo e($m->name); ?></div>
                    <div class="text-sm text-gray-600 mb-2"><?php echo e($m->category->name ?? '-'); ?></div>
                    <div class="mb-2">Rp <?php echo e(number_format($m->price,0,',','.')); ?></div>
                    <?php if($m->is_prescription_only): ?>
                        <span class="badge-rx">Perlu Resep</span>
                    <?php else: ?>
                        <span class="badge-ok">Tanpa Resep</span>
                    <?php endif; ?>
                </div>

                
                <div class="mt-4 flex items-center gap-2">
                    <a class="text-brand-700 underline" href="<?php echo e(route('shop.product.show', $m)); ?>">Detail</a>
                    
                    
                    <?php if($m->stock > 0): ?>
                        <form method="POST" action="<?php echo e(route('shop.cart.add')); ?>" class="ml-auto flex gap-2 items-center">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="slug" value="<?php echo e($m->slug); ?>">
                            <input type="number" name="qty" value="1" min="1" max="<?php echo e($m->stock); ?>" class="w-16 border rounded-full px-3 py-1 text-center">
                            <button class="btn btn-primary">Tambah</button>
                        </form>
                    <?php else: ?>
                        
                        <div class="ml-auto">
                            <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-500 text-sm font-medium border border-gray-200">
                                Stok Habis
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="col-span-full card pad">Tidak ada obat.</div>
        <?php endif; ?>
      </div>

      <div class="mt-8 w-full">
        <?php echo e($medicines->links('vendor.pagination.tailwind')); ?>

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
<?php endif; ?>
<?php /**PATH C:\laragon\www\farmacheat\resources\views/shop/catalog.blade.php ENDPATH**/ ?>