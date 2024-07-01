

<?php $__env->startSection('title', 'Create Artikel'); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Artikel <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Create Artikel <?php $__env->endSlot(); ?>
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
                
                <form action="<?php echo e(route('admin-artikel.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="formrow-judul-input" class="form-label">Judul</label>
                        <input name="judul" type="text" class="form-control" id="formrow-judul-input" placeholder="Judul Artikel" value="<?php echo e(old('judul')); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="formrow-deskripsi-input" class="form-label">Deskripsi</label>
                        <input name="deskripsi" type="text" class="form-control" id="formrow-deskripsi-input" placeholder="Deskripsi Artikel" value="<?php echo e(old('deskripsi')); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="formrow-foto-input" class="form-label">Foto</label>
                        <input name="foto" type="file" class="form-control" id="formrow-foto-input">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Artikel</label>
                        <textarea id="elm1" name="isi_artikel"><?php echo e(old('isi_artikel')); ?></textarea>
                    </div>
                    <div>
                        <a href="<?php echo e(route('admin-artikel.index')); ?>" type="button" class="btn btn-secondary w-md m-2 align-self-end">Cancel</a>
                        <button type="submit" class="btn btn-primary w-md m-2 align-self-end">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!--tinymce js-->
<script src="<?php echo e(URL::asset('assets/libs/tinymce/tinymce.min.js')); ?>"></script>

<!-- init js -->
<script src="<?php echo e(URL::asset('assets/js/pages/form-editor.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/artikel/create.blade.php ENDPATH**/ ?>