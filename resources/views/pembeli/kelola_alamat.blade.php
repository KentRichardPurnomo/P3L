@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <div class="mb-4">
        <a href="{{ url('/profil') }}"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <div class="max-w-2xl mx-auto mt-6">
        
        <h2 class="text-xl font-bold mb-4">Daftar Alamat</h2>

        <h3 class="text-lg font-semibold mt-6 mb-2">Tambah Alamat Baru</h3>
        <form method="POST" action="{{ route('pembeli.alamat.store') }}" class="mb-6">
            @csrf
            <div class="flex items-center gap-2">
                <input type="text" name="alamat" class="w-full border rounded px-3 py-2" placeholder="Masukkan alamat baru..." required>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Tambah</button>
            </div>
        </form>

        @if(session('success'))
            <div class="mb-4 bg-green-100 text-green-800 p-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4">
            @foreach($alamatList as $alamat)
                <div class="p-4 border rounded {{ $alamat->id == $defaultAlamatId ? 'bg-green-50 border-green-600' : 'border-gray-300' }}">
                    <p class="mb-2">{{ $alamat->alamat }}</p>

                    <div class="flex gap-4 items-center">
                        @if($alamat->id == $defaultAlamatId)
                            <span class="text-green-600 font-semibold">Alamat Utama</span>
                        @else
                            <form action="{{ route('pembeli.alamat.setDefault', $alamat->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:underline">Jadikan Utama</button>
                            </form>
                        @endif

                        <a href="{{ route('pembeli.alamat.edit', $alamat->id) }}" class="text-yellow-600 hover:underline">Edit</a>

                        <form action="{{ route('pembeli.alamat.destroy', $alamat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alamat ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>
</div>
@endsection
