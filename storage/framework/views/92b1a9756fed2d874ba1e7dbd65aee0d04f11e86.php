

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded shadow space-y-8">

    
    <div class="flex items-center space-x-4">
        <img src="<?php echo e($penitip->profile_picture ? asset('storage/' . $penitip->profile_picture) : asset('images/default-user.png')); ?>"
             class="w-24 h-24 rounded-full object-cover border">
        <div>
            <h2 class="text-xl font-bold">Username : <?php echo e($penitip->username); ?></h2>
            <p><i class="fas fa-envelope mr-1"></i>Email✉️ : <?php echo e($penitip->email); ?></p>
            <p><i class="fas fa-phone mr-1"></i>No Telp☎️ : <?php echo e($penitip->no_telp); ?></p>
        </div>
    </div>

    
    <div class="mt-3">
        <a href="<?php echo e(route('penitip.profil.edit')); ?>"
        class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
        Edit Profil
        </a>
    </div>

    
    <div>
        <h3 class="text-lg font-semibold mb-3">Barang yang Sedang Dititipkan</h3>
        <?php if($barangAktif->isEmpty()): ?>
            <p class="text-sm text-gray-500">Tidak ada barang aktif saat ini.</p>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $barangAktif; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('penitip.barang.show', $barang->id)); ?>"class="border rounded p-3 hover:shadow transition">
                        <img src="<?php echo e(asset('images/barang/' . $barang->id . '/' . $barang->thumbnail)); ?>"
                             class="w-full h-32 object-cover rounded mb-2">
                        <h4 class="font-semibold text-sm"><?php echo e($barang->nama); ?></h4>
                        <p class="text-sm text-gray-600">Rp <?php echo e(number_format($barang->harga, 0, ',', '.')); ?></p>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    
    <div>
        <h3 class="text-lg font-semibold mb-3 mt-8">Riwayat Barang yang Sudah Terjual</h3>
        <?php if($barangTerjual->isEmpty()): ?>
            <p class="text-sm text-gray-500">Belum ada barang yang terjual.</p>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <?php $__currentLoopData = $barangTerjual; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('barang.show', $barang->id)); ?>" class="border rounded p-3 hover:shadow transition">
                        <img src="<?php echo e(asset('images/barang/' . $barang->id . '/' . $barang->thumbnail)); ?>"
                             class="w-full h-32 object-cover rounded mb-2">
                        <h4 class="font-semibold text-sm"><?php echo e($barang->nama); ?></h4>
                        <p class="text-sm text-gray-600">Rp <?php echo e(number_format($barang->harga, 0, ',', '.')); ?></p>
                        <span class="text-xs text-red-600 font-medium">✅ Sudah Terjual</span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-penitip', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/penitip/dashboard.blade.php ENDPATH**/ ?>