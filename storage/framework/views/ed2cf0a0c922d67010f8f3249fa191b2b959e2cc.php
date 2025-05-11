

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    
    <div class="mb-4">
        <a href="<?php echo e(url()->previous()); ?>"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <h2 class="text-2xl font-bold mb-4"><?php echo e($barang->nama); ?></h2>

    <div class="flex flex-col md:flex-row gap-6">
        
        <div class="flex-1">
            <img id="mainImage"
                 src="<?php echo e(asset('images/barang/' . $barang->id . '/' . $barang->thumbnail)); ?>"
                 class="w-full rounded shadow mb-4 object-contain max-h-[500px]">

            <div class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                <img onclick="changeMainImage(this)"
                     src="<?php echo e(asset('images/barang/' . $barang->id . '/' . $barang->thumbnail)); ?>"
                     class="h-24 w-full object-cover cursor-pointer border-2 border-green-500 rounded">

                <?php $__currentLoopData = json_decode($barang->foto_lain); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img onclick="changeMainImage(this)"
                     src="<?php echo e(asset('images/barang/' . $barang->id . '/' . $foto)); ?>"
                     class="h-24 w-full object-cover cursor-pointer rounded hover:ring-2 ring-green-400">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="md:w-1/2 space-y-3">
            <p><strong>Harga:</strong> Rp <?php echo e(number_format($barang->harga, 0, ',', '.')); ?></p>
            <p><strong>Kategori:</strong> <?php echo e($barang->kategori->nama); ?></p>
            <p><strong>Deskripsi:</strong></p>
            <p class="text-gray-700"><?php echo e($barang->deskripsi); ?></p>

            <p><strong>Garansi:</strong>
                <?php if($barang->garansi && $barang->garansi_berlaku_hingga && \Carbon\Carbon::now()->lt($barang->garansi_berlaku_hingga)): ?>
                    Aktif hingga <?php echo e(\Carbon\Carbon::parse($barang->garansi_berlaku_hingga)->format('d M Y')); ?>

                <?php else: ?>
                    Tidak ada
                <?php endif; ?>
            </p>

            <p><strong>Status:</strong>
                <?php if($barang->terjual): ?>
                    <span class="text-red-600">Sudah Terjual</span>
                <?php else: ?>
                    <span class="text-green-600">Belum Terjual</span>
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
    function changeMainImage(thumbnail) {
        const mainImage = document.getElementById('mainImage');
        mainImage.src = thumbnail.src;
    }

    function copyProductLink() {
        const dummy = document.createElement('input');
        dummy.value = window.location.href;
        document.body.appendChild(dummy);
        dummy.select();
        document.execCommand('copy');
        document.body.removeChild(dummy);
        alert('Link produk berhasil disalin!');
    }

    function showLoginPrompt() {
        document.getElementById('loginPromptModal').classList.remove('hidden');
    }

    function closeLoginPrompt() {
        document.getElementById('loginPromptModal').classList.add('hidden');
    }
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app-penitip', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/penitip/barang-show.blade.php ENDPATH**/ ?>