

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Daftar Akun Baru</h2>

    <?php if(session('success')): ?>
        <div class="mb-4 text-green-700 bg-green-100 px-4 py-2 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-4 text-red-600 bg-red-100 px-4 py-2 rounded">
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('register.all.submit')); ?>">
        <?php echo csrf_field(); ?>

        <input type="text" name="username" placeholder="Username"
               class="w-full border p-2 mb-3 rounded" required>

        <input type="email" name="email" placeholder="Email"
               class="w-full border p-2 mb-3 rounded" required>

        <input type="text" name="no_telp" placeholder="No Telepon"
               class="w-full border p-2 mb-3 rounded" required>

        <input type="password" name="password" placeholder="Password"
               class="w-full border p-2 mb-3 rounded" required>

        <select name="role" class="w-full border p-2 mb-4 rounded" required>
            <option value="">-- Pilih Role --</option>
            <option value="pembeli">Pembeli</option>
            <option value="organisasi">Organisasi</option>
        </select>

        <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Daftar
        </button>

        <div class="mt-4 text-center">
            <p>Sudah punya akun?
                <a href="<?php echo e(route('login.universal')); ?>" class="text-blue-600 hover:underline">Login di sini</a>
            </p>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-logreg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/auth/registerAll.blade.php ENDPATH**/ ?>