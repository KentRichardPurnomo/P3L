@extends('layouts.app-penitip')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded shadow space-y-8">

    {{-- Informasi Penitip --}}
    <div class="flex items-center space-x-4">
        <img src="{{ $penitip->profile_picture ? asset('storage/' . $penitip->profile_picture) : asset('images/default-user.png') }}"
             class="w-24 h-24 rounded-full object-cover border">
        <div>
            <h2 class="text-xl font-bold">Username : {{ $penitip->username }}</h2>
            <p><i class="fas fa-envelope mr-1"></i>Email✉️ : {{ $penitip->email }}</p>
            <p><i class="fas fa-phone mr-1"></i>No Telp☎️ : {{ $penitip->no_telp }}</p>
            <p class="text-lg">Saldo: Rp{{ number_format($penitip->saldo, 0, ',', '.') }}</p>
            <p>Rating: 
                @php
                    $avg = round($penitip->averageRating(), 1);
                @endphp
                {{ $avg ?? '-' }} / 5
            </p>
        </div>
    </div>

    {{-- Tombol Edit --}}
    <div class="mt-3">
        <a href="{{ route('penitip.profil.edit') }}"
        class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
        Edit Profil
        </a>
    </div>

    {{-- Barang Aktif --}}
    <div>
        <h3 class="text-lg font-semibold mb-3">Barang yang Sedang Dititipkan</h3>
        @if($barangAktif->isEmpty())
            <p class="text-sm text-gray-500">Tidak ada barang aktif saat ini.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($barangAktif as $barang)
                    <a href="{{ route('penitip.barang.show', $barang->id) }}"class="border rounded p-3 hover:shadow transition">
                        <img src="{{ asset('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}"
                             class="w-full h-32 object-cover rounded mb-2">
                        <h4 class="font-semibold text-sm">{{ $barang->nama }}</h4>
                        <p class="text-sm text-gray-600">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Barang Terjual (Riwayat) --}}
    <div>
        <h3 class="text-lg font-semibold mb-3 mt-8">Riwayat Barang yang Sudah Terjual</h3>
        @if($barangTerjual->isEmpty())
            <p class="text-sm text-gray-500">Belum ada barang yang terjual.</p>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($barangTerjual as $barang)
                    <a href="{{ route('penitip.barang.riwayat', $barang->id) }}" class="border rounded p-3 hover:shadow transition">
                        <img src="{{ asset('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}"
                             class="w-full h-32 object-cover rounded mb-2">
                        <h4 class="font-semibold text-sm">{{ $barang->nama }}</h4>
                        <p class="text-sm text-gray-600">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>
                        <span class="text-xs text-red-600 font-medium">✅ Sudah Terjual</span>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
