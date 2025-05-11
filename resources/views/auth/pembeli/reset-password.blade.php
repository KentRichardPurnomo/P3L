@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Reset Password</h2>
    <h1 class="text-xl mb-4">Link Sudah Dikirim Ke Email Anda</h1>


    @if(session('password_info'))
        <div class="mb-4 text-sm text-green-600">
            {{ session('password_info') }}
        </div>
    @endif

    <form method="POST" action="{{ route('pembeli.reset') }}">
        @csrf
        <input type="email" name="email"
            value="{{ session('reset_email') }}"
            class="w-full border p-2 mb-3 rounded bg-gray-100"
            readonly>

        <input type="password" name="password" placeholder="Password Baru" required
               class="w-full border p-2 mb-3 rounded">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
               class="w-full border p-2 mb-4 rounded">

        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Simpan Password Baru
        </button>
    </form>
</div>
@endsection
