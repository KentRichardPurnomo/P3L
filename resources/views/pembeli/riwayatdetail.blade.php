@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-8 bg-white p-6 rounded shadow">
    <div class="mb-4">
        <a href="{{ url('/pembeli/riwayat')}}"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <h2 class="text-2xl font-bold mb-6">Detail Transaksi</h2>

    <div class="mb-4 space-y-2">
        <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d M Y, H:i') }}</p>

        <p><strong>Status:</strong>
            <span class="inline-block px-2 py-1 rounded text-white
                @if($transaksi->status === 'selesai') bg-green-600
                @elseif($transaksi->status === 'diproses') bg-blue-600
                @elseif($transaksi->status === 'menunggu konfirmasi') bg-yellow-600
                @elseif($transaksi->status === 'menunggu pembayaran') bg-orange-600
                @else bg-red-600
                @endif">
                {{ ucfirst($transaksi->status) }}
            </span>
        </p>

        <p><strong>Metode:</strong> {{ ucfirst($transaksi->tipe_pengiriman) }}</p>

        @if($transaksi->tipe_pengiriman === 'kirim' && $transaksi->alamat)
            <p><strong>Alamat Pengiriman:</strong><br>{{ $transaksi->alamat->alamat }}</p>
        @endif
    </div>

    <h3 class="font-semibold text-lg mb-2">Barang Dibeli:</h3>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
        @foreach($transaksi->detail as $item)
            @if($item->barang)
                <div class="border p-3 rounded bg-gray-50">
                    <img src="{{ asset('images/barang/' . $item->barang->id . '/' . $item->barang->thumbnail) }}"
                         alt="Thumbnail {{ $item->barang->nama }}"
                         class="w-full h-32 object-cover rounded mb-2"
                         onerror="this.src='{{ asset('images/not-found.jpg') }}'">

                    <p class="text-sm font-semibold">{{ $item->barang->nama }}</p>
                    <p class="text-xs text-gray-600">Harga: Rp {{ number_format($item->barang->harga, 0, ',', '.') }}</p>
                    <p class="text-xs">Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
            @endif
        @endforeach
    </div>

    <div class="border-t pt-4 text-right space-y-1">
        <p class="text-sm">Poin Ditukar: {{ $transaksi->poin_ditukar }}</p>
        <p class="text-sm">Potongan: Rp {{ number_format($transaksi->potongan, 0, ',', '.') }}</p>
        <p class="text-sm font-bold">Total Dibayar: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</p>
    </div>

    <div class="mt-6 text-right">
        <a href="{{ route('pembeli.transaksi.cetakNota', $transaksi->id) }}"
           target="_blank"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
           Cetak Nota
        </a>
    </div>
</div>
@endsection
