

<?php $__env->startSection('title', 'User'); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> User <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title mb-5">User Management</h4>

                <div class="card-title mb-5">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm mr-2" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-plus"></i> Add User </button>
                        <div class="dropdown-menu">
                            <div class="p-3">
                                <p class="mb-0">
                                    Pilih Salah Satu User Di Bawah ini!
                                </p>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo e(route('createDkd')); ?>"><i class="bx bx-plus"></i> Add User DKD</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo e(route('createDkc')); ?>"><i class="bx bx-plus"></i> Add User DKC</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo e(route('createDkr')); ?>"><i class="bx bx-plus"></i> Add User DKR</a>
                            <div class="dropdown-divider"></div>
                        </div>
                    </div>
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

                <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Fullname</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Tempat Tanggal Lahir</th>
                            <th class="text-center">Avatar</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Region</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>


                    <tbody>
                        <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e(++$key); ?></td>
                            <td class="text-center"><?php echo e($data->name); ?></td>
                            <td class="text-center"><?php echo e($data->fullname); ?></td>
                            <td class="text-center">
                                <a href="mailto:<?php echo e($data->email); ?>">
                                    <?php echo e($data->email); ?>

                            </td>
                            </a>
                            <td class="text-center"><?php echo e($data->pob); ?>, <?php echo e(date('d-M-Y', strtotime($data->dob))); ?></td>
                            <td class="text-center">
                                <a href="<?php echo e($data->avatar); ?>" target="_blank">
                                    <img class="rounded-circle header-profile-user" src="<?php echo e(isset(Auth::user()->avatar) ? asset(Auth::user()->avatar) : asset('/assets/images/users/avatar-1.jpg')); ?>" />
                                </a>
                            </td>
                            <td class="text-center "><?php echo e($data->role->name); ?></td>
                            <td class="text-center ">
                                <?php if($data->role_id === 1): ?>
                                    -
                                <?php elseif($data->role_id == 3): ?>
                                <?php echo e($data->regency?->name); ?>

                                
                                <?php elseif($data->role_id == 2): ?>
                                <?php echo e($data->villages?->name); ?>, <?php echo e($data->regency?->name); ?>

                            </td>
                                
                                <?php endif; ?>
                            <td class="text-center">
                                <button onclick="editModal(<?php echo e(json_encode($data->id)); ?>)" type="button" class="btn btn-warning btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-edit-<?php echo e($data->id); ?>" ><i class=" bx bx-pencil"></i> Edit</button>
                                <button type="button" class="btn btn-danger btn-sm mr-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modal-delete-<?php echo e($data->id); ?>"><i class=" bx bx-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div> <!-- end col -->
</div>

<!-- Start Edit Modal -->
<?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="modal fade" id="modal-edit-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-user.update', $data->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Name</label>
                                <input name="name" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->name); ?>" placeholder="Nama" required>
                                <div class="valid-feedback">
                                    Nama Harus Diisi!
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Fullname</label>
                                <input name="fullname" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->fullname); ?>" placeholder="Nama Lengkap" required>
                                <div class="valid-feedback">
                                    Fullname Harus Diisi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" id="validationCustom02" value="<?php echo e($data->email); ?>" placeholder="Email" required>
                                <div class="valid-feedback">
                                    Email Harus Diisi!
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Role User</label>
                                <select name="role_id" class="form-control" id="validationCustom02">
                                    <option disabled selected>---Pilih Role User ---</option>
                                    <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php echo e($item->id == $data->role_id ? 'selected' : ''); ?>><?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="valid-feedback">
                                    Role Harus Diisi!
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir</label>
                                <div class="input-group">
                                    <input name="pob" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->pob); ?>">
                                    <input name="dob" type="date" class="form-control" id="validationCustom02" value="<?php echo e(date('Y-m-d', strtotime($data->dob))); ?>">
                                    <div class="valid-feedback">
                                        Tempat Tanggal Lahir Harus Diisi!
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label">Region</label>
                                <select name="regency_id" class="form-select select2" id="editSelect2<?php echo e($data->id); ?>">
                                    <option disabled selected>---Pilih Region User ---</option>
                                    <?php $__currentLoopData = $region; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if($data->regency_id == $item->id ): echo 'selected'; endif; ?>> <?php echo e($item->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="validationCustom02" class="form-label">Photo</label>
                                <input name="avatar" type="file" class="form-control" id="validationCustom02">
                            </div>
                        </div>
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
<!-- End Edit Modal -->

<!-- Start Delete Modal -->
<div class="modal fade" id="modal-delete-<?php echo e($data->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin-user.destroy', $data->id)); ?>" method="POST">
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
    <script src="<?php echo e(URL::asset('/assets/libs/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/datatables/datatables.min.js')); ?>"></script>
    <!-- form advanced init -->
    <script src="<?php echo e(URL::asset('/assets/js/pages/datatables.init.js')); ?>"></script>
<script>
    $('#mySelect2').select2({
        dropdownParent: $('#modal-add'),
        width: '100%'
    });
</script>
<script>
    function editModal(id){
        let id_modal = id;
        $('#editSelect2' + id_modal).select2({
            dropdownParent: $('#modal-edit-'+id_modal ),
            width: '100%'
         });
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/user/index.blade.php ENDPATH**/ ?>