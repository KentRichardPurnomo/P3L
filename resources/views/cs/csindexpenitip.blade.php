@extends('layouts.app-cs')

@section('content')
<div class="max-w-6xl mx-auto mt-6 bg-white p-6 rounded shadow">
    <div class="mb-4">
        <a href="{{ url('/cs/dashboard') }}"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <h2 class="text-xl font-bold mb-4">Kelola Data Penitip</h2>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-2 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('cs.penitip.index') }}" class="mb-4 flex space-x-2">
        <input type="text" name="keyword" value="{{ request('keyword') }}"
               class="w-full px-3 py-2 border rounded"
               placeholder="Cari username / email / no telp / no KTP">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Cari
        </button>
    </form>

    <div class="mb-4 text-right">
        <a href="{{ route('cs.penitip.create') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Penitip</a>
    </div>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">Username</th>
                <th class="p-2 border">Email</th>
                <th class="p-2 border">No Telp</th>
                <th class="p-2 border">No KTP</th>
                <th class="p-2 border">Foto KTP</th>
                <th class="p-2 border text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penitips as $penitip)
                <tr>
                    <td class="p-2 border">{{ $penitip->username }}</td>
                    <td class="p-2 border">{{ $penitip->email }}</td>
                    <td class="p-2 border">{{ $penitip->no_telp }}</td>
                    <td class="p-2 border">{{ $penitip->no_ktp }}</td>
                    <td class="p-2 border">
                        @if($penitip->foto_ktp)
                            <img src="{{ asset('storage/' . $penitip->foto_ktp) }}" alt="KTP" class="h-12 rounded">
                        @else
                            Tidak Ada
                        @endif
                    </td>
                    <td class="p-2 border text-center">
                        <a href="{{ route('cs.penitip.edit', $penitip->id) }}"
                           class="text-yellow-600 hover:underline mr-2">Edit</a>
                        <form action="{{ route('cs.penitip.destroy', $penitip->id) }}" method="POST"
                              class="inline" onsubmit="return confirm('Yakin ingin menghapus penitip ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">Belum ada penitip.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $penitips->withQueryString()->links() }}
    </div>
</div>
@endsection
