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
</form><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/user/edit.blade.php ENDPATH**/ ?>