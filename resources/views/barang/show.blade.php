@extends('layouts.app')

@php 
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Auth;
    $pembeli = Auth::guard('pembeli')->user();
@endphp



@section('content')
<div class="p-6">
    <div class="flex flex-col md:flex-row gap-6">

        <!-- FOTO PRODUK -->
        <div class="flex-1">
            <img id="mainImage"
                 src="{{ asset('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}"
                 class="w-full rounded shadow mb-4 object-contain max-h-[500px]">

            <div class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                <img onclick="changeMainImage(this)"
                     src="{{ asset('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}"
                     class="h-24 w-full object-cover cursor-pointer border-2 border-green-500 rounded">

                @foreach(json_decode($barang->foto_lain) as $foto)
                <img onclick="changeMainImage(this)"
                     src="{{ asset('images/barang/' . $barang->id . '/' . $foto) }}"
                     class="h-24 w-full object-cover cursor-pointer rounded hover:ring-2 ring-green-400">
                @endforeach
            </div>
        </div>

        <!-- INFO PRODUK -->
        <div class="flex-1">
            <h1 class="text-2xl font-bold mb-2">{{ $barang->nama }}</h1>
            <p class="text-xl text-orange-600 font-semibold mb-4">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>

            <p class="mb-2"><strong>Kategori:</strong>
                <a href="{{ route('kategori.show', $barang->kategori->id) }}" class="text-blue-600 underline">
                    {{ $barang->kategori->nama }}
                </a>
            </p>

            <p class="mb-2"><strong>Deskripsi:</strong></p>
            <p class="text-sm text-gray-700 mb-4">{{ $barang->deskripsi }}</p>

            <p><strong>Garansi:</strong>
                @if ($barang->garansi_berlaku_hingga && $barang->garansi_berlaku_hingga->isFuture())
                    Ada (aktif hingga {{ $barang->garansi_berlaku_hingga->translatedFormat('d F Y') }})
                @else
                    Tidak Ada
                @endif
            </p>

            <p><strong>Status:</strong> {{ $barang->terjual ? 'Sudah Terjual' : 'Tersedia' }}</p>
        </div>

        <!-- CARD AKSI -->
        <div class="md:w-1/4">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-800 p-2 rounded">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-100 text-red-800 p-2 rounded">
                        {{ session('error') }}
                    </div>
                @endif
            <div class="bg-white p-4 rounded shadow space-y-3 sticky top-24">
                <h1 class="text-2xl font-bold mb-2">{{ $barang->nama }}</h1>
            <p class="text-xl text-orange-600 font-semibold mb-4">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                @if ($pembeli)
                    <form method="POST" action="{{ route('keranjang.tambah', $barang->id) }}">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">+ Keranjang</button>
                    </form>
                    <button class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Beli Sekarang</button>
                @else
                    <button onclick="showLoginPrompt()"
                            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">+ Keranjang</button>
                    <button onclick="showLoginPrompt()"
                            class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Beli Sekarang</button>
                @endif

                <!-- Bagikan bisa siapa saja -->
                <button onclick="copyProductLink()"
                        class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Bagikan</button>

                <button onclick="document.getElementById('diskusi').scrollIntoView({ behavior: 'smooth' });"
                        class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700">Diskusi</button>
            </div>
        </div>
    </div>

    <!-- DISKUSI -->
    <div class="mt-10 bg-white p-6 rounded shadow">
        <h3 class="text-xl font-bold mb-4">Diskusi Produk</h3>

        @forelse($barang->diskusis as $diskusi)
            <div class="border-t pt-4 mt-4">
                <p><strong>{{ $diskusi->user->username }}</strong> <span class="text-sm text-gray-500">({{ $diskusi->created_at->diffForHumans() }})</span></p>
                <p class="mb-2 text-gray-700">{{ $diskusi->isi }}</p>

                @if($diskusi->balasan)
                    <div class="ml-4 p-3 bg-green-50 border-l-4 border-green-400 rounded text-sm">
                        <strong class="text-green-800">Balasan Anda:</strong>
                        <p class="text-gray-800">{{ $diskusi->balasan }}</p>
                    </div>
                @else
                    <form action="{{ route('penitip.diskusi.balas', $diskusi->id) }}" method="POST" class="mt-3">
                        @csrf
                        <textarea name="balasan" rows="2" placeholder="Tulis balasan Anda..."
                                class="w-full border rounded p-2 text-sm" required></textarea>
                        <button type="submit"
                                class="mt-2 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                            Balas
                        </button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-500 italic">Belum ada pertanyaan dari pembeli.</p>
        @endforelse
    </div>


    <!-- REKOMENDASI -->
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-4">Barang Serupa dari Kategori {{ $barang->kategori->nama }}</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-6">
            @forelse($rekomendasi as $item)
            <a href="{{ route('barang.show', $item->id) }}" class="bg-white rounded shadow hover:shadow-lg transition p-4">
                <img src="{{ asset('images/barang/' . $item->id . '/' . $item->thumbnail) }}"
                    class="w-full h-40 object-cover rounded mb-2">
                <h3 class="text-sm font-semibold">{{ $item->nama }}</h3>
                <p class="text-orange-600 font-bold text-sm">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
            </a>
            @empty
            <p class="text-gray-500 italic">Belum ada barang lain di kategori ini.</p>
            @endforelse
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

    function scrollAndFocusTextarea() {
        const form = document.getElementById('diskusiForm');
        const textarea = form?.querySelector('textarea');
        if (form && textarea) {
            form.scrollIntoView({ behavior: 'smooth', block: 'center' });
            setTimeout(() => textarea.focus(), 500); // beri delay agar scroll selesai dulu
        }
    }

    function showLoginPrompt() {
        alert('Silakan login terlebih dahulu untuk mulai berdiskusi.');
    }
</script>

<!-- MODAL LOGIN -->
<div id="loginPromptModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white w-96 rounded-lg p-6 shadow-lg text-center">
        <h2 class="text-lg font-bold mb-2 text-gray-800">Anda belum login</h2>
        <p class="text-sm text-gray-600 mb-6">Login dulu yuk untuk bisa akses fitur ini.</p>
        <div class="flex justify-between space-x-2">
            <a href="{{ route('pembeli.login.form') }}" class="flex-1 bg-green-600 text-white py-2 rounded hover:bg-green-700">Login</a>
            <a href="{{ route('pembeli.register.form') }}" class="flex-1 bg-blue-500 text-white py-2 rounded hover:bg-blue-600">Daftar</a>
            <button onclick="closeLoginPrompt()" class="flex-1 bg-gray-300 text-black py-2 rounded hover:bg-gray-400">Nanti saja</button>
        </div>
    </div>
</div>
@endsection
