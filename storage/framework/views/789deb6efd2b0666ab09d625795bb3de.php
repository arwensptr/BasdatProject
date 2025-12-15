<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_','-',app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name','Farmacheat')); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css','resources/js/app.js']); ?>
</head>
<body class="min-h-screen antialiased">
    
    <?php echo e($slot); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\farmacheat\resources\views/layouts/guest.blade.php ENDPATH**/ ?>