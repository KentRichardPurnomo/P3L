@extends('layouts.app-owner')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">📦 Laporan Stok Gudang</h2>

    <form method="GET" class="flex items-center gap-4 mb-4">
        <label for="tanggal">Filter Tanggal Masuk:</label>
        <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}" class="border rounded p-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tampilkan</button>
        <a href="{{ route('owner.laporan.stok.download', ['tanggal' => $tanggal]) }}"
           class="ml-auto bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
           📄 Cetak PDF
        </a>
    </form>

    <table class="w-full border text-sm table-auto">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-2 py-1">Kode Barang</th>
                <th class="border px-2 py-1">Nama Produk</th>
                <th class="border px-2 py-1">ID Penitip</th>
                <th class="border px-2 py-1">Nama Penitip</th>
                <th class="border px-2 py-1">Tanggal Masuk</th>
                <th class="border px-2 py-1">Perpanjangan</th>
                <th class="border px-2 py-1">ID Hunter</th>
                <th class="border px-2 py-1">Nama Hunter</th>
                <th class="border px-2 py-1">Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
                <tr>
                    <td class="border px-2 py-1 text-center">{{ strtoupper(substr($barang->nama, 0, 1)) . $barang->id }}</td>
                    <td class="border px-2 py-1">{{ $barang->nama }}</td>
                    <td class="border px-2 py-1 text-center">{{ $barang->penitip->id }}</td>
                    <td class="border px-2 py-1">{{ $barang->penitip->username }}</td>
                    <td class="border px-2 py-1 text-center">{{ \Carbon\Carbon::parse($barang->created_at)->format('d-m-Y') }}</td>
                    <td class="border px-2 py-1 text-center">{{ $barang->status_perpanjangan ? 'Ya' : 'Tidak' }}</td>
                    <td class="border px-2 py-1 text-center">{{ $barang->hunter_id ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $barang->hunter->nama ?? '-' }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($barang->harga) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
