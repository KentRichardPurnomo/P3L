@extends('layouts.app-cs')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h2 class="text-2xl font-bold mb-4">Dashboard CS</h2>

    <!-- Profil CS -->
    <div class="mb-6 border rounded p-4">
        <h3 class="text-lg font-semibold mb-2">Profil Anda</h3>
        <p><strong>Username:</strong> {{ $cs->username }}</p>
        <p><strong>Nama Lengkap:</strong> {{ $cs->nama_lengkap }}</p>
        <p><strong>No. Telepon:</strong> {{ $cs->no_telp }}</p>
        <p><strong>Jabatan:</strong> {{ $cs->jabatan->nama_jabatan }}</p>
    </div>

    <!-- Aksi -->
    <div class="space-y-4">
        <a href="{{ route('cs.penitip.index') }}"
           class="block bg-blue-600 text-white px-4 py-3 rounded hover:bg-blue-700 text-center font-semibold">
            Kelola Data Penitip
        </a>

        <a href="{{ route('cs.barang.semua') }}"
           class="block bg-green-600 text-white px-4 py-3 rounded hover:bg-green-700 text-center font-semibold">
            Kelola Data Barang
        </a>
    </div>
</div>
@endsection
