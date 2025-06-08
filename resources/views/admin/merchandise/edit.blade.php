@extends('layouts.app-admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-6">
    <h2 class="text-2xl font-bold mb-4">Edit Merchandise</h2>

    <form action="{{ route('admin.merchandise.update', $merchandise->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="nama" value="{{ $merchandise->nama }}" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Harga (Poin)</label>
            <input type="number" name="harga_poin" value="{{ $merchandise->harga_poin }}" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Stok</label>
            <input type="number" name="stok" value="{{ $merchandise->stok }}" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Thumbnail Saat Ini</label>
            <img src="{{ asset('storage/' . $merchandise->thumbnail) }}" class="w-24 h-24 object-cover mb-2">
            <input type="file" name="thumbnail" class="w-full border p-2 rounded" accept="image/*">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        <a href="{{ route('admin.merchandise.index') }}" class="ml-2 text-gray-600 hover:underline">Kembali</a>
    </form>
</div>
@endsection
