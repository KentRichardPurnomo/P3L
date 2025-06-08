@extends('layouts.app-owner')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
            <div class="mb-4">
                    <a href="{{ url('/owner/dashboard') }}"
                    class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
                        ← Kembali
                    </a>
            </div>
            <h2 class="text-2xl font-bold mb-4">📑 Barang dengan Masa Penitipan Sudah Habis</h2>

            <a href="{{ route('owner.laporan.masaPenitipan.download') }}"
            class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4">
                ⬇️ Unduh PDF
            </a>

            @if($expiredBarangs->isEmpty())
                <p class="text-gray-600">Tidak ada barang dengan masa penitipan habis.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border">Kode Produk</th>
                                <th class="px-4 py-2 border">Gambar Barang</th>
                                <th class="px-4 py-2 border">Nama Barang</th>
                                <th class="px-4 py-2 border">Id Penitip</th>
                                <th class="px-4 py-2 border">Penitip</th>
                                <th class="px-4 py-2 border">Tanggal Masuk</th>
                                <th class="px-4 py-2 border">Tanggal Berakhir</th>
                                <th class="px-4 py-2 border">Batas Diambil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expiredBarangs as $barang)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $barang->kode ?? 'K' . $barang->id }}</td>
                                    <td class="px-4 py-2 border">
                                        <img src="{{ asset('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}"
                                            alt="Thumbnail {{ $barang->nama }}"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-200 shadow-sm" 
                                            onerror="this.src='{{ asset('images/not-found.jpg') }}'">
                                    </td>
                                    <td class="px-4 py-2 border">{{ $barang->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $barang->penitip->kode ?? 'T' . $barang->penitip_id }}</td>
                                    <td class="px-4 py-2 border">{{ $barang->penitip->username ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($barang->created_at)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($barang->batas_waktu_titip)->format('d-m-Y') }}</td>
                                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($barang->batas_waktu_titip)->addDays(7)->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
    </div>
</div>
@endsection
