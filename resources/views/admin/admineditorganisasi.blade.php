@extends('layouts.app-admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow p-10 rounded mt-10">
    <div class="mb-4">
        <a href="{{ url('/admin/dashboard') }}"
           class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <h2 class="text-xl font-bold mb-4">Daftar Organisasi</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2">#</th>
                <th class="p-2">Nama</th>
                <th class="p-2">Email</th>
                <th class="p-2">No Telp</th>
                <th class="p-2">Alamat</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($organisasis as $index => $org)
            <tr class="border-t">
                <td class="p-2">{{ $index + 1 }}</td>
                <td class="p-2">{{ $org->username }}</td>
                <td class="p-2">{{ $org->email }}</td>
                <td class="p-2">{{ $org->no_telp }}</td>
                <td class="p-2">{{ $org->alamat ?? '-' }}</td>
                <td class="p-2 flex gap-2">
                    <a href="{{ route('admin.organisasi.edit', $org->id) }}" class="text-blue-600 hover:underline">Edit</a>

                    <form action="{{ route('admin.organisasi.destroy', $org->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus organisasi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
