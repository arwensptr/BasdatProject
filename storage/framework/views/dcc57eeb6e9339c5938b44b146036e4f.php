<aside class="card pad w-full md:w-72">
    <div class="font-semibold text-lg mb-3 dark:text-white">Kategori Obat</div>
    <div class="space-y-2">
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <details <?php echo e((isset($activeCategory) && ($activeCategory->id === $g->id || $activeCategory->parent_id === $g->id)) ? 'open' : ''); ?>>
                
                <summary class="cursor-pointer px-2 py-2 rounded-lg hover:bg-brand-50 font-medium text-slate-700 dark:text-slate-300 dark:hover:bg-slate-700">
                    <?php echo e($g->name); ?>

                </summary>

                <nav class="mt-1 ml-3 flex flex-col">
                    
                    <a href="<?php echo e(route('shop.index', array_filter(['category'=>$g->slug,'q'=>request('q')]))); ?>"
                       class="py-1 text-sm <?php echo e(request('category')===$g->slug ? 'text-brand-700 font-semibold dark:text-brand-400' : 'text-gray-700 hover:text-brand-700 dark:text-slate-400 dark:hover:text-brand-400'); ?>">
                       Semua di <?php echo e($g->name); ?>

                    </a>
                    <?php $__currentLoopData = $g->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <a href="<?php echo e(route('shop.index', array_filter(['category'=>$child->slug,'q'=>request('q')]))); ?>"
                           class="py-1 text-sm <?php echo e(request('category')===$child->slug ? 'text-brand-700 font-semibold dark:text-brand-400' : 'text-gray-700 hover:text-brand-700 dark:text-slate-400 dark:hover:text-brand-400'); ?>">
                           <?php echo e($child->name); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>
            </details>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</aside>
<?php /**PATH C:\laragon\www\farmacheat\resources\views/shop/partials/category-sidebar.blade.php ENDPATH**/ ?>