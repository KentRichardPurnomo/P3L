@extends('layouts.app-admin')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow p-10 rounded mt-10">
    <h2 class="text-2xl font-bold mb-4">Dashboard Admin</h2>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-2">Welcome Admin</h3>
        <p><strong>Nama Lengkap:</strong> {{ $admin->nama_lengkap }}</p>
        <p><strong>No. Telepon:</strong> {{ $admin->no_telp }}</p>
        <p><strong>Jabatan:</strong> {{ $admin->jabatan->nama_jabatan }}</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
        <a href="{{ route('admin.jabatan.index') }}" class="block text-center bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 shadow">
            Kelola Jabatan
        </a>
        <a href="{{ route('admin.organisasi.index') }}" class="block text-center bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 shadow">
            Lihat Organisasi
        </a>
        <a href="{{ route('admin.pegawai.index') }}" class="block text-center bg-indigo-600 text-white py-3 px-4 rounded-lg hover:bg-indigo-700 shadow">
            Cari Data Pegawai
        </a>
        <a href="{{ route('admin.merchandise.index') }}" class="block text-center bg-yellow-600 text-white py-3 px-4 rounded-lg hover:bg-yellow-700 shadow">
            Kelola Merchandise
        </a>
        <a href="{{ route('admin.penitip.index') }}" class="block text-center bg-pink-600 text-white py-3 px-4 rounded-lg hover:bg-pink-700 shadow">
            Lihat Daftar Penitip
        </a>
    </div>
</div>
@endsection
