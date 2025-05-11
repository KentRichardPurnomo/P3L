

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-12 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Reset Password</h2>
    <h1 class="text-xl mb-4">Link Sudah Dikirim Ke Email Anda</h1>


    <?php if(session('password_info')): ?>
        <div class="mb-4 text-sm text-green-600">
            <?php echo e(session('password_info')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('pembeli.reset')); ?>">
        <?php echo csrf_field(); ?>
        <input type="email" name="email"
            value="<?php echo e(session('reset_email')); ?>"
            class="w-full border p-2 mb-3 rounded bg-gray-100"
            readonly>

        <input type="password" name="password" placeholder="Password Baru" required
               class="w-full border p-2 mb-3 rounded">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
               class="w-full border p-2 mb-4 rounded">

        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Simpan Password Baru
        </button>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/auth/pembeli/reset-password.blade.php ENDPATH**/ ?>