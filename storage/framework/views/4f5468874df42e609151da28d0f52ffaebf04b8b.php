

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Profil Pembeli</h2>

    <form action="<?php echo e(route('pembeli.profil.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
        <?php echo csrf_field(); ?>

        <div>
            <label class="block text-sm mb-1">Username</label>
            <input type="text" name="username" value="<?php echo e($pembeli->username); ?>"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="<?php echo e($pembeli->email); ?>"
                   class="w-full border px-3 py-2 rounded bg-gray-100" readonly>
        </div>

        <div>
            <label class="block text-sm mb-1">No. Telepon</label>
            <input type="text" name="no_telp" value="<?php echo e($pembeli->no_telp); ?>"
                   class="w-full border px-3 py-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm mb-1">Ganti Foto Profil</label>
            <input type="file" name="foto" class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Simpan Perubahan
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/pembeli/edit.blade.php ENDPATH**/ ?>