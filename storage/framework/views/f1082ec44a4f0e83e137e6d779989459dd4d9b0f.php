

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

<?php if(auth()->user()->role_id == 1): ?>
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
                    <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th class="text-center">Kwarcab</th>
                                <th class="text-center">Jumlah Pendaftar</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            <?php $__currentLoopData = $regency; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e(++$i); ?></td>
                                <td class="text-uppercase text-center"><?php echo e($data->name); ?></td>
                                <td class="text-uppercase text-center"><?php echo e(count($peserta->where('regency_id', $data->id))); ?> Peserta</td>
                                <td class="text-center">
                                    <a href="<?php echo e(route('admin-data-peserta.detailRegency',$data->id)); ?>" class="btn btn-success waves-effect waves-light btn-sm mr-2"> Lihat <i class="bx bx-right-arrow-alt"></i></a>
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
<?php elseif(auth()->user()->role_id == 2): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Peserta</h4>

                <div class="card-title mb-5">
                    <button type="button" class="btn btn-primary waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-add"> <i class="bx bx-plus"></i> Add Peserta</button>
                    <a href="<?php echo e(route('peserta.excel')); ?>" type="button" class="btn btn-success waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-excel-outline"></i> Export Excel</a>
                    <a href="<?php echo e(route('peserta.pdf')); ?>" type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-pdf-outline"></i> Export PDF</a>
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
                                <th style="width: 10px;">Action</th>
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
                                <td class="text-center">
                                    <?php if(auth()->user()->role_id == 1 && $data->status->name != 'Diterima'): ?>
                                    <button type="button" class="btn btn-info btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-verifikasi-<?php echo e($data->id); ?>"><i class=" bx bx-check-circle"></i> Verifikasi</button>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-light waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-detail-<?php echo e($data->id); ?>"> <i class="bx bx-show"></i> Detail</button>
                                    <?php if(auth()->user()->role_id != 1): ?>
                                    <button type="button" class="btn btn-warning waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-edit-<?php echo e($data->id); ?>"> <i class="bx bx-pencil"></i> Edit</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" data-bs-toggle="modal" data-bs-target="#modal-delete-<?php echo e($data->id); ?>"> <i class="bx bx-trash"></i> Delete</button>
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
</div>
<?php elseif(auth()->user()->role_id == 3): ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">Peserta</h4>

                <div class="card-title mb-5">
                    <a href="<?php echo e(route('peserta.excel')); ?>" type="button" class="btn btn-success waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-excel-outline"></i> Export Excel</a>
                    <a href="<?php echo e(route('peserta.pdf')); ?>" type="button" class="btn btn-danger waves-effect waves-light btn-sm mr-2" target="_blank"> <i class="mdi mdi-file-pdf-outline"></i> Export PDF</a>
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

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th style="width: 10px;">No</th>
                                <th>Wilayah</th>
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
                                <td class="text-uppercase"><?php echo e($data->villages?->name); ?></td>
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
</div>

<?php endif; ?>

