<form action="<?php echo e(route('admin-settings.update',$data->id)); ?>" method="post" class="needs-validation" novalidate>
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
    <div class="modal-body">
        <div class="mb-3">
            <label for="validationCustom02" class="form-label">Value</label>
            <input type="text" class="form-control" id="validationCustom02" value="<?php echo e($data->value); ?>" name="value" required>
            <div class="valid-feedback">
                Looks good!
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save Changes</button>
    </div>
</form><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/settingApp/edit.blade.php ENDPATH**/ ?>