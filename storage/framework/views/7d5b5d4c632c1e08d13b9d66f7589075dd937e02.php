

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow space-y-6">

    <h2 class="text-xl font-bold mb-4">Profil Pembeli</h2>

    
    <div class="flex items-center space-x-6">
        <img src="<?php echo e($pembeli->profile_picture ? asset('storage/' . $pembeli->profile_picture) : asset('images/default-user.png')); ?>"
             class="w-24 h-24 rounded-full object-cover border">
        <div class="space-y-1 text-sm text-gray-800">
            <p><strong>Nama:</strong> <?php echo e($pembeli->username); ?></p>
            <p><strong>Email:</strong> <?php echo e($pembeli->email); ?></p>
            <p><strong>No. Telepon:</strong> <?php echo e($pembeli->no_telp); ?></p>
            <p><strong>Alamat Utama:</strong>
                <?php echo e($pembeli->defaultAlamat ? $pembeli->defaultAlamat->alamat : 'Belum ada alamat default'); ?>

            </p>
            <p><strong>Poin:</strong> 🎁 <?php echo e($pembeli->poin); ?> poin</p>
        </div>
    </div>

    
    <div class="mt-4">
        <a href="<?php echo e(route('pembeli.profil.edit')); ?>"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Edit Profil
        </a>
    </div>

    
    <div class="mt-10">
        <h3 class="text-lg font-semibold mb-3">Riwayat Pembelian</h3>

        <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <details class="mb-4 border rounded p-4 bg-white shadow">
                <summary class="cursor-pointer font-semibold text-green-700">
                    Transaksi #<?php echo e($transaksi->id); ?> – <?php echo e($transaksi->tanggal->format('d M Y H:i')); ?> – Rp <?php echo e(number_format($transaksi->total, 0, ',', '.')); ?>

                </summary>
                <ul class="mt-3 list-disc list-inside text-sm text-gray-700">
                    <?php $__currentLoopData = $transaksi->detail; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <?php echo e($item->barang->nama); ?> – <?php echo e($item->jumlah); ?> x Rp <?php echo e(number_format($item->barang->harga, 0, ',', '.')); ?> = <strong>Rp <?php echo e(number_format($item->subtotal, 0, ',', '.')); ?></strong>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </details>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-gray-500 italic">Belum ada riwayat pembelian.</p>
        <?php endif; ?>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/pembeli/profil.blade.php ENDPATH**/ ?>