<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - ReuseMart</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?> <!-- Jika pakai Vite & Tailwind -->
</head>
<body class="p-10">
    <h1 class="text-2xl font-bold mb-6">Daftar Akun Baru</h1>

    <?php if($errors->any()): ?>
        <div class="bg-red-100 text-red-600 p-4 mb-4">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>- <?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('register.custom')); ?>" method="POST" class="space-y-4">
        <?php echo csrf_field(); ?>

        <div>
            <label>Username</label>
            <input type="text" name="username" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" class="border p-2 w-full" required>
        </div>

        <div>
            <label>No Telepon</label>
            <input type="text" name="no_telp" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password" class="border p-2 w-full" required>
        </div>

        <div>
            <label>Daftar Sebagai</label>
            <select name="role" class="border p-2 w-full" required>
                <option value="">-- Pilih Role --</option>
                <option value="pembeli">Pembeli</option>
                <option value="organisasi">Organisasi</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2">Daftar</button>
    </form>
</body>
</html>
<?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/auth/register.blade.php ENDPATH**/ ?>