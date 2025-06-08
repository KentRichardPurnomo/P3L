@extends('layouts.app-admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow mt-6">
    <h2 class="text-2xl font-bold mb-4">Tambah Merchandise</h2>

    <form action="{{ route('admin.merchandise.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="nama" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Harga (Poin)</label>
            <input type="number" name="harga_poin" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Stok</label>
            <input type="number" name="stok" class="w-full border p-2 rounded" required>
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Thumbnail</label>
            <input type="file" name="thumbnail" class="w-full border p-2 rounded" accept="image/*" required>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Simpan</button>
        <a href="{{ route('admin.merchandise.index') }}" class="ml-2 text-gray-600 hover:underline">Kembali</a>
    </form>
</div>
@endsection
