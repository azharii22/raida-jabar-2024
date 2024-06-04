<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8" />
    <!-- <title> <?php echo $__env->yieldContent('title'); ?> | Skote - Responsive Bootstrap 4 Admin Dashboard</title> -->
    <title>Login | <?php echo e(config('settings.main.1_app_name')); ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta content="Raida" name="description" />
    <meta content="<?php echo e(config('settings.main.1_app_name')); ?>" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('assets/images/favicon.ico')); ?>">
    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php echo $__env->yieldContent('body'); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/layouts/master-without-nav.blade.php ENDPATH**/ ?>