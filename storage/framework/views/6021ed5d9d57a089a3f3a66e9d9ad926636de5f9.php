<form action="<?php echo e(route('admin-dokumen-penting.update', $data->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-body">
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Nama</label>
            <input name="name" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->name); ?>" required>
        </div>
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">File</label>
            <input name="file" type="file" class="form-control" id="validationCustom02" required accept=".pdf">
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
    </div>
</form><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/dokumenPenting/edit.blade.php ENDPATH**/ ?>