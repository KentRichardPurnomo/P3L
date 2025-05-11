

<?php $__env->startSection('content'); ?>

<!-- Navigasi kategori teks -->
<div class="bg-orange-100 text-sm px-6 py-2 flex justify-center space-x-6 overflow-x-auto sticky top-[96px] z-30">
    <?php
        $tags = ['Kipas Angin', 'Tas Selempang', 'Headset Bluetooth', 'Kaos Pria', 'Kacamata', 'Daster Kekinian', 'Meja'];
    ?>
    <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('search', ['search' => $tag])); ?>" class="hover:underline text-green-800 font-medium">
            <?php echo e($tag); ?>

        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<!-- Banner utama -->
<div class="flex flex-col md:flex-row gap-1 px-20 pt-2 pb-4">
    <div class="md:w-3/4 flex justify-center">
        <img src="<?php echo e(asset('images/banner-besar.jpg')); ?>" alt="Banner" class="w-[70%] rounded shadow" />
    </div>
    <div class="md:w-1/3 flex flex-col items-center gap-6">
        <img src="<?php echo e(asset('images/banner-kecil-1.jpg')); ?>" alt="Promo 1" class="w-[75%] rounded shadow" />
        <img src="<?php echo e(asset('images/banner-kecil-2.jpg')); ?>" alt="Promo 2" class="w-[75%] rounded shadow" />
    </div>
</div>

<!-- Ikon layanan -->
<div class="grid grid-cols-4 md:grid-cols-8 gap-4 px-6 py-4 bg-white text-center">
    <div><img src="<?php echo e(asset('images/ico1.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Baru Masuk</p></div>
    <div><img src="<?php echo e(asset('images/ico2.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Elektronik</p></div>
    <div><img src="<?php echo e(asset('images/ico3.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Hobi & Game</p></div>
    <div><img src="<?php echo e(asset('images/ico4.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Fashion</p></div>
    <div><img src="<?php echo e(asset('images/ico5.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Perkakas</p></div>
    <div><img src="<?php echo e(asset('images/ico6.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Olahraga</p></div>
    <div><img src="<?php echo e(asset('images/ico7.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Perabotan Rumah</p></div>
    <div><img src="<?php echo e(asset('images/ico8.png')); ?>" class="mx-auto h-12"><p class="text-xs mt-2">Dekorasi</p></div>
</div>

<!-- Kategori utama -->
<section class="p-8 bg-white mt-4">
    <h2 class="text-3xl font-bold mb-7">KATEGORI</h2>
    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-5 text-center">
        <?php $__currentLoopData = $kategoris; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('kategori.show', $kategori->id)); ?>">
            <div>
                <img src="<?php echo e(asset('images/' . strtolower(str_replace(' ', '-', $kategori->nama)) . '.jpg')); ?>"
                     class="w-20 h-20 mx-auto rounded-full shadow">
                <p class="mt-2 text-sm"><?php echo e($kategori->nama); ?></p>
            </div>
        </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>

<!-- Produk -->
<section class="p-6">
    <?php if(request('search')): ?>
        <h1 class="text-2xl font-bold mb-2">Hasil pencarian untuk: "<?php echo e(request('search')); ?>"</h1>
    <?php else: ?>
        <h1 class="text-4xl font-bold mb-4">Produk Terbaru</h1>
    <?php endif; ?>

    <?php if($barangs->count()): ?>
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
    <?php else: ?>
        <p class="text-gray-500">Tidak ada produk ditemukan.</p>
    <?php endif; ?>
</section>

<div class="text-center mt-6">
    <a href="<?php echo e(route('produk.index')); ?>" class="inline-block bg-green-600 text-white px-6 py-3 rounded hover:bg-green-700">
        Lihat Produk Lainnya
    </a>
</div>

<!-- Script untuk trigger pencarian -->
<script>
    function triggerSearch(keyword) {
        const input = document.querySelector('input[placeholder="Cari produk"]');
        const cards = document.querySelectorAll('.product-card');
        input.value = keyword;

        cards.forEach(card => {
            const name = card.getAttribute('data-nama');
            if (name.includes(keyword.toLowerCase())) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Atma\Sem 6\P3L\Project\reusemart\resources\views/home.blade.php ENDPATH**/ ?>