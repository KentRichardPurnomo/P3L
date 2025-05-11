

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Dashboard Organisasi</h2>

    <div class="flex items-center gap-6 mb-6">
        <img src="<?php echo e(asset('storage/' . $organisasi->foto_profil)); ?>" alt="Foto Profil"
             class="w-20 h-20 rounded-full object-cover">
        <div>
            <p><strong>Nama Organisasi:</strong> <?php echo e($organisasi->username); ?></p>
            <p><strong>Email:</strong> <?php echo e($organisasi->email); ?></p>
            <p><strong>No. Telepon:</strong> <?php echo e($organisasi->no_telp); ?></p>
        </div>
    </div>

    <a href="<?php echo e(route('organisasi.request.create')); ?>"
       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-6 inline-block">
        + Request Donasi
    </a>

    <h3 class="text-xl font-semibold mt-6 mb-2">Request Donasi dari Organisasi Lain</h3>
    <ul class="space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $allRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <li class="border p-3 rounded bg-gray-50">
                <p><strong>Jenis Barang:</strong> <?php echo e($req->jenis_barang); ?></p>
                <p><strong>Alasan:</strong> <?php echo e($req->alasan); ?></p>
                <p class="text-sm text-gray-500">Dikirim oleh Organisasi ID: <?php echo e($req->organisasi_id); ?></p>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500">Belum ada request dari organisasi lain.</p>
        <?php endif; ?>
    </ul>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\kpken\Documents\GitHub\P3L\resources\views/organisasi/dashboard.blade.php ENDPATH**/ ?>