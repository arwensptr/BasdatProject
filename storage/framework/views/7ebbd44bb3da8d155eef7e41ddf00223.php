<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $map = [
        'awaiting_prescription_upload' => 'bg-yellow-50 text-yellow-800 ring-1 ring-yellow-200',
        'prescription_under_review'    => 'bg-yellow-50 text-yellow-800 ring-1 ring-yellow-200',
        'prescription_rejected'        => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        'approved'                      => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',

        'awaiting_payment'             => 'bg-blue-50 text-blue-700 ring-1 ring-blue-200',
        'payment_under_review'         => 'bg-yellow-50 text-yellow-800 ring-1 ring-yellow-200',
        'payment_rejected'             => 'bg-red-50 text-red-700 ring-1 ring-red-200',
        'paid'                         => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',

        'processing'                   => 'bg-sky-50 text-sky-700 ring-1 ring-sky-200',
        'shipped'                      => 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200',
        'delivered'                    => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200',
        'cancelled'                    => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',
        'default'                      => 'bg-gray-100 text-gray-700 ring-1 ring-gray-200',
    ];
    $cls = $map[$status] ?? $map['default'];
?>

<span class="px-2 py-0.5 rounded-full text-xs font-medium <?php echo e($cls); ?>">
    <?php echo e(str_replace('_',' ', $status)); ?>

</span>
<?php /**PATH C:\laragon\www\farmacheat\resources\views/components/status-badge.blade.php ENDPATH**/ ?>