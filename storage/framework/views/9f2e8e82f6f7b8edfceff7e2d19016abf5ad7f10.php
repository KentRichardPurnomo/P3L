<?php
    $pembeli = Auth::guard('pembeli')->user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ReuseMart</title>
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
</head>

    <!-- Topbar -->
    <div class="bg-green-600 text-white sticky top-0 z-50 text-sm flex justify-between px-4 py-2">
        <div class="flex space-x-2 items-center">
            <a href="<?php echo e(route('bantuan')); ?>" class="flex items-center space-x-2 font-bold hover:underline transition">
                <img src="<?php echo e(asset('images/customer-service.jpg')); ?>" alt="Customer Service" class="w-8 h-8 object-cover rounded-full hover:scale-105 transition" />
                <span>Bantuan</span>
            </a>
        </div>
    </div>

    <!-- Header utama -->
    <header class="bg-green-500 text-white sticky top-[32px] z-40 flex items-center justify-between px-6 py-3 shadow">
        <!-- Logo -->
        <a href="<?php echo e(url('/')); ?>" class="flex items-center space-x-3">
            <img src="<?php echo e(asset('images/logo-reusemart.png')); ?>" alt="ReuseMart Logo" class="h-12">
            <div class="text-2xl md:text-3xl font-bold">ReuseMart</div>
        </a>
    </header>

    <!-- Konten -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-green-600 text-white px-2 py-10 mt-32">
        <div class="max-w-5xl mx-auto text-center space-y-4">
            <h2 class="text-2xl font-bold">Tentang ReuseMart</h2>
            <p class="text-sm text-white">
                ReuseMart adalah platform jual beli barang bekas berkualitas, dengan sistem terpercaya dan terintegrasi.
                Temukan berbagai produk second-hand dari kategori Elektronik, Fashion, Perabotan, dan banyak lagi!
            </p>
            <div class="text-sm mt-4">
                🎁 <strong>Promosi:</strong> Gratis ongkir untuk pembelian di atas Rp 1.000.000  
                <br>
                ⭐ <strong>Loyalty Program:</strong> Kumpulkan poin dan tukarkan dengan hadiah menarik!
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            const input = document.getElementById('searchInput');
            if (!input.value.trim()) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
<?php /**PATH D:\Atma\Sem 6\P3L\Project\reusemart\resources\views/layouts/app-logreg.blade.php ENDPATH**/ ?>