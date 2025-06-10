@extends('layouts.app-hunter')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h2 class="text-2xl font-bold mb-4">History Komisi Anda</h2>
    <div class="mb-4">
            <a href="{{ route('hunter.dashboard') }}"
            class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
                ← Kembali
            </a>
    </div>

    @if($komisiLogs->isEmpty())
        <p>Tidak ada riwayat komisi yang tersedia.</p>
    @else
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Barang</th>
                    <th class="p-2 border">Penitip</th>
                    <th class="p-2 border">Total Harga</th>
                    <th class="p-2 border">Komisi Hunter</th>
                </tr>
            </thead>
            <tbody>
                @foreach($komisiLogs as $log)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-2 border">{{ $log->created_at->format('d M Y') }}</td>
                        <td class="p-2 border">{{ $log->barang->nama ?? '-' }}</td>
                        <td class="p-2 border">{{ $log->penitip->username ?? '-' }}</td>
                        <td class="p-2 border">Rp{{ number_format($log->total_harga, 0, ',', '.') }}</td>
                        <td class="p-2 border text-green-600 font-semibold">Rp{{ number_format($log->komisi_hunter, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
