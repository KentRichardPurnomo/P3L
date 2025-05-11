

<?php $__env->startSection('content'); ?>
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Profil Penitip</h2>

    <form action="<?php echo e(route('penitip.profil.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <?php echo csrf_field(); ?>

        <div>
            <label>Username</label>
            <input type="text" name="username" value="<?php echo e($penitip->username); ?>"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label>No. Telepon</label>
            <input type="text" name="no_telp" value="<?php echo e($penitip->no_telp); ?>"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label>Ganti Foto Profil</label>
            <input type="file" name="foto" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-penitip', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/penitip/profil-edit.blade.php ENDPATH**/ ?>