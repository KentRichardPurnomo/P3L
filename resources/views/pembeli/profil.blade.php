@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow space-y-6">
    <div class="mb-4">
        <a href="{{ url('/') }}"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>

    <h2 class="text-xl font-bold mb-4">Profil Pembeli</h2>

    {{-- Informasi Umum --}}
    <div class="flex items-center space-x-6">
        <img src="{{ $pembeli->profile_picture ? asset('storage/' . $pembeli->profile_picture) : asset('images/default-user.png') }}"
             class="w-24 h-24 rounded-full object-cover border">
        <div class="space-y-1 text-sm text-gray-800">
            <p><strong>Nama:</strong> {{ $pembeli->username }}</p>
            <p><strong>Email:</strong> {{ $pembeli->email }}</p>
            <p><strong>No. Telepon:</strong> {{ $pembeli->no_telp }}</p>
            <p><strong>Alamat Utama:</strong>
                {{ $pembeli->defaultAlamat ? $pembeli->defaultAlamat->alamat : 'Belum ada alamat default' }}
            </p>
            <p><strong>Poin:</strong> 🎁 {{ $pembeli->poin }} poin</p>
        </div>
    </div>

    {{-- Tombol Edit Profil --}}
    <div class="mt-4">
        <a href="{{ route('pembeli.profil.edit') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Edit Profil
        </a>

        <a href="{{ route('pembeli.alamat.index') }}"
            class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mt-4">
            Kelola Alamat
        </a>
    </div>
    

    {{-- Riwayat Pembelian --}}
    <div class="mt-10">
        <h3 class="text-lg font-semibold mb-3">Riwayat Pembelian</h3>

        @php
            $barangPernahDibeli = collect();

            foreach($transaksis as $transaksi) {
                foreach($transaksi->detail as $item) {
                    if ($item->barang && $item->barang->terjual) {
                        $barangPernahDibeli->push($item->barang);
                    }
                }
            }

            // Hilangkan duplikat berdasarkan id barang
            $barangPernahDibeli = $barangPernahDibeli->unique('id');
        @endphp

        @if($barangPernahDibeli->isNotEmpty())
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($barangPernahDibeli as $barang)
                    <div class="border rounded shadow p-3 bg-white flex flex-col">
                        <img src="{{ asset('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}"
                            class="w-full h-32 object-cover rounded mb-2">
                        <h4 class="text-sm font-semibold">{{ $barang->nama }}</h4>
                        <p class="text-xs text-gray-600 mb-2">Rp {{ number_format($barang->harga, 0, ',', '.') }}</p>

                        <a href="{{ route('pembeli.transaksi.detail', [$transaksi->id, $item->barang_id]) }}"
                            class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-sm text-gray-500 italic">Belum ada Riwayat Transaksi.</p>
        @endif
    </div>

</div>
@endsection
