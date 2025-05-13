@extends('layouts.app-owner')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Dashboard Owner</h2>

    <p><strong>Selamat Datang</strong> {{ $owner->nama_lengkap }}</p>
    <p>No Telepon: {{ $owner->no_telp }}</p>
    <p>Alamat Rumah: {{ $owner->alamat_rumah }}</p>

    <hr class="my-4">

    <h3 class="text-xl font-semibold mb-2">Daftar Request Donasi</h3>
    @if($requestDonasi->count())
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Organisasi</th>
                    <th class="border px-4 py-2">Jenis Barang</th>
                    <th class="border px-4 py-2">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requestDonasi as $r)
                    <tr>
                        <td class="border px-4 py-2">{{ $r->organisasi->username ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $r->jenis_barang }}</td>
                        <td class="border px-4 py-2">{{ $r->alasan }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-gray-500 italic">Belum ada request donasi.</p>
    @endif

    {{-- Tombol History Donasi --}}
    @if($requestDonasi->count())
        <div class="mt-6">
            <a href="{{ route('owner.history.donasi', ['organisasi_id' => $r->organisasi_id]) }}"
               class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow text-sm transition duration-200">
                Lihat History Donasi
            </a>
        </div>
    @endif
</div>
@endsection