<!-- Start modal add -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-add" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Add Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-data-peserta.store')); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Nama Lengkap <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="nama_lengkap" type="text" class="form-control" id="validationCustom02" value="<?php echo e(old('nama_lengkap')); ?>" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <div class="input-group">
                                    <input name="tempat_lahir" type="text" class="form-control" id="validationCustom02" value="<?php echo e(old('tempat_lahir')); ?>" placeholder="Tempat Lahir" required>
                                    <input name="tanggal_lahir" type="date" class="form-control" id="validationCustom02" value="<?php echo e(old('tanggal_lahir')); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Jenis Kelamin <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="jenis_kelamin">
                                    <option disabled selected>--- Pilih Jenis Kelamin ---</option>
                                    <option value="1" <?php if(old('jenis_kelamin')=='1' ): echo 'selected'; endif; ?>>Laki - Laki</option>
                                    <option value="2" <?php if(old('jenis_kelamin')=='2' ): echo 'selected'; endif; ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Ukuran Kaos <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="ukuran_kaos">
                                    <option disabled selected>--- Pilih Ukuran Kaos ---</option>
                                    <option value="S" <?php if(old('ukuran_kaos')=='S' ): echo 'selected'; endif; ?>>S</option>
                                    <option value="M" <?php if(old('ukuran_kaos')=='M' ): echo 'selected'; endif; ?>>M</option>
                                    <option value="L" <?php if(old('ukuran_kaos')=='L' ): echo 'selected'; endif; ?>>L</option>
                                    <option value="XL" <?php if(old('ukuran_kaos')=='XL' ): echo 'selected'; endif; ?>>XL</option>
                                    <option value="XXL" <?php if(old('ukuran_kaos')=='XXL' ): echo 'selected'; endif; ?>>XXL</option>
                                    <option value="XXXL" <?php if(old('ukuran_kaos')=='XXXL' ): echo 'selected'; endif; ?>>XXXL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP / WA <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="no_hp" type="number" id="no_hp" value="<?php echo e(old('no_hp')); ?>" placeholder="No HP/ WA" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Kategori <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="kategori_id" id="kategori_id">
                                    <option disabled selected>--- Pilih Kategori ---</option>
                                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if(old('kategori_id')==$item->id): echo 'selected'; endif; ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="agama" id="agama">
                                    <option disabled selected>--- Pilih Agama ---</option>
                                    <option value="Islam" <?php if(old('agama')=='Islam' ): echo 'selected'; endif; ?>>Islam</option>
                                    <option value="Kristen" <?php if(old('agama')=='Kristen' ): echo 'selected'; endif; ?>>Kristen</option>
                                    <option value="Katolik" <?php if(old('agama')=='Katolik' ): echo 'selected'; endif; ?>>Katolik</option>
                                    <option value="Hindu" <?php if(old('agama')=='Hindu' ): echo 'selected'; endif; ?>>Hindu</option>
                                    <option value="Buddha" <?php if(old('agama')=='Buddha' ): echo 'selected'; endif; ?>>Buddha</option>
                                    <option value="Konghucu" <?php if(old('agama')=='Konghucu' ): echo 'selected'; endif; ?>>Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="golongan_darah" class="form-label">Golongan Darah <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="golongan_darah">
                                    <option disabled selected>--- Pilih Golongan Darah ---</option>
                                    <option value="A" <?php if(old('golongan_darah')=='A' ): echo 'selected'; endif; ?>>A</option>
                                    <option value="B" <?php if(old('golongan_darah')=='B' ): echo 'selected'; endif; ?>>B</option>
                                    <option value="O" <?php if(old('golongan_darah')=='O' ): echo 'selected'; endif; ?>>O</option>
                                    <option value="AB" <?php if(old('golongan_darah')=='AB' ): echo 'selected'; endif; ?>>AB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                <input name="riwayat_penyakit" type="text" id="riwayat_penyakit" value="<?php echo e(old('riwayat_penyakit')); ?>" placeholder="Riwayat Penyakit" class="form-control">
                                <input name="regency_id" value="<?php echo e(Auth::user()->regency_id); ?>" hidden>
                                <input name="villages_id" value="<?php echo e(Auth::user()->villages_id); ?>" hidden>
                            </div>
                        </div>
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

<!-- Start modal Delete-->
<?php $__currentLoopData = $peserta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- Start modal Edit -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-edit-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Form Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-data-peserta.update', $data->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Nama Lengkap <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="nama_lengkap" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->nama_lengkap); ?>" placeholder="Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <div class="input-group">
                                    <input name="tempat_lahir" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->tempat_lahir); ?>" placeholder="Tempat Lahir" required>
                                    <input name="tanggal_lahir" type="date" class="form-control" id="validationCustom02" value="<?php echo e($data->tanggal_lahir); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Jenis Kelamin <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="jenis_kelamin">
                                    <option disabled selected>--- Pilih Jenis Kelamin ---</option>
                                    <option value="1" <?php if($data->jenis_kelamin=='1' ): echo 'selected'; endif; ?>>Laki - Laki</option>
                                    <option value="2" <?php if($data->jenis_kelamin=='2' ): echo 'selected'; endif; ?>>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Ukuran Kaos <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="ukuran_kaos">
                                    <option disabled selected>--- Pilih Ukuran Kaos ---</option>
                                    <option value="S" <?php if($data->ukuran_kaos =='S' ): echo 'selected'; endif; ?>>S</option>
                                    <option value="M" <?php if($data->ukuran_kaos =='M' ): echo 'selected'; endif; ?>>M</option>
                                    <option value="L" <?php if($data->ukuran_kaos =='L' ): echo 'selected'; endif; ?>>L</option>
                                    <option value="XL" <?php if($data->ukuran_kaos =='XL' ): echo 'selected'; endif; ?>>XL</option>
                                    <option value="XXL" <?php if($data->ukuran_kaos =='XXL' ): echo 'selected'; endif; ?>>XXL</option>
                                    <option value="XXXL" <?php if($data->ukuran_kaos =='XXXL' ): echo 'selected'; endif; ?>>XXXL</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No HP / WA <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <input name="no_hp" type="number" id="no_hp" value="<?php echo e($data->no_hp); ?>" placeholder="No HP/ WA" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="kategori_id" class="form-label">Kategori <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="kategori_id" id="kategori_id">
                                    <option disabled selected>--- Pilih Kategori ---</option>
                                    <?php $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if($data->kategori_id==$item->id): echo 'selected'; endif; ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="agama" class="form-label">Agama <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="agama" id="agama">
                                    <option disabled selected>--- Pilih Agama ---</option>
                                    <option value="Islam" <?php if($data->agama=='Islam' ): echo 'selected'; endif; ?>>Islam</option>
                                    <option value="Kristen" <?php if($data->agama=='Kristen' ): echo 'selected'; endif; ?>>Kristen</option>
                                    <option value="Katolik" <?php if($data->agama=='Katolik' ): echo 'selected'; endif; ?>>Katolik</option>
                                    <option value="Hindu" <?php if($data->agama=='Hindu' ): echo 'selected'; endif; ?>>Hindu</option>
                                    <option value="Buddha" <?php if($data->agama=='Buddha' ): echo 'selected'; endif; ?>>Buddha</option>
                                    <option value="Konghucu" <?php if($data->agama=='Konghucu' ): echo 'selected'; endif; ?>>Konghucu</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="golongan_darah" class="form-label">Golongan Darah <i class="mdi mdi-exclamation-thick" style="color: red;"></i></label>
                                <select class="form-select" name="golongan_darah">
                                    <option disabled selected>--- Pilih Golongan Darah ---</option>
                                    <option value="A" <?php if($data->golongan_darah =='A' ): echo 'selected'; endif; ?>>A</option>
                                    <option value="B" <?php if($data->golongan_darah =='B' ): echo 'selected'; endif; ?>>B</option>
                                    <option value="O" <?php if($data->golongan_darah =='O' ): echo 'selected'; endif; ?>>O</option>
                                    <option value="AB" <?php if($data->golongan_darah ='AB' ): echo 'selected'; endif; ?>>AB</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                                <input name="riwayat_penyakit" type="text" id="riwayat_penyakit" value="<?php echo e($data->riwayat_penyakit); ?>" placeholder="Riwayat Penyakit" class="form-control">
                                <input name="regency_id" value="<?php echo e(Auth::user()->regency_id); ?>" hidden>
                                <input name="villages_id" value="<?php echo e(Auth::user()->villages_id); ?>" hidden>
                            </div>
                        </div>
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
<!-- End modal Edit -->
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-delete-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Delete Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-data-peserta.destroy', $data->id)); ?>" method="POST">
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
<!-- End modal Delete -->

<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-foto-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('peserta.foto', $data->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Foto</label>
                        <input name="foto" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-kta-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload KTA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('peserta.kta', $data->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload KTA</label>
                        <input name="KTA" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-asuransi-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Asuransi Kesehatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('peserta.asuransi', $data->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Asuransi Kesehatan</label>
                        <input name="asuransi_kesehatan" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" id="modal-sertif-<?php echo e($data->id); ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Upload Sertifikat SFH</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('peserta.sertif', $data->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="formrow-firstname-input" class="form-label">Upload Sertifikat SFH</label>
                        <input name="sertif_sfh" type="file" class="form-control" id="formrow-nama-input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success waves-effect waves-light"><i class="bx bx-upload"></i> Upload</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<div id="modal-detail-<?php echo e($data->id); ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Detail Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table>
                    <tr>
                        <td class="w-64">Nama Lengkap</td>
                        <td>:</td>
                        <td><?php echo e($data->nama_lengkap); ?></td>
                    </tr>
                    <tr>
                        <td>Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td><?php echo e($data->tempat_lahir); ?>,<?php echo e(date('d-M-y', strtotime($data->tanggal_lahir))); ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:</td>
                        <td>
                            <?php if($data->jenis_kelamin == 1): ?>
                            <span>Laki - Laki</span>
                            <?php else: ?>
                            <span>Perempuan</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Ukuran Kaos</td>
                        <td>:</td>
                        <td><?php echo e($data->ukuran_kaos); ?></td>
                    </tr>
                    <tr>
                        <td>No HP</td>
                        <td>:</td>
                        <td><?php echo e($data->no_hp); ?></td>
                    </tr>
                    <tr>
                        <td>Kategori</td>
                        <td>:</td>
                        <td><?php echo e($data->kategori?->name); ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?php echo e($data->agama); ?></td>
                    </tr>
                    <tr>
                        <td>Golongan Darah</td>
                        <td>:</td>
                        <td><?php echo e($data->golongan_darah); ?></td>
                    </tr>
                    <tr>
                        <td>Riwayat Penyakit</td>
                        <td>:</td>
                        <td><?php echo e($data->riwayat_penyakit ? $data->riwayat_penyakit : '-'); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <table class="border-collapse border border-slate-400 w-full">
                                <thead>
                                    <tr>
                                        <th class="w-64">Foto</th>
                                        <th class="w-64">KTA</th>
                                        <th class="w-64">Asuransi</th>
                                        <th class="w-64">Sertif SFH</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="<?php echo e(isset($data->foto) ? asset(Storage::url('public/img/peserta/foto/').$data->foto) : asset('/assets/images/x.png')); ?>" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="<?php echo e(isset($data->KTA) ? asset(Storage::url('public/img/peserta/kta/').$data->KTA) : asset('/assets/images/x.png')); ?>" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="<?php echo e(isset($data->asuransi_kesehatan) ? asset(Storage::url('public/img/peserta/asuransi-kesehatan/').$data->asuransi_kesehatan) : asset('/assets/images/x.png')); ?>" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                        <td class="border p-2" style="width: 100%;">
                                            <img style="border-radius: 10px;" src="<?php echo e(isset($data->sertif_sfh) ? asset(Storage::url('public/img/peserta/sertif-sfh/').$data->sertif_sfh) : asset('/assets/images/x.png')); ?>" id="formrow-foto-input" width="100px" height="100px" alt="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<!-- Start Verifikasi Modal -->
<div class="modal fade" id="modal-verifikasi-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Verifikasi Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('peserta.verifikasi', $data->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
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
<script src="<?php echo e(URL::asset('/assets/libs/select2/select2.min.js')); ?>"></script>
<!-- Datatable init js -->
<script src="<?php echo e(URL::asset('/assets/js/pages/datatables.init.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\raida-jabar-2024\resources\views/peserta/index.blade.php ENDPATH**/ ?>