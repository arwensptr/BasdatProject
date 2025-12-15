
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
      <h2 class="text-2xl font-semibold">Pesanan Saya</h2>
      <a href="<?php echo e(route('shop.index')); ?>" class="btn btn-white px-3 py-1">← Katalog</a>
    </div>
   <?php $__env->endSlot(); ?>

  <div class="section">
    
    <div class="card pad">
      <form method="GET" class="flex flex-wrap items-center gap-2">
        <?php ($status = request('status')); ?>
        <label class="text-sm text-gray-600">Filter:</label>

        <select name="status" class="rounded-lg border-gray-300 focus:border-brand-400 focus:ring-brand-300">
          <option value="" <?php echo e($status==='' || $status===null ? 'selected' : ''); ?>>Semua</option>
          <option value="open"    <?php echo e($status==='open'    ? 'selected' : ''); ?>>Masih Berjalan</option>
          <option value="closed"  <?php echo e($status==='closed'  ? 'selected' : ''); ?>>Selesai/Dibatalkan</option>

          <?php $__currentLoopData = [
            'awaiting_prescription_upload',
            'prescription_under_review',
            'prescription_rejected',
            'awaiting_payment',
            'payment_under_review',
            'payment_rejected',
            'paid',
            'processing',
            'shipped',
            'delivered',
            'cancelled'
          ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($s); ?>" <?php echo e($status===$s ? 'selected' : ''); ?>><?php echo e($s); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button class="btn btn-primary">Terapkan</button>

        <?php if($status): ?>
          <a href="<?php echo e(route('shop.orders.index')); ?>" class="text-sm text-brand-700 underline">Reset</a>
        <?php endif; ?>
      </form>
    </div>

    
    <div class="table-wrap">
      <table class="min-w-full text-sm table-ui">
        <thead>
          <tr>
            <th>Order</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th class="text-right">Total</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody class="divide-y">
          <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="hover:bg-brand-50/30">
              <td>#<?php echo e($o->id); ?></td>
              <td><?php echo e($o->created_at->format('d M Y H:i')); ?></td>
              <td><?php echo e($o->status); ?></td>
              <td class="text-left">Rp <?php echo e(number_format($o->total_amount,0,',','.')); ?></td>
              <td>
                <a class="btn btn-white px-3 py-1" href="<?php echo e(route('shop.orders.show', $o)); ?>">Detail</a>
              </td>
            </tr>
            
            <?php if(optional($o->prescription)->status === 'rejected' && optional($o->prescription)->note): ?>
              <tr>
                <td colspan="5" class="px-6 py-3">
                  <div id="order-reject-<?php echo e($o->id); ?>" class="order-reject hidden p-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0">
                    <div class="flex items-start justify-between w-full">
                      <div class="flex-1">
                        <p class="font-semibold">Resep ditolak untuk order #<?php echo e($o->id); ?></p>
                        <p class="text-sm mt-1"><?php echo e($o->prescription->note); ?></p>
                      </div>
                      <button type="button" data-target="#order-reject-<?php echo e($o->id); ?>" class="order-reject-close ml-4 text-red-700 hover:text-red-900">&times;</button>
                    </div>
                  </div>
                </td>
              </tr>
            <?php elseif($o->paymentProofs->where('status','rejected')->isNotEmpty()): ?>
              <?php ($rp = $o->paymentProofs->where('status','rejected')->sortByDesc('id')->first()); ?>
              <?php if($rp && $rp->reviewer_note): ?>
                <tr>
                  <td colspan="5" class="px-6 py-3">
                    <div id="order-reject-<?php echo e($o->id); ?>" class="order-reject hidden p-3 bg-red-50 border-l-4 border-red-400 text-red-800 rounded-r-lg dark:bg-red-900/30 dark:border-red-600 dark:text-red-300 transition-all duration-300 transform -translate-y-2 opacity-0">
                      <div class="flex items-start justify-between w-full">
                        <div class="flex-1">
                          <p class="font-semibold">Pembayaran ditolak untuk order #<?php echo e($o->id); ?></p>
                          <p class="text-sm mt-1"><?php echo e($rp->reviewer_note); ?></p>
                        </div>
                        <button type="button" data-target="#order-reject-<?php echo e($o->id); ?>" class="order-reject-close ml-4 text-red-700 hover:text-red-900">&times;</button>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endif; ?>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
              <td colspan="5" class="py-6 text-center text-gray-500">Tidak ada pesanan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div><?php echo e($orders->links()); ?></div>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    // reveal rejection flashes then auto-hide after a delay
    document.querySelectorAll('.order-reject').forEach(function(el){
      if (!el) return;
      el.classList.remove('hidden');
      void el.offsetWidth; // force reflow
      el.classList.remove('-translate-y-2','opacity-0');
      clearTimeout(el._hideTimeout);
      el._hideTimeout = setTimeout(()=>{
        el.classList.add('-translate-y-2','opacity-0');
        setTimeout(()=> el.classList.add('hidden'), 300);
      }, 6000);
    });

    document.querySelectorAll('.order-reject-close').forEach(function(btn){
      btn.addEventListener('click', function(){
        const selector = this.getAttribute('data-target');
        const target = document.querySelector(selector);
        if (!target) return;
        clearTimeout(target._hideTimeout);
        target.classList.add('-translate-y-2','opacity-0');
        setTimeout(()=> target.classList.add('hidden'), 300);
      });
    });
  });
</script>
</div>
<?php $__env->stopPush(); ?>
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
<?php /**PATH C:\laragon\www\farmacheat\resources\views/shop/orders/index.blade.php ENDPATH**/ ?>