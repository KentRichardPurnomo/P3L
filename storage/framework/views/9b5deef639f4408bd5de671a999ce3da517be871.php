

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold mb-4">Login Pembeli</h2>

    <?php if(session('password_info')): ?>
        <script>alert("<?php echo e(session('password_info')); ?>");</script>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <strong>Oops!</strong> <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>


    <!-- Form Login -->
    <form method="POST" action="<?php echo e(route('pembeli.login')); ?>">
        <?php echo csrf_field(); ?>
        <input type="email" name="email" placeholder="Email"
               class="w-full border p-2 mb-3 rounded" required>

        <input type="password" name="password" placeholder="Password"
               class="w-full border p-2 mb-4 rounded" required>

        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Login
        </button>
    </form>

    <!-- Garis pembatas -->
    <div class="my-4 text-center text-sm text-gray-500">Atau</div>

    <!-- Form Lupa Password -->
    <form method="POST" action="<?php echo e(route('pembeli.lupa.password')); ?>">
        <?php echo csrf_field(); ?>
        <input type="email" name="email" placeholder="Masukkan email untuk reset password"
               class="w-full border p-2 mb-3 rounded" required>

        <button class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
            Lupa Password?
        </button>
    </form>

    <!-- Tambahan: Belum punya akun -->
    <p class="text-sm text-center mt-4">
        Belum punya akun?
        <a href="<?php echo e(route('pembeli.register.form')); ?>" class="text-blue-600 hover:underline">
            Daftar dahulu
        </a>
    </p>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/auth/pembeli/login.blade.php ENDPATH**/ ?>