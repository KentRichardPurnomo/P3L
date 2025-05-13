@extends('layouts.app-owner')

@section('content')
<div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <div class="mb-4">
            <a href="{{ url('/owner/dashboard') }}"
            class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
                ← Kembali
            </a>
        </div>
    <h2 class="text-xl font-bold mb-4">List Request Donasi</h2>

    @if($requestDonasi->isEmpty())
        <p class="text-gray-500">Belum ada request donasi.</p>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th>Organisasi</th>
                    <th>Jenis Barang</th>
                    <th>Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requestDonasi as $req)
                    <tr class="border-b">
                        <td class="py-2">{{ $req->organisasi->username ?? 'Tidak diketahui' }}</td>
                        <td>{{ $req->jenis_barang }}</td>
                        <td>{{ $req->alasan }}</td>
                        <td>
                            <a href="{{ route('owner.alokasi.form', $req->id) }}"
                            class="text-white bg-blue-600 px-3 py-1 rounded hover:bg-blue-700">
                            🎯 Alokasikan Barang
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
