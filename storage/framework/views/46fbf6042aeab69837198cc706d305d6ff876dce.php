<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->

            <?php if(auth()->user()->role_id == 1): ?>
            <!-- Menu DKD / Admin Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Dashboards'); ?></li>
                <li><a href="/admin" class="waves-effect"> <i class="bx bx-home-circle"></i> <span key="t-dashboards"><?php echo app('translator')->get('translation.Dashboards'); ?></span> </a> </li>
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>
                <li><a href="<?php echo e(route('admin-artikel.index')); ?>" class="waves-effect"> <i class="bx bx-archive"></i> <span key="t-dashboards">Artikel</span> </a> </li>
                <li><a href="<?php echo e(route('admin-dokumentasi-kegiatan.index')); ?>" key="t-tui-dokumentasi"><i class="bx bx-photo-album"></i><span key="t-dokumentasi">Dokumentasi Kegiatan</span></a></li>
                <li><a href="<?php echo e(route('admin-kegiatan.index')); ?>" key="t-tui-kegiatan"><i class="bx bx-walk"></i><span key="t-kegiatan">Kegiatan</span></a></li>
                <li><a href="<?php echo e(route('admin-jadwal-kegiatan.index')); ?>" key="t-tui-jadwalKegiatan"><i class="bx bx-calendar"></i><span key="t-jadwalKegiatan">Jadwal Kegiatan</span></a></li>
                <li><a href="<?php echo e(route('admin-dokumen-penting.index')); ?>" key="t-tui-dokumenPenting"><i class="bx bx-file"></i><span key="t-dokumenPenting">Dokumen Penting</span></a></li>
                <li><a href="<?php echo e(route('admin-kategori.index')); ?>" key="t-tui-kategori"><i class="bx bx-file"></i><span key="t-kategori">Kategori</span></a></li>
                <li><a href="<?php echo e(route('admin-region.index')); ?>" key="t-tui-region"><i class="mdi mdi-flag"></i><span key="t-region">Region</span></a></li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-analyse"></i>
                        <span key="t-contacts">Master Administrasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="<?php echo e(route('admin-data-berkas-kontingen.index')); ?>" key="t-user-grid">Data Berkas Kontingen</a></li>
                        <li><a href="<?php echo e(route('admin-data-peserta.index')); ?>" key="t-user-list">Data Peserta</a></li>
                        <li><a href="<?php echo e(route('admin-data-unsur-kontingen.index')); ?>" key="t-profile">Data Unsur Kontingen</a></li>
                        <li><a href="<?php echo e(route('admin-data-pembayaran.index')); ?>" key="t-pembayaran">Data Pembayaran</a></li>
                    </ul>
                </li>
                <li class="menu-title" key="t-pages"><?php echo app('translator')->get('translation.Pages'); ?></li>
                <li> <a href="<?php echo e(route('admin-user.index')); ?>" class="waves-effect"> <i class="bx bx-user-circle"></i> <span key="t-dashboards">User Management</span> </a> </li>
                <li> <a href="<?php echo e(route('admin-settings.index')); ?>" class="waves-effect"> <i class="bx bx-cog"></i> <span key="t-dashboards">Settings</span> </a> </li>
            </ul>
            <!-- Menu DKD / Admin End -->

            <?php elseif(auth()->user()->role_id == 2): ?>
            <!-- Menu DKR Star -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Dashboards'); ?></li>
                <li><a href="/admin" class="waves-effect"> <i class="bx bx-home-circle"></i> <span key="t-dashboards"><?php echo app('translator')->get('translation.Dashboards'); ?></span> </a> </li>
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>
                <li><a href="<?php echo e(route('admin-data-berkas-kontingen.index')); ?>" key="t-user-grid"><i class="bx bx-file"></i>Data Berkas Kontingen</a></li>
                <li><a href="<?php echo e(route('admin-data-peserta.index')); ?>" key="t-user-list"><i class="bx bx-user"></i>Data Peserta</a></li>
                <li><a href="<?php echo e(route('admin-data-unsur-kontingen.index')); ?>" key="t-profile"><i class="bx bx-file"></i>Data Unsur Kontingen</a></li>
            </ul>
            <!-- Menu DKR End -->

            <?php elseif(auth()->user()->role_id == 3): ?>
            <!-- Menu DKC Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Dashboards'); ?></li>
                <li><a href="/admin" class="waves-effect"> <i class="bx bx-home-circle"></i> <span key="t-dashboards"><?php echo app('translator')->get('translation.Dashboards'); ?></span> </a> </li>
                <li class="menu-title" key="t-menu"><?php echo app('translator')->get('translation.Menu'); ?></li>
                <li><a href="<?php echo e(route('admin-data-berkas-kontingen.index')); ?>" key="t-user-grid"> <i class="bx bx-file"></i>Data Berkas Kontingen</a></li>
                <li><a href="<?php echo e(route('admin-data-unsur-kontingen.index')); ?>" key="t-user-grid"> <i class="bx bx-user-circle"></i>Data Unsur Kontingen</a></li>
                <li><a href="<?php echo e(route('admin-data-pembayaran.index')); ?>" key="t-user-grid"> <i class="bx bx-dollar-circle"></i>Bukti Pembayaran</a></li>
                <li><a href="<?php echo e(route('admin-data-peserta.index')); ?>" key="t-user-list"> <i class="bx bx-user"></i>Data Peserta</a></li>
            </ul>
            <!-- Menu DKC End -->

            <?php endif; ?>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End --><?php /**PATH C:\xampp\htdocs\raida-jabar-2024\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>