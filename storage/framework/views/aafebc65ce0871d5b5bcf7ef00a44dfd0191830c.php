

<?php $__env->startSection('content'); ?>
<section class="p-6">
    <h1 class="text-3xl font-bold mb-6">Semua Produk</h1>

    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-6">
        <?php $__currentLoopData = $barangs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $barang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('barang.show', $barang->id)); ?>" class="bg-white rounded shadow hover:shadow-lg transition p-4">
            <img src="<?php echo e(asset('images/barang/' . $barang->id . '/' . $barang->thumbnail)); ?>"
                 class="w-full h-40 object-cover rounded mb-2">
            <h3 class="text-sm font-semibold"><?php echo e($barang->nama); ?></h3>
            <p class="text-orange-600 font-bold text-sm">Rp <?php echo e(number_format($barang->harga, 0, ',', '.')); ?></p>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($barangs->links()); ?>

    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/produk/index.blade.php ENDPATH**/ ?>