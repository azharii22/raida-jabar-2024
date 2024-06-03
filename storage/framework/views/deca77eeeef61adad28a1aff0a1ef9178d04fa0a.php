<form action="<?php echo e(route('admin-kegiatan.update', $data->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-body">
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Judul</label>
            <input name="judul" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->judul); ?>" required>
        </div>
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Item Giat</label>
            <input name="item_giat" type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->item_giat); ?>" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
    </div>
</form><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/kegiatan/edit.blade.php ENDPATH**/ ?>