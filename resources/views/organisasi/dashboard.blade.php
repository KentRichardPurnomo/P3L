@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Dashboard Organisasi</h2>

    <div class="flex items-center gap-6 mb-6">
        <img src="{{ asset('storage/' . $organisasi->foto_profil) }}" alt="Foto Profil"
             class="w-20 h-20 rounded-full object-cover">
        <div>
            <p><strong>Nama Organisasi:</strong> {{ $organisasi->username }}</p>
            <p><strong>Email:</strong> {{ $organisasi->email }}</p>
            <p><strong>No. Telepon:</strong> {{ $organisasi->no_telp }}</p>
        </div>
    </div>

    <a href="{{ route('organisasi.request.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-6 inline-block">
        + Request Donasi
    </a>

    <h3 class="text-xl font-semibold mt-6 mb-2">Request Donasi dari Organisasi Lain</h3>
    <ul class="space-y-3">
        @forelse ($allRequests as $req)
            <li class="border p-3 rounded bg-gray-50">
                <p><strong>Jenis Barang:</strong> {{ $req->jenis_barang }}</p>
                <p><strong>Alasan:</strong> {{ $req->alasan }}</p>
                <p class="text-sm text-gray-500">Dikirim oleh Organisasi ID: {{ $req->organisasi_id }}</p>
            </li>
        @empty
            <p class="text-gray-500">Belum ada request dari organisasi lain.</p>
        @endforelse
    </ul>
</div>
@endsection
