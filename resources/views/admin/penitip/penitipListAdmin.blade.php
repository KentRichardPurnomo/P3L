@extends('layouts.app-admin')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow mt-6">
    <div class="mb-4">
        <a href="{{ url('/admin/dashboard') }}"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <h2 class="text-2xl font-bold mb-4">Daftar Penitip - Performa Bulan Lalu</h2>

        {{-- Tombol Batalkan --}}
        <div class="mb-4 ">
            @if($topSellerId)
                <form method="POST" action="{{ route('admin.top_seller.batal') }}"
                    onsubmit="return confirm('Yakin ingin membatalkan Top Seller bulan lalu?')">
                    @csrf
                    @method('DELETE')
                    <button class="mt-6 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        ❌ Batalkan Top Seller Bulan Lalu
                    </button>
                </form>
            @endif
        </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-100 text-red-800 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <table class="w-full table-auto border">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-2 border">No</th>
                <th class="p-2 border">Username</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">No. Telp</th>
                <th class="p-2 border">Barang Terjual Bulan Lalu</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penitips as $index => $penitip)
            <tr>
                <td class="p-2 border">{{ $index + 1 }}</td>
                <td class="p-2 border">
                    {{ $penitip->username }}
                    @if($penitip->id === $topSellerId)
                        <span class="ml-2 bg-yellow-300 text-yellow-800 text-xs font-semibold px-2 py-1 rounded-full">
                            ⭐ Top Seller
                        </span>
                    @endif
                </td>
                <td class="p-2 border">{{ $penitip->email }}</td>
                <td class="p-2 border">{{ $penitip->no_telp }}</td>
                <td class="p-2 border">{{ $penitip->jumlah_terjual }}</td>
                <td class="p-2 border">
                    @if($topSellerId && $penitip->id === $topSellerId)
                        <span class="text-green-600 text-sm font-medium">✅ Sudah Terpilih</span>
                    @elseif(!$topSellerId && $penitip->boleh_dipilih)
                        <form method="POST" action="{{ route('admin.top_seller.set', $penitip->id) }}"
                            onsubmit="return confirm('Yakin pilih {{ $penitip->username }} sebagai Top Seller bulan lalu?')">
                            @csrf
                            <button class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                                Pilih Top Seller
                            </button>
                        </form>
                    @elseif(!$topSellerId)
                        <span class="text-gray-400 text-sm italic">Tidak memenuhi syarat</span>
                    @else
                        <span class="text-gray-500 text-sm italic">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


</div>
@endsection
