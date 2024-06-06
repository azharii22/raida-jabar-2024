

<?php $__env->startSection('title', 'Setting Application'); ?>
<?php $__env->startSection('css'); ?>
<!-- DataTables -->
<link href="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Setting <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Setting Aplikasi</h4>

                <?php if(count($errors) > 0): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-3 mb-5" role="alert">
                    Error! <br />
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                
                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Value</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php $__currentLoopData = $setting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e(++$key); ?></td>
                            <td>
                                <?php if($data->key == 'main.1_app_name'): ?>
                                <span>Nama Aplikasi</span>
                                <?php elseif($data->key == 'main.2_app_description'): ?>
                                <span>Deskripsi Aplikasi</span>
                                <?php elseif($data->key == 'main.3_app_logo'): ?>
                                <span>Logo Aplikasi</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($data->key === 'main.3_app_logo'): ?>
                                <img src="<?php echo e(Storage::url('public/setting'.'/'.$data->value)); ?>" width="150px" height="150px" style="border-radius: 20px">
                                <?php else: ?>
                                <?php echo e($data->value); ?>

                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php if($data->key != 'main.3_app_logo'): ?>
                                <?php echo $__env->make('layouts.edit-delete-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php else: ?>
                                <button type="button" class="btn btn-warning btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-file-<?php echo e($data->id); ?>"><i class=" bx bx-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-danger btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-delete-<?php echo e($data->id); ?>"><i class=" bx bx-trash"></i> Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div>
<?php $__currentLoopData = $setting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Start Edit Modal -->
<div class="modal fade" id="modal-edit-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php echo $__env->make('settingApp.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<!-- End Edit Modal -->

<!-- Start File Modal -->
<div class="modal fade" id="modal-file-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-setting.file' ,$data->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Value</label>
                        <input type="file" class="form-control" id="validationCustom02" name="value" required accept=".jpg, .png, .jpeg, .svg, .gif">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End File Modal -->

<!-- Start Delete Modal -->
<div class="modal fade" id="modal-delete-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-settings.destroy', $data->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-body">
                    <p>Are you Sure?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Delete Modal -->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<!-- Required datatable js -->
<script src="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/jszip/jszip.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/pdfmake/pdfmake.min.js')); ?>"></script>
<!-- Datatable init js -->
<script src="<?php echo e(URL::asset('/assets/js/pages/datatables.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/settingApp/index.blade.php ENDPATH**/ ?>