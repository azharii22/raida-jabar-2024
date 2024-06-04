<table border="1" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th style="width: 10px;">No</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Kategori</th>
            <th>Status</th>
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
            <td><?php echo e($data->status?->name); ?></td>
            <td> <?php echo e($data->catatan); ?> </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH D:\WINDOWS\DOCUMENT\kerja\Azhari\Raida\resources\views/unsurKontingen/admin-excel.blade.php ENDPATH**/ ?>