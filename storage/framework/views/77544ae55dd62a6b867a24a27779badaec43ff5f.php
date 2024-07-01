

<?php $__env->startSection('title', 'User'); ?>

<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(URL::asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css')); ?>" rel="stylesheet" type="text/css">
    <link href="<?php echo e(URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?php echo e(URL::asset('/assets/libs/datepicker/datepicker.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php $__env->startComponent('components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?> Dashboard <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> User <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-5">Edit User Management</h4>

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

                    <form action="<?php echo e(route('admin-user.update', $user->id)); ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Name</label>
                                    <input name="name" type="text" class="form-control" id="validationCustom02" value="<?php echo e($user->name); ?>" placeholder="Nama" required>
                                    <div class="valid-feedback">
                                        Nama Harus Diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Fullname</label>
                                    <input name="fullname" type="text" class="form-control" id="validationCustom02" value="<?php echo e($user->fullname); ?>" placeholder="Nama Lengkap" required>
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
                                    <input name="email" type="email" class="form-control" id="validationCustom02" value="<?php echo e($user->email); ?>" placeholder="Email" required>
                                    <div class="valid-feedback">
                                        Email Harus Diisi!
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Tempat, Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input name="pob" type="text" class="form-control" id="validationCustom02" value="<?php echo e($user->pob); ?>" required placeholder="Tempat Lahir">
                                        <input name="dob" type="date" class="form-control" id="validationCustom02" value="<?php echo e(date('Y-m-d', strtotime($user->dob))); ?>" required>
                                        <div class="valid-feedback">
                                            Tempat Tanggal Lahir Harus Diisi!
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Regency</label>
                                    <select class="form-select" name="regency_id" id="selectRegency"></select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Villages</label>
                                    <select class="form-select" name="villages_id" id="selectVillages"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Photo</label>
                                    <input name="avatar" type="file" class="form-control" id="validationCustom02">
                                    <input name="role_id" value="<?php echo e($role->id); ?>" hidden>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5">
                            <a href="<?php echo e(route('admin-user.index')); ?>" class="btn btn-secondary waves-effect">Back</a>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- end select2 -->

        </div>


    </div>
    <!-- end row -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('/assets/libs/select2/select2.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/spectrum-colorpicker/spectrum-colorpicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/datepicker/datepicker.min.js')); ?>"></script>

    <!-- form advanced init -->
    <script src="<?php echo e(URL::asset('/assets/js/pages/form-advanced.init.js')); ?>"></script>
    <script>
        $(document).ready(function(){
            $("#selectRegency").select2({
                placeholder: "Select Regency",
                ajax: {
                    url: '/selectRegency',
                    processResults: function({data}){
                        return {
                            results: $.map(data, function(item){
                                return {
                                    id: item.id,
                                    text: item.name,
                                }
                            })
                        }
                    }
                }
            });
            $("#selectRegency").change(function(){
                let id = $('#selectRegency').val();

                $("#selectVillages").select2({
                    placeholder:'Select Villages',
                    ajax: {
                        url: "<?php echo e(url('selectVillages')); ?>-"+ id,
                        processResults: function({data}){
                            return {
                                results: $.map(data, function(item){
                                    return {
                                        id: item.id,
                                        text: item.name
                                    }
                                })
                            }
                        }
                    }
                });
            });
        });
        var selectedRegencyId = `<?php echo e($user->regency?->id); ?>`;
        var selectedVillagesId = `<?php echo e($user->villages?->id); ?>`;
        var selectedUserRegency = "<?php echo e($user->regency?->name); ?>";
        var selectedUserVillages = "<?php echo e($user->villages?->name); ?>";

        var option1 = new Option(selectedUserRegency, selectedRegencyId, true, true);
        $('#selectRegency').append(option1).trigger('change');
        var option2 = new Option(selectedUserVillages, selectedVillagesId, true, true);
        $('#selectVillages').append(option2).trigger('change');

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/user/editDkr.blade.php ENDPATH**/ ?>