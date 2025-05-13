@extends('layouts.app-owner')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow space-y-6">

    <h2 class="text-xl font-bold">Alokasikan Barang</h2>

    <p class="text-gray-700">Permintaan dari: <strong>{{ $requestDonasi->organisasi->nama }}</strong></p>
    <p class="text-gray-700 mb-4">Jenis Barang: {{ $requestDonasi->jenis_barang }}</p>
    <p class="text-gray-700 mb-6">Alasan: {{ $requestDonasi->alasan }}</p>

    <form action="{{ route('owner.alokasi.store', $requestDonasi->id) }}" method="POST">
        @csrf
        <label for="barang_id" class="block mb-2 font-medium">Pilih Barang yang Akan Dialokasikan:</label>
        <select name="barang_id" id="barang_id" required class="w-full border rounded px-3 py-2">
            <option value="">-- Pilih Barang --</option>
            @foreach($barangs as $barang)
                <option value="{{ $barang->id }}">{{ $barang->nama }} - {{ $barang->kategori_id }}</option>
            @endforeach
        </select>

        <button type="submit" class="mt-6 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Alokasikan Barang
        </button>
    </form>

</div>
@endsection
