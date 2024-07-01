

<?php $__env->startSection('title', 'Peserta'); ?>

<?php $__env->startSection('css'); ?>
<!-- DataTables -->
<link href="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Peserta <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Peserta</h4>
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

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Berkas Peserta</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php $__currentLoopData = $peserta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(++$i); ?></td>
                                <td class="text-uppercase"><?php echo e($data->nama_lengkap); ?></td>
                                <td>
                                    <?php if($data->jenis_kelamin == 1): ?>
                                    <span>Laki - Laki</span>
                                    <?php else: ?>
                                    <span>Perempuan</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($data->kategori?->name); ?></td>
                                <td>
                                    <?php if($data->status->name === 'Terkirim'): ?>
                                    <span class="badge text-bg-primary">Terkirim</span>
                                    <?php elseif($data->status->name === 'Diterima'): ?>
                                    <span class="badge text-bg-success">Diterima</span>
                                    <?php elseif($data->status->name === 'Revisi'): ?>
                                    <span class="badge text-bg-warning">Revisi</span>
                                    <?php elseif($data->status->name === 'Ditolak'): ?>
                                    <span class="badge text-bg-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($data->foto != NULL): ?>
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="<?php echo e(Storage::url('public/img/peserta/foto/').$data->foto); ?>" target="_blank"><i class="bx bx-check-circle"></i> Foto</a>
                                    <?php else: ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-foto-<?php echo e($data->id); ?>"><i class="bx bx-upload"></i> Foto</button>
                                    <?php endif; ?>
                                    <?php if($data->KTA != NULL): ?>
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="<?php echo e(Storage::url('public/img/peserta/kta/').$data->KTA); ?>" target="_blank"><i class="bx bx-check-circle"></i> KTA</a>
                                    <?php else: ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-kta-<?php echo e($data->id); ?>"><i class="bx bx-upload"></i> KTA</button>
                                    <?php endif; ?>
                                    <?php if($data->asuransi_kesehatan != NULL): ?>
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="<?php echo e(Storage::url('public/img/peserta/asuransi-kesehatan/').$data->asuransi_kesehatan); ?>" target="_blank"><i class="bx bx-check-circle"></i> Asuransi Kesehatan </a>
                                    <?php else: ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-asuransi-<?php echo e($data->id); ?>"><i class="bx bx-upload"></i> Asuransi Kesehatan </button>
                                    <?php endif; ?>
                                    <?php if($data->sertif_sfh != NULL): ?>
                                    <a class="btn btn-success waves-effect waves-light btn-sm mr-2" href="<?php echo e(Storage::url('public/img/peserta/sertif-sfh/').$data->sertif_sfh); ?>" target="_blank"><i class="bx bx-check-circle"></i> Sertif SFH</a>
                                    <?php else: ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-sertif-<?php echo e($data->id); ?>"><i class="bx bx-upload"></i> Sertif SFH</button>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($data->status->name === 'Revisi'): ?>
                                    <div style="color: red;">
                                        <li><?php echo e($data->catatan); ?></li>
                                    </div>
                                    <?php else: ?>
                                    <?php echo e($data->catatan); ?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!-- Required datatable js -->
<script src="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/jszip/jszip.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/pdfmake/pdfmake.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('/assets/libs/select2/select2.min.js')); ?>"></script>
<!-- Datatable init js -->
<script src="<?php echo e(URL::asset('/assets/js/pages/datatables.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/peserta/detailVillages.blade.php ENDPATH**/ ?>