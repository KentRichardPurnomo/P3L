

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Daftar Pembeli</h2>
    <form method="POST" action="<?php echo e(route('pembeli.register')); ?>">
        <?php echo csrf_field(); ?>
        <input type="text" name="username" placeholder="Username"
               class="w-full border p-2 mb-3 rounded" required>
        <input type="email" name="email" placeholder="Email"
               class="w-full border p-2 mb-3 rounded" required>
        <input type="text" name="no_telp" placeholder="No. Telepon"
               class="w-full border p-2 mb-3 rounded" required>
        <input type="password" name="password" placeholder="Password"
               class="w-full border p-2 mb-3 rounded" required>
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
               class="w-full border p-2 mb-4 rounded" required>
        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Daftar
        </button>
    </form>

    <!-- Tambahan: Belum punya akun -->
    <p class="text-sm text-center mt-4">
        Sudah Punya Akun?
        <a href="<?php echo e(route('pembeli.login.form')); ?>" class="text-blue-600 hover:underline">
            Login
        </a>
    </p>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/auth/pembeli/register.blade.php ENDPATH**/ ?>