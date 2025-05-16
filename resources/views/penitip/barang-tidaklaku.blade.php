@extends('layouts.app-penitip')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Barang Anda yang Belum Terjual</h2>

    @if($barangTidakLaku->isEmpty())
        <p class="text-gray-600">Semua barang Anda telah terjual. Tidak ada barang tidak laku saat ini.</p>
    @else
        <ul class="divide-y">
            @foreach($barangTidakLaku as $barang)
                <li class="py-4">
                    <h3 class="text-lg font-semibold">{{ $barang->nama }}</h3>
                    <p>Harga: Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                    <p>Kategori: {{ $barang->kategori->nama ?? '-' }}</p>
                    <p>Status: <span class="text-red-600">Belum Terjual</span></p>
                </li>
            @endforeach
        </ul>
    @endif

    <div class="mt-6">
        <a href="{{ route('penitip.dashboard') }}" class="text-green-600 hover:underline">← Kembali ke Dashboard</a>
    </div>
</div>
@endsection
