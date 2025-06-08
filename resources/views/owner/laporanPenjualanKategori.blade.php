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
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">
                📊 Laporan Penjualan per Kategori Barang
            </h2>
        </div>

        @if(count($data) > 0)
            @foreach($data as $kategori => $barangs)
                <div class="mb-8">
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h3 class="text-xl font-semibold text-gray-800 flex items-center">
                            {{ $kategori }}
                        </h3>
                        <a href="{{ route('owner.laporan.downloadPerKategori', ['kategori' => urlencode($kategori)]) }}"
                            class="inline-block bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                            ⬇️ Unduh PDF Kategori Ini
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto shadow-md rounded-lg">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gambar
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nama Barang
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Penitip
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Terjual
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($barangs as $barang)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <img src="{{ asset('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}"
                                                 alt="Thumbnail {{ $barang->nama }}"
                                                 class="w-16 h-16 object-cover rounded-lg border border-gray-200 shadow-sm" 
                                                 onerror="this.src='{{ asset('images/not-found.jpg') }}'">
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $barang->nama }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-semibold text-green-600">
                                                Rp{{ number_format($barang->harga, 0, ',', '.') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                @if($barang->penitip)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium">
                                                        {{ $barang->penitip->username }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{ $barang->updated_at->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $barang->updated_at->format('H:i') }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Summary untuk setiap kategori -->
                    <div class="mt-4 bg-blue-50 rounded-lg p-4">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                            <div class="text-sm text-gray-700">
                                <span class="font-medium">Total {{ count($barangs) }} barang terjual</span>
                            </div>
                            <div class="text-lg font-bold text-blue-800 mt-2 sm:mt-0">
                                Total: Rp{{ number_format($barangs->sum('harga'), 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Grand Total -->
            <div class="mt-8 bg-green-100 rounded-lg p-6 border-l-4 border-green-500">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <h4 class="text-lg font-semibold text-green-800">Grand Total Penjualan</h4>
                        <p class="text-sm text-green-700 mt-1">
                            {{ collect($data)->flatten()->count() }} barang dari {{ count($data) }} kategori
                        </p>
                    </div>
                    <div class="text-2xl font-bold text-green-800 mt-3 sm:mt-0">
                        Rp{{ number_format(collect($data)->flatten()->sum('harga'), 0, ',', '.') }}
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">📊</div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data Penjualan</h3>
                <p class="text-gray-500">Data penjualan akan muncul setelah ada transaksi yang terjadi.</p>
            </div>
        @endif
    </div>
</div>
@endsection