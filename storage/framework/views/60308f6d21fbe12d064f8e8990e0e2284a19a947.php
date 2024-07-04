<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"><?php echo e($title); ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/"><?php echo e($li_1); ?></a></li>
                    <?php if(isset($title)): ?>
                        <li class="breadcrumb-item active"><?php echo e($title); ?></li>
                    <?php endif; ?>
                    <?php if(isset($title2)): ?>
                        <li class="breadcrumb-item active"><?php echo e($title2); ?></li>
                    <?php endif; ?>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title --><?php /**PATH C:\xampp\htdocs\raida-jabar-2024\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>