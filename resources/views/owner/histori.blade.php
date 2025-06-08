@extends('layouts.app-owner')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <div class="mb-4">
            <a href="{{ url('/owner/dashboard') }}"
            class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
                ← Kembali
            </a>
    </div>
    <h2 class="text-xl font-bold mb-4">Histori Barang Donasi</h2>

    <form method="GET" action="{{ route('owner.histori') }}" class="mb-6">
        <label for="alamat" class="font-medium">Cari berdasarkan alamat organisasi:</label>
        <div class="flex gap-2 mt-2">
            <input type="text" name="alamat" id="alamat"
                value="{{ request('alamat') }}"
                class="w-full border rounded px-3 py-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Cari
            </button>
        </div>
    </form>

    @if($historiDonasi->isEmpty())
        <p class="text-gray-500">Belum ada barang yang didonasikan.</p>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th>Organisasi</th>
                    <th>Nama Penerima</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Donasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($historiDonasi as $donasi)
                    <tr class="border-b">
                        <td class="py-2">{{ $donasi->organisasi->username ?? 'Tidak diketahui' }}</td>
                        <td class="py-2">{{ $donasi->nama_penerima ?? 'Tidak diketahui' }}</td>
                        <td>{{ $donasi->nama_barang }}</td>
                        <td>{{ $donasi->tanggal_donasi ?? '-' }}</td>
                        <td class="py-2">
                            <a href="{{ route('owner.donasi.edit', $donasi->id) }}"
                            class="text-sm text-white bg-yellow-600 px-3 py-1 rounded hover:bg-orange-700">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
