

<?php $__env->startSection('title','Berkas'); ?>

<?php $__env->startSection('css'); ?>
<!-- DataTables -->
<link href="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Berkas <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Berkas</h4>

                <?php if(auth()->user()->role_id != 1): ?>
                <div class="card-title mb-5">
                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add Berkas</button>
                </div>
                <?php endif; ?>

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

                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">File</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Catatan Dokumen</th>
                            <th class="text-center">Post By</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php $__currentLoopData = $berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e(++$key); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e(Storage::URL('public/berkas')); ?>/<?php echo e($data->filename); ?>" target="_blank">
                                    <?php echo e($data->file); ?>

                                </a>
                            </td>
                            <td class="text-center">
                                <?php if($data->status->name == 'Terkirim'): ?>
                                <span class="badge bg-primary">Terkirim</span>
                                <?php elseif($data->status->name == 'Revisi'): ?>
                                <span class="badge bg-warning">Revisi</span>
                                <?php elseif($data->status->name == 'Ditolak'): ?>
                                <span class="badge bg-danger">Revisi</span>
                                <?php elseif($data->status->name == 'Diterima'): ?>
                                <span class="badge bg-success">Diterima</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center"><?php echo e($data->catatan); ?></td>
                            <td class="text-center"><?php echo e($data->user->name); ?></td>
                            <td class="text-center">
                                <?php if(auth()->user()->role_id == 1 && $data->status->name == 'Terkirim' || $data->status->name == 'Ditolak' || $data->status->name == 'Revisi' ): ?>
                                <button type="button" class="btn btn-info btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-verifikasi-<?php echo e($data->id); ?>"><i class=" bx bx-check-circle"></i> Verifikasi</button>
                                <?php endif; ?>
                                <?php if(auth()->user()->role_id != 1): ?>
                                <?php echo $__env->make('layouts.edit-delete-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<!-- Start modal add -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-add" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-data-berkas-kontingen.store')); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">File</label>
                        <input name="file" type="file" class="form-control" id="validationCustom02" value="<?php echo e(old('File')); ?>" required accept=".pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- End modal add -->

<?php $__currentLoopData = $berkas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Start Edit Modal -->
<div class="modal fade" id="modal-edit-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php echo $__env->make('berkas.edit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</div>
<!-- End Edit Modal -->

<!-- Start Delete Modal -->
<div class="modal fade" id="modal-delete-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-data-berkas-kontingen.destroy', $data->id)); ?>" method="POST">
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

<!-- Start Verifikasi Modal -->
<div class="modal fade" id="modal-verifikasi-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Verifikasi Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('berkas.verifikasi', $data->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Verifikasi Dokumen</label>
                        <select name="status_id" class="form-select" id="validationCustom02">
                            <option disabled selected>--- Silahkan Verifikasi Dokumen ---</option>
                            <?php $__currentLoopData = $status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" <?php echo e($item->id == $data->status_id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom02" class="form-label">Catatan Untuk Dokumen</label>
                        <input type="text" name="catatan" class="form-control" value="<?php echo e($data->catatan); ?>" placeholder="Silahkan isi jika perlu...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Verifikasi Modal -->

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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\raida-jabar-2024\resources\views/berkas/index.blade.php ENDPATH**/ ?>