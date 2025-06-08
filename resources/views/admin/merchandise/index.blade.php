@extends('layouts.app-admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded shadow mt-6">
    <div class="mb-4">
        <a href="{{ url('/admin/dashboard') }}"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <h2 class="text-2xl font-bold mb-4">Daftar Merchandise</h2>

    <a href="{{ route('admin.merchandise.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 mb-4 inline-block">+ Tambah Merchandise</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full table-auto border">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-2 border">#</th>
                <th class="p-2 border">Thumbnail</th>
                <th class="p-2 border">Nama</th>
                <th class="p-2 border">Poin</th>
                <th class="p-2 border">Stok</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($merchandises as $item)
            <tr>
                <td class="p-2 border">{{ $loop->iteration }}</td>
                <td class="p-2 border">
                    <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-16 h-16 object-cover">
                </td>
                <td class="p-2 border">{{ $item->nama }}</td>
                <td class="p-2 border">{{ $item->harga_poin }} poin</td>
                <td class="p-2 border">{{ $item->stok }}</td>
                <td class="p-2 border space-x-2">
                    <a href="{{ route('admin.merchandise.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.merchandise.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus merchandise ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
