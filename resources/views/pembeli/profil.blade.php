@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow space-y-6">

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
    </div>

    {{-- Riwayat Pembelian --}}
    <div class="mt-10">
        <h3 class="text-lg font-semibold mb-3">Riwayat Pembelian</h3>

        @forelse($transaksis as $transaksi)
            <details class="mb-4 border rounded p-4 bg-white shadow">
                <summary class="cursor-pointer font-semibold text-green-700">
                    Transaksi #{{ $transaksi->id }} – {{ $transaksi->tanggal->format('d M Y H:i') }} – Rp {{ number_format($transaksi->total, 0, ',', '.') }}
                </summary>
                <ul class="mt-3 list-disc list-inside text-sm text-gray-700">
                    @foreach($transaksi->detail as $item)
                        <li>
                            {{ $item->barang->nama }} – {{ $item->jumlah }} x Rp {{ number_format($item->barang->harga, 0, ',', '.') }} = <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                        </li>
                    @endforeach
                </ul>
            </details>
        @empty
            <p class="text-sm text-gray-500 italic">Belum ada riwayat pembelian.</p>
        @endforelse
    </div>

</div>
@endsection
