<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('settings.main.1_app_name')); ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="<?php echo e(config('settings.main.1_app_name')); ?>" name="author">
    <meta content="<?php echo e(config('settings.main.2_app_description')); ?>" name="description">

    
    <link href="<?php echo e(config('settings.main.3_app_logo')); ?>" rel="icon">

    <?php echo $__env->make('viewUser.layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('css'); ?>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        
        
        <div class="container-xxl position-relative p-0">
            <nav class="bg-header navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="" class="navbar-brand p-0">
                    <img src="assets/viewUser/img/raida/cakaran-1.1.png" alt="">
                    <img src="<?php echo e(URL::asset('assets/viewUser/img/raida/Raida Putih.png')); ?>" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="<?php echo e(route('viewUser')); ?>"
                            class="nav-item nav-link <?php echo e(request()->routeIs('viewUser') ? 'active' : ''); ?>">Beranda</a>
                        <a href="<?php echo e(route('viewUser.tentang')); ?>"
                            class="nav-item nav-link <?php echo e(request()->routeIs('viewUser.tentang') ? 'active' : ''); ?>">Tentang</a>
                        <a href="<?php echo e(route('viewUser.media-unduh')); ?>"
                            class="nav-item nav-link <?php echo e(request()->routeIs('viewUser.media-unduh') ? 'active' : ''); ?>">Media
                            Unduh</a>
                        <a href="<?php echo e(route('viewUser.artikel')); ?>"
                            class="nav-item nav-link <?php echo e(request()->routeIs('viewUser.artikel') || request()->routeIs('viewUser.show-artikel') ? 'active' : ''); ?>">Artikel</a>
                        <a href="<?php echo e(route('viewUser.kegiatan')); ?>"
                            class="nav-item nav-link <?php echo e(request()->routeIs('viewUser.kegiatan') ? 'active' : ''); ?>">Kegiatan</a>
                        <a href="<?php echo e(route('viewUser.jadwalKegiatan')); ?>"
                            class="nav-item nav-link <?php echo e(request()->routeIs('viewUser.jadwalKegiatan') ? 'active' : ''); ?>">Jadwal
                            Kegiatan</a>
                        <a href="<?php echo e(route('viewUser.dokumentasi')); ?>"
                            class="nav-item nav-link <?php echo e(request()->routeIs('viewUser.dokumentasi') || request()->routeIs('viewUserPhoto') ? 'active' : ''); ?>">Dokumentasi</a>
                    </div>
                    <a href="/login" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Login</a>
                </div>
            </nav>
            <div class="bg-header p-5"></div>
        </div>
        

        <?php echo $__env->yieldContent('navbar'); ?>
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('viewUser.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


        
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i
                class="bi bi-arrow-up"></i></a>
    </div>

    <?php echo $__env->make('viewUser.layouts.vendor-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('script'); ?>
</body>

</html>
<?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/viewUser/layouts/master.blade.php ENDPATH**/ ?>