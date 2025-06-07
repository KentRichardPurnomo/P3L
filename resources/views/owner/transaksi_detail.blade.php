@extends('layouts.app-owner')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow mt-6">
    <a href="{{ url()->previous() }}"
   class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
    ← Kembali
</a>
    <h2 class="text-2xl font-bold mb-4">Detail Transaksi #{{ $id }}</h2>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Nama Barang</th>
                <th class="p-2 border">Harga Total</th>
                <th class="p-2 border">Komisi Owner</th>
                <th class="p-2 border">Perpanjangan?</th>
                <th class="p-2 border">> 7 Hari?</th>
                <th class="p-2 border">Penitip</th>
                <th class="p-2 border">Komisi Penitip</th>
                <th class="p-2 border">Bonus Penitip</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                @php
                    $barang = $log->barang;
                    $penitip = $log->penitip;
                    $lebih7hari = optional($barang)->created_at && $barang->transaksi && $barang->created_at->diffInDays($barang->transaksi->created_at ?? now()) > 7;
                @endphp
                <tr>
                    <td class="p-2 border">{{ $barang->nama ?? '-' }}</td>
                    <td class="p-2 border">Rp{{ number_format($log->total_harga, 0, ',', '.') }}</td>
                    <td class="p-2 border">Rp{{ number_format($log->komisi_owner, 0, ',', '.') }}</td>
                    <td class="p-2 border">{{ $barang->status_perpanjangan ? 'Ya' : 'Tidak' }}</td>
                    <td class="p-2 border">{{ $lebih7hari ? 'Ya' : 'Tidak' }}</td>
                    <td class="p-2 border">T{{ $penitip->id }}/{{ $penitip->username }}</td>
                    <td class="p-2 border">Rp{{ number_format($log->komisi_penitip, 0, ',', '.') }}</td>
                    <td class="p-2 border">Rp{{ number_format($log->bonus_penitip, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
