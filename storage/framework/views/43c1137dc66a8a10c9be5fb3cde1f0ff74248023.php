

<?php 
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    $pembeli = Auth::guard('pembeli')->user();
?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex flex-col md:flex-row gap-6">

        <!-- FOTO PRODUK -->
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

        <!-- INFO PRODUK -->
        <div class="flex-1">
            <h1 class="text-2xl font-bold mb-2"><?php echo e($barang->nama); ?></h1>
            <p class="text-xl text-orange-600 font-semibold mb-4">Rp <?php echo e(number_format($barang->harga, 0, ',', '.')); ?></p>

            <p class="mb-2"><strong>Kategori:</strong>
                <a href="<?php echo e(route('kategori.show', $barang->kategori->id)); ?>" class="text-blue-600 underline">
                    <?php echo e($barang->kategori->nama); ?>

                </a>
            </p>

            <p class="mb-2"><strong>Deskripsi:</strong></p>
            <p class="text-sm text-gray-700 mb-4"><?php echo e($barang->deskripsi); ?></p>

            <p><strong>Garansi:</strong>
                <?php if($barang->garansi_berlaku_hingga && $barang->garansi_berlaku_hingga->isFuture()): ?>
                    Ada (aktif hingga <?php echo e($barang->garansi_berlaku_hingga->translatedFormat('d F Y')); ?>)
                <?php else: ?>
                    Tidak Ada
                <?php endif; ?>
            </p>

            <p><strong>Status:</strong> <?php echo e($barang->terjual ? 'Sudah Terjual' : 'Tersedia'); ?></p>
        </div>

        <!-- CARD AKSI -->
        <div class="md:w-1/4">
            <div class="bg-white p-4 rounded shadow space-y-3 sticky top-24">
                <h1 class="text-2xl font-bold mb-2"><?php echo e($barang->nama); ?></h1>
            <p class="text-xl text-orange-600 font-semibold mb-4">Rp <?php echo e(number_format($barang->harga, 0, ',', '.')); ?></p>
                <?php if($pembeli): ?>
                    <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">+ Keranjang</button>
                    <button class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Beli Sekarang</button>
                <?php else: ?>
                    <button onclick="showLoginPrompt()"
                            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">+ Keranjang</button>
                    <button onclick="showLoginPrompt()"
                            class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Beli Sekarang</button>
                <?php endif; ?>

                <!-- Bagikan bisa siapa saja -->
                <button onclick="copyProductLink()"
                        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Bagikan</button>

                <button onclick="document.getElementById('diskusi').scrollIntoView({ behavior: 'smooth' });"
                        class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700">Diskusi</button>
            </div>
        </div>
    </div>

    <!-- DISKUSI -->
    <div id="diskusi" class="mt-12 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Diskusi & Pertanyaan</h2>

        <?php if($pembeli && !$userDiskusi): ?>
            <div class="flex items-center justify-between mb-4 bg-yellow-100 text-yellow-800 p-4 rounded">
                <p>Punya pertanyaan? Langsung diskusi dengan penjual saja</p>
                <button onclick="document.getElementById('diskusiForm').scrollIntoView({ behavior: 'smooth' });"
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                    Mulai Diskusi
                </button>
            </div>
        <?php elseif(!$pembeli): ?>
            <div class="flex items-center justify-between mb-4 bg-yellow-100 text-yellow-800 p-4 rounded">
                <p>Punya pertanyaan? Langsung diskusi dengan penjual saja</p>
                <button onclick="showLoginPrompt()"
                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                    Mulai Diskusi
                </button>
            </div>
        <?php endif; ?>

        <?php if($pembeli): ?>
        <form id="diskusiForm" action="<?php echo e(route('diskusi.store')); ?>" method="POST" class="mb-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="barang_id" value="<?php echo e($barang->id); ?>">
            <textarea name="isi" rows="3" class="w-full border rounded p-2"
                      placeholder="Tulis pertanyaan atau komentar..."></textarea>
            <button type="submit" class="mt-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Kirim</button>
        </form>
        <?php endif; ?>

        <?php $__currentLoopData = $barang->diskusis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diskusi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border-t py-2">
                <strong><?php echo e($diskusi->user->name); ?></strong>
                <span class="text-sm text-gray-500"><?php echo e($diskusi->created_at->diffForHumans()); ?></span>
                <p class="text-sm"><?php echo e($diskusi->isi); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- REKOMENDASI -->
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-4">Barang Serupa dari Kategori <?php echo e($barang->kategori->nama); ?></h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $rekomendasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('barang.show', $item->id)); ?>" class="bg-white rounded shadow hover:shadow-lg transition p-4">
                <img src="<?php echo e(asset('images/barang/' . $item->id . '/' . $item->thumbnail)); ?>"
                    class="w-full h-40 object-cover rounded mb-2">
                <h3 class="text-sm font-semibold"><?php echo e($item->nama); ?></h3>
                <p class="text-orange-600 font-bold text-sm">Rp <?php echo e(number_format($item->harga, 0, ',', '.')); ?></p>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500 italic">Belum ada barang lain di kategori ini.</p>
            <?php endif; ?>
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

<!-- MODAL LOGIN -->
<div id="loginPromptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white w-96 rounded-lg p-6 shadow-lg text-center">
        <h2 class="text-lg font-bold mb-2 text-gray-800">Anda belum login</h2>
        <p class="text-sm text-gray-600 mb-6">Login dulu yuk untuk bisa akses fitur ini.</p>
        <div class="flex justify-between space-x-2">
            <a href="<?php echo e(route('pembeli.login.form')); ?>" class="flex-1 bg-green-600 text-white py-2 rounded hover:bg-green-700">Login</a>
            <a href="<?php echo e(route('pembeli.register.form')); ?>" class="flex-1 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Daftar</a>
            <button onclick="closeLoginPrompt()" class="flex-1 bg-gray-300 text-black py-2 rounded hover:bg-gray-400">Nanti saja</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\abhin\OneDrive\Documents\Tugas\P3L\reusemart\resources\views/barang/show.blade.php ENDPATH**/ ?>