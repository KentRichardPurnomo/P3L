

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Request Donasi</h2>

    <form method="POST" action="<?php echo e(route('organisasi.request.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-4">
            <label class="block mb-1">Jenis Barang yang Dibutuhkan</label>
            <input type="text" name="jenis_barang" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1">Deskripsi Alasan</label>
            <textarea name="alasan" rows="4" class="w-full border p-2 rounded" required></textarea>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Kirim Request
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Atma\Sem 6\P3L\Project\reusemart\resources\views/organisasi/request_create.blade.php ENDPATH**/ ?>