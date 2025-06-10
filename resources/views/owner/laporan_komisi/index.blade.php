@extends('layouts.app-owner')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <div class="mb-4">
            <a href="{{ url('/owner/dashboard') }}"
            class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
                ← Kembali
            </a>
    </div>
    <h2 class="text-2xl font-bold mb-4">📋 Laporan Komisi Bulanan per Produk</h2>

    <form method="GET" action="{{ route('owner.laporan.komisi') }}" class="flex items-center gap-2 mb-4">
        <label for="bulan">Bulan:</label>
        <select name="bulan" id="bulan" class="border rounded p-2">
            @foreach(range(1, 12) as $b)
                <option value="{{ $b }}" {{ $b == $bulan ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                </option>
            @endforeach
        </select>

        <label for="tahun">Tahun:</label>
        <select name="tahun" id="tahun" onchange="this.form.submit()" class="border rounded p-2 w-40">
            @for($y = now()->year; $y >= 2020; $y--)
                <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
            @endfor
        </select>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filter</button>

        <a href="{{ route('owner.laporan.komisi.download', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 ml-auto">
            📄 Cetak PDF
        </a>
    </form>

    <table class="w-full table-auto border text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-2 py-1">Kode Produk</th>
                <th class="border px-2 py-1">Nama Barang</th>
                <th class="border px-2 py-1">Harga Jual</th>
                <th class="border px-2 py-1">Tanggal Masuk</th>
                <th class="border px-2 py-1">Tanggal Laku</th>
                <th class="border px-2 py-1">Komisi Hunter</th>
                <th class="border px-2 py-1">Komisi Owner</th>
                <th class="border px-2 py-1">Bonus Penitip</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $d)
                <tr>
                    <td class="border px-2 py-1 text-center">{{ $d['kode_produk'] }}</td>
                    <td class="border px-2 py-1">{{ $d['nama_barang'] }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($d['harga_jual']) }}</td>
                    <td class="border px-2 py-1 text-center">{{ $d['tanggal_masuk'] }}</td>
                    <td class="border px-2 py-1 text-center">{{ $d['tanggal_laku'] }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($d['komisi_hunter']) }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($d['komisi_owner']) }}</td>
                    <td class="border px-2 py-1 text-right">{{ number_format($d['bonus_penitip']) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="border px-2 py-3 text-center text-gray-500">Tidak ada data.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
