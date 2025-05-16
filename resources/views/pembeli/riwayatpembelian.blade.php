@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded shadow">

    <a href="{{ route('pembeli.profil') }}"
       class="text-green-600 font-semibold hover:underline mb-4 inline-block">← Kembali ke Profil</a>

    <h2 class="text-xl font-bold mb-4">Riwayat Pembelian</h2>

    @php
        $barangPernahDibeli = collect();

        foreach($transaksis as $transaksi) {
            foreach($transaksi->detail as $item) {
                if ($item->barang && $item->barang->terjual) {
                    $item->transaksi_id = $transaksi->id; // simpan id untuk link
                    $barangPernahDibeli->push($item);
                }
            }
        }

        $barangPernahDibeli = $barangPernahDibeli->unique('barang.id');
    @endphp

    @if($barangPernahDibeli->isNotEmpty())
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($barangPernahDibeli as $item)
                <div class="border rounded shadow p-3 bg-white flex flex-col">
                    <img src="{{ asset('images/barang/' . $item->barang->id . '/' . $item->barang->thumbnail) }}"
                        class="w-full h-32 object-cover rounded mb-2">
                    <h4 class="text-sm font-semibold">{{ $item->barang->nama }}</h4>
                    <p class="text-xs text-gray-600 mb-2">Rp {{ number_format($item->barang->harga, 0, ',', '.') }}</p>

                    <a href="{{ route('pembeli.transaksi.detail', [$item->transaksi_id, $item->barang->id]) }}"
                        class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-500 italic">Belum ada riwayat transaksi.</p>
    @endif

</div>
@endsection
