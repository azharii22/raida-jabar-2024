<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('settings.main.1_app_name')); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo e(config('settings.main.1_app_name')); ?>" name="keywords">
    <meta content="<?php echo e(config('settings.main.2_app_description')); ?>" name="description">

    
    <link href="<?php echo e(config('settings.main.3_app_logo')); ?>" rel="icon">

    <?php echo $__env->make('viewUser.layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        


        <?php echo $__env->make('viewUser.layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('viewUser.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
    </div>

    <?php echo $__env->make('viewUser.layouts.vendor-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('script'); ?>
</body>

</html><?php /**PATH C:\xampp\htdocs\raida-jabar-2024\resources\views/viewUser/layouts/master.blade.php ENDPATH**/ ?>