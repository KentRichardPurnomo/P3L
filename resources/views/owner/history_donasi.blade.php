@extends('layouts.app-owner')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">History Donasi ke Organisasi: {{ $organisasi->nama }}</h2>

    @if ($history->isEmpty())
        <p class="text-gray-600">Belum ada donasi ke organisasi ini.</p>
    @else
        <table class="table-auto w-full mt-4 border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Organisasi</th>
                    <th class="border px-4 py-2">Jenis Barang</th>
                    <th class="border px-4 py-2">Alasan</th>
                    <th class="border px-4 py-2">Tanggal Dibuat</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $donasi)
                    <tr>
                        <td class="border px-4 py-2">{{ $donasi->organisasi->username }}</td>
                        <td class="border px-4 py-2">{{ $donasi->jenis_barang }}</td>
                        <td class="border px-4 py-2">{{ $donasi->alasan }}</td>
                        <td class="border px-4 py-2">{{ $donasi->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('owner.dashboard') }}" class="mt-4 inline-block text-blue-500 hover:underline">Kembali ke Dashboard</a>
</div>
@endsection
