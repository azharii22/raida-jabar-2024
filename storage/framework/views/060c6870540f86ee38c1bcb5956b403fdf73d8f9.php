

<?php $__env->startSection('title', 'Create Dokumentasi'); ?>

<?php $__env->startSection('css'); ?>
<!-- Plugins css -->
<link href="<?php echo e(URL::asset('/assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Dokumentasi <?php $__env->endSlot(); ?>
<?php $__env->slot('title2'); ?> Dokumentasi Upload <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                    Error! <br />
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <form action="<?php echo e(route('admin-dokumentasi-kegiatan.store')); ?>" method="POST" enctype="multipart/form-data" autocomplete="false">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="formrow-judul-input" class="form-label">Judul</label>
                        <input name="judul" type="text" class="form-control" id="formrow-judul-input" placeholder="Judul Dokumentasi" value="<?php echo e(old('judul')); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="formrow-cover-input" class="form-label">Cover</label>
                        <input name="cover" type="file" class="form-control" id="formrow-cover-input" placeholder="Cover" value="<?php echo e(old('cover')); ?>">
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!-- Plugins js -->
<script src="<?php echo e(URL::asset('/assets/libs/dropzone/dropzone.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/dokumentasiKegiatan/create.blade.php ENDPATH**/ ?>