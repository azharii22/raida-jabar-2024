 
 <div class="container-xxl position-relative p-0">
    <nav class="bg-header navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <img src="assets/viewUser/img/raida/cakaran-1.1.png" alt="">
            <img src="<?php echo e(URL::asset('assets/viewUser/img/raida/Raida Putih.png')); ?>" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <a href="index.html" class="nav-item nav-link <?php echo e(request()->routeIs('viewUser') ? 'active' : ''); ?>">Beranda</a>
                <a href="<?php echo e(route('viewUser.tentang')); ?>" class="nav-item nav-link <?php echo e(request()->routeIs('viewUser.tentang') ? 'active' : ''); ?>">Tentang</a>
                <a href="service.html" class="nav-item nav-link <?php echo e(request()->routeIs('viewUser') ? 'active' : ''); ?>">Media Unduh</a>
                <a href="project.html" class="nav-item nav-link <?php echo e(request()->routeIs('viewUser') ? 'active' : ''); ?>">Artikel</a>
                <a href="about.html" class="nav-item nav-link <?php echo e(request()->routeIs('viewUser') ? 'active' : ''); ?>">Kegiatan</a>
                <a href="about.html" class="nav-item nav-link <?php echo e(request()->routeIs('viewUser') ? 'active' : ''); ?>">Jadwal Kegiatan</a>
                <a href="contact.html" class="nav-item nav-link <?php echo e(request()->routeIs('viewUser') ? 'active' : ''); ?>">Dokumentasi</a>
            </div>
            <a href="/login" class="btn btn-secondary text-light rounded-pill py-2 px-4 ms-3">Login</a>
        </div>
    </nav>
    <div class="bg-header p-5"></div>
    <img class="img-fluid" src="<?php echo e(URL::asset('assets/viewUser/img/raida/Header.png')); ?>" alt="">
</div>
<?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/viewUser/layouts/navbar.blade.php ENDPATH**/ ?>