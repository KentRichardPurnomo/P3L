@extends('layouts.app-owner')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow space-y-6">

    {{-- Sambutan --}}
    <h2 class="text-2xl font-bold">Selamat datang, {{ $owner->nama_lengkap }} 👑</h2>

    {{-- Informasi Profil --}}
    <div class="mt-4 space-y-2 text-sm text-gray-700">
        <p><strong>Username:</strong> {{ $owner->username }}</p>
        <p><strong>Email:</strong> {{ $owner->email }}</p>
        <p><strong>No. Telp:</strong> {{ $owner->no_telp }}</p>
        <p><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($owner->tanggal_lahir)->translatedFormat('d F Y') }}</p>
        <p><strong>Alamat Rumah:</strong> {{ $owner->alamat_rumah ?? '-' }}</p>
    </div>

    {{-- Navigasi --}}
    <div class="mt-6 space-y-3">
        <a href="{{ route('owner.request') }}"
           class="block w-full text-center bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
           🔍 Lihat List Request Donasi
        </a>

        <a href="{{ route('owner.histori') }}"
           class="block w-full text-center bg-green-600 text-white py-2 rounded hover:bg-green-700">
           📦 Lihat Histori Donasi Barang
        </a>

        <a href="{{ route('owner.transaksi.index') }}"
            class="block w-full text-center bg-yellow-600 text-white py-2 rounded hover:bg-yellow-700">
            💰 Lihat Transaksi ReuseMart
        </a>

        <a href="{{ route('owner.laporan.bulanan') }}"
            class="block w-full text-center bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
            📊 Laporan Penjualan Bulanan
        </a>

        <a href="{{ route('owner.laporan.komisi') }}"
            class="block w-full text-center bg-indigo-600 text-white py-2 rounded hover:bg-red-700">
            📑 Laporan Komisi Bulanan
        </a>

        <a href="{{ route('owner.laporan.stok') }}"
            class="block w-full text-center bg-purple-600 text-white py-2 rounded hover:bg-purple-700">
            🧾 Laporan Stok Gudang
        </a>

        <a href="{{ route('owner.laporan.index') }}"
            class="block w-full text-center bg-red-600 text-white py-2 rounded hover:bg-yellow-700">
            📑 Laporan Penjualan per Kategori Barang
        </a>

        <a href="{{ route('owner.laporan.masaPenitipan') }}"
            class="block w-full text-center bg-red-600 text-white py-2 rounded hover:bg-red-700">
            📑 Laporan Barang Masa Penitipannya Sudah Habis
        </a>

    </div>

</div>
@endsection
