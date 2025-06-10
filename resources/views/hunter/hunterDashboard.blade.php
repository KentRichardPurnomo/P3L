@extends('layouts.app-hunter')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded shadow mt-6">
    <h2 class="text-2xl font-bold mb-4">Dashboard Hunter</h2>

    {{-- Informasi Penitip --}}
    <div class="flex items-center space-x-4">
        <img src="{{ $hunter->profile_picture ? asset('storage/' . $hunter->profile_picture) : asset('images/default-user.png') }}"
             class="w-24 h-24 rounded-full object-cover border">
        <div>
            <h2 class="text-xl font-bold">Username : {{ $hunter->username }}</h2>
            <p><i class="fas fa-envelope mr-1"></i>Email✉️ : {{ $hunter->email }}</p>
            <p><i class="fas fa-phone mr-1"></i>No Telp☎️ : {{ $hunter->no_telp }}</p>
            <p class="text-lg">Saldo: Rp{{ number_format($hunter->saldo, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Tombol Edit dan Histori --}}
    <div class="mt-3">
        <a href="{{ route('hunter.profil.edit') }}"
        class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
            Edit Profil
        </a>
        <a href="{{ route('hunter.index') }}"
        class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm mt-2">
            💰 Lihat History Komisi
        </a>
    </div>
</div>
@endsection
