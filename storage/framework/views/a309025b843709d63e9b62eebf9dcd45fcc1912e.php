

<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Dashboards'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col" style="min-width: max-content">
            <div class="card overflow-hidden">
                <div class="bg-soft" style="background-color: #0B557F !important;">
                    <div class="row" style="height: 20px">
                        <div class="col-5 align-self-end">
                            <img src="<?php echo e(URL::asset('assets/viewUser/img/raida/Raida Putih.png')); ?>" alt="" class="m-5" style="width: 100%; height: 20rem;">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <div class="avatar-md profile-user-wid mb-3">
                                <img src="<?php echo e(isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-1.jpg')); ?>"
                                    alt="" class="img-thumbnail rounded-circle">
                            </div>
                            <h5 class="font-size-15 text-truncate">Hi, <?php echo e(auth()->user()->fullname); ?>. <br /> Welcome back To <?php echo e(config('settings.main.1_app_name')); ?></h5>
                            
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mini-stats-wid" style="margin-bottom: 12px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Bindamping</p>
                                    <h4 class="mb-0"><?php echo e($userBindamping); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid" style="margin-bottom: 12px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Peserta</p>
                                    <h4 class="mb-0"><?php echo e($userPeserta); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(auth()->user()->role_id != 2): ?>
                <div class="col-md-4">
                    <div class="card mini-stats-wid" style="margin-bottom: 12px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pinkoncab</p>
                                    <h4 class="mb-0"><?php echo e($userPinkoncab); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-md-4">
                    <div class="card mini-stats-wid" style="margin-bottom: 12px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Pinkonran</p>
                                    <h4 class="mb-0"><?php echo e($userPinkonran); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(auth()->user()->role_id != 2): ?>
                <div class="col-md-4">
                    <div class="card mini-stats-wid" style="margin-bottom: 12px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Staff Kontingen</p>
                                    <h4 class="mb-0"><?php echo e($userStaffKontingen); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center ">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid" style="margin-bottom: 12px">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-muted fw-medium">Tenaga Medis</p>
                                    <h4 class="mb-0"><?php echo e($userTenagaMedis); ?></h4>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                        <span class="avatar-title rounded-circle bg-primary">
                                            <i class="bx bx-user font-size-24"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <!-- end row -->
        </div>
        <div class="col">
            <div class="card" style="height: 95%">
                <div class="card-body">
                    <div class="text-center mt-5">
                        <h1 class="text-muted fw-medium mb-3">Total Partisipan</>
                        <h2 class="mb-0"><?php echo e($grandTotalPeserta); ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    
    <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <!-- apexcharts -->
    <script src="<?php echo e(URL::asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>

    <!-- dashboard init -->
    <script src="<?php echo e(URL::asset('assets/js/pages/dashboard.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/index.blade.php ENDPATH**/ ?>