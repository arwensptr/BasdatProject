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
   <?php $__env->slot('header', null, []); ?> <h2 class="text-2xl font-semibold">Edit Obat: <?php echo e($medicine->name); ?></h2> <?php $__env->endSlot(); ?>

  <div class="admin-grid section">
    <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <div class="section">
      <div class="card pad">
        
        <form method="POST" action="<?php echo e(route('admin.medicines.update', $medicine)); ?>" class="space-y-5" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PATCH'); ?>

          <div>
            <label class="block text-sm font-medium">Nama Obat</label>
            
            <input name="name" type="text" value="<?php echo e(old('name', $medicine->name)); ?>" required
                   class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('name'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('name')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium">Kategori</label>
              <select name="category_id" class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
                <option value="">— Tanpa kategori —</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                  <option value="<?php echo e($c->id); ?>" <?php if(old('category_id', $medicine->category_id) == $c->id): echo 'selected'; endif; ?>><?php echo e($c->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium">Harga</label>
              <input name="price" type="number" step="0.01" min="0" value="<?php echo e(old('price', $medicine->price)); ?>" required
                     class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
              <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('price'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('price')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
            </div>
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <label class="inline-flex items-center gap-2">
              
              <input type="checkbox" name="is_prescription_only" value="1"
                     class="rounded border-gray-300 text-brand-600 focus:ring-brand-400"
                     <?php if(old('is_prescription_only', $medicine->is_prescription_only)): echo 'checked'; endif; ?>>
              <span>Perlu Resep</span>
            </label>

            <div>
              <label class="block text-sm font-medium">Stok</label>
              
              <input name="stock" type="number" min="0" value="<?php echo e(old('stock', $medicine->stock)); ?>" required
                     class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300">
              <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('stock'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('stock')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium">Deskripsi (opsional)</label>
            <textarea name="description" rows="4"
              class="mt-1 w-full rounded-xl border-gray-300 focus:border-brand-400 focus:ring-brand-300"><?php echo e(old('description', $medicine->description)); ?></textarea>
          </div>

          
          <div>
            <label class="block text-sm font-medium">Gambar Obat</label>
            <?php if($medicine->image): ?>
              <img src="<?php echo e(asset('storage/' . $medicine->image)); ?>" alt="Gambar saat ini" class="w-32 h-32 object-cover rounded-lg my-2">
                <p class="text-xs text-gray-500 mb-2">Unggah gambar baru untuk mengganti gambar di atas.</p>
              <?php endif; ?>
              <input name="image" type="file" ... >
          </div>

          <div class="flex items-center justify-end gap-2">
            <a href="<?php echo e(route('admin.medicines.index')); ?>" class="btn btn-white">Batal</a>
            <button class="btn btn-primary">Update Obat</button>
          </div>
        </form>
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
<?php endif; ?><?php /**PATH C:\laragon\www\farmacheat\resources\views/admin/medicines/edit.blade.php ENDPATH**/ ?>