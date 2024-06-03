

<?php $__env->startSection('title', 'Pembayaran'); ?>

<?php $__env->startSection('css'); ?>
<!-- DataTables -->
<link href="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startComponent('components.breadcrumb'); ?>
<?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php $__env->slot('title'); ?> Pembayaran <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<?php if(auth()->user()->role_id == "1"): ?>

<div class="row">
    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Peserta & Unsur Kontingen</p>
                        <h4 class="mb-0"><?php echo e(count($pembayaran)); ?> Orang</h4>
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
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Terdaftar</p>
                        <h4 class="mb-0"><?php echo e($terdaftar); ?> Orang</h4>
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
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Nominal</p>
                        <h4 class="mb-0">Rp. <?php echo number_format($nominal,0,',','.'); ?></h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-money font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <div>
                    <button type="button" class="btn btn-primary waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#myModal"> <i class="bx bx-plus"></i>
                        Add Pembayaran
                    </button>
                </div>

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

                <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="myModalLabel">Form Pembayaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?php echo e(route('admin-data-pembayaran.store')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="status" value="terkirim">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="formrow-firstname-input" class="form-label">Jumlah Terdaftar</label>
                                        <input name="jumlah_terdaftar" type="number" class="form-control" id="formrow-nama-input" value="<?php echo e(old('jumlah_terdaftar')); ?>" placeholder="Jumlah Terdaftar">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formrow-firstname-input" class="form-label">Nominal</label>
                                        <input name="nominal" type="number" class="form-control" id="formrow-nama-input" value="<?php echo e(old('nominal')); ?>" placeholder="Nominal">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formrow-jk" class="form-label">Upload Bukti Pembayaran</label>
                                        <input name="file" type="file" class="form-control" id="formrow-nama-input" accept=".jpg,.png,.jpeg">
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

                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th style="width: 10px;">Nama</th>
                            <th style="width: 10px;">Jumlah Terdaftar</th>
                            <th style="width: 10px;">Nominal</th>
                            <th style="width: 10px;">Status</th>
                            <th style="width: 10px;" class="text-center">Bukti Pembayaran</th>
                            <th style="width: 10px;">Tanggal Upload</th>
                            <th style="width: 10px;">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php $__currentLoopData = $pembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td style="width: 10px;"> <?php echo e(++$i); ?> </td>
                            <td style="width: 10px;"> <?php echo e($data->user->name); ?> </td>
                            <td style="width: 10px;"> <?php echo e($data->jumlah_terdaftar); ?> </td>
                            <td style="width: 10px;"> Rp. <?php echo number_format($data->nominal,0,',','.'); ?> </td>
                            <td style="width: 10px;">
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
                            <td style="width: 10px;" class="text-center"><a class="btn btn-primary btn-sm mr-2" href="<?php echo e(Storage::url('public/pembayaran/').$data->file); ?>" target="_blank"><i class="bx bx-show"></i> Lihat</a></td>
                            <td style="width: 10px;"><?php echo e(date('d-F-Y H:i',strtotime($data->tanggal_upload))); ?></td>
                            <td class="text-center" style="width: 10px;">
                                <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-edit-<?php echo e($data->id); ?>"> <i class="bx bx-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-<?php echo e($data->id); ?>"> <i class="bx bx-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row -->
<?php endif; ?>

<?php if(auth()->user()->role_id == "2"): ?>

<div class="row">
    <div class="col-md-4">
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Peserta</p>
                        <h4 class="mb-0"><?php echo e(count($pembayaran)); ?> Orang</h4>
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
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Terdaftar</p>
                        <h4 class="mb-0"><?php echo e($terdaftar); ?> Orang</h4>
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
        <div class="card mini-stats-wid">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-muted fw-medium">Total Nominal</p>
                        <h4 class="mb-0">Rp. <?php echo number_format($nominal,0,',','.'); ?></h4>
                    </div>

                    <div class="flex-shrink-0 align-self-center">
                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                            <span class="avatar-title">
                                <i class="bx bx-money font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div>
                    <a href="<?php echo e(route('export-pembayaran')); ?>" class="btn btn-success waves-effect waves-light mb-3" target="_blank"><i class="fa fa-file-excel"></i> Export Excel</a>

                </div>
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th style="width: 10px;">Nama</th>
                                <th style="width: 10px;">Jumlah Terdaftar</th>
                                <th style="width: 10px;">Nominal</th>
                                <th style="width: 10px;">Status</th>
                                <th style="width: 10px;" class="text-center">Bukti Pembayaran</th>
                                <th style="width: 10px;">Tanggal Upload</th>
                                <th style="width: 10px;">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php $__currentLoopData = $pembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td style="width: 10px;"><?php echo e(++$i); ?></td>
                                <td style="width: 10px;"><?php echo e($data->user?->name); ?></td>
                                <td style="width: 10px;"><?php echo e($data->jumlah_terdaftar); ?></td>
                                <td style="width: 10px;">Rp. <?php echo number_format($data->nominal,0,',','.'); ?></td>
                                <td style="width: 10px;">
                                    <?php if($data->status === 'terkirim'): ?>
                                    <span class="badge text-bg-primary">Terkirim</span>
                                    <?php elseif($data->status === 'diterima'): ?>
                                    <span class="badge text-bg-success">Diterima</span>
                                    <?php elseif($data->status === 'revisi'): ?>
                                    <span class="badge text-bg-warning">Revisi</span>
                                    <?php elseif($data->status === 'ditolak'): ?>
                                    <span class="badge text-bg-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td style="width: 10px;" class="text-center"><a href="<?php echo e(Storage::url('public/img/pembayaran/').$data->file_bukti_bayar); ?>" target="_blank"><img src="<?php echo e(Storage::url('public/img/pembayaran/').$data->file_bukti_bayar); ?>" width="100" height="100" /></a></td>
                                <td style="width: 10px;"><?php echo e(date('d-M-Y',strtotime($data->tanggal_upload))); ?></td>
                                <td class="text-center" style="width: 10px;">
                                    <?php if($data->status->name === 'Revisi' || $data->status->name === 'Terkirim' || $data->status->name === 'Ditolak'): ?>
                                    <button type="button" class="btn btn-info waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-status-<?php echo e($data->id); ?>"> <i class="bx bx-pencil"></i> Update Status</button>
                                    <?php else: ?>
                                    <span class="badge text-bg-success"><i class="bx bx-minus"></i> </span>
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

<?php endif; ?>

<!-- Start modal Delete-->
<?php $__currentLoopData = $pembayaran; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-edit-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Edit Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-data-pembayaran.update', $data->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <input type="hidden" name="status" value="terkirim">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Jumlah Terdaftar</label>
                        <input name="jumlah_terdaftar" type="number" class="form-control" id="formrow-nama-input" value="<?php echo e($data->jumlah_terdaftar); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Nominal</label>
                        <input name="nominal" type="number" class="form-control" id="formrow-nama-input" value="<?php echo e($data->nominal); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="formrow-jk" class="form-label">Upload Bukti Pembayaran</label>
                        <input name="file_bukti_bayar" type="file" class="form-control" id="formrow-nama-input">
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

<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-delete-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-data-pembayaran.destroy', $data->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <p> Apakah <?php echo e(auth()->user()->nama); ?> ingin menghapus data? </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-status-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('verifikasiPembayaran', $data->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="formrow-nama-input" placeholder="<?php echo e($data->user?->nama); ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Pilih Status</label>
                        <select name="status" class="form-control" id="formrow-jk">
                            <option disabled selected>--- Verifikasi Status ---</option>
                            <option value="diterima" <?php echo e("diterima" == $data->status ? 'selected' : ''); ?>>Diterima</option>
                            <option value="revisi" <?php echo e("revisi" == $data->status ? 'selected' : ''); ?>>Revisi</option>
                            <option value="ditolak" <?php echo e("ditolak" == $data->status ? 'selected' : ''); ?>>Ditolak</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Catatan</label>
                        <textarea type="catatan" class="form-control" id="formrow-nama-input" placeholder="Isi Catatan Jika Perlu"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Update Status</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/pembayaran/index.blade.php ENDPATH**/ ?>