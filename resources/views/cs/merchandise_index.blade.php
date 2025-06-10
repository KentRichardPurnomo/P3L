@extends('layouts.app-cs')

@section('content')
<div class="max-w-6xl mx-auto p-6 bg-white rounded shadow mt-6">
    <div class="mb-4">
        <a href="{{ url('/cs/dashboard') }}"
        class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
            ← Kembali
        </a>
    </div>
    <h2 class="text-2xl font-bold mb-4">Riwayat Klaim Merchandise</h2>

    {{-- Filter --}}
    <form method="GET" action="{{ route('cs.merchandise.index') }}" class="mb-4 flex items-center gap-4">
        <label class="font-semibold">Filter Status:</label>
        <select name="status" onchange="this.form.submit()" class="border rounded px-3 py-1">
            <option value="">Semua</option>
            <option value="belum diambil" {{ request('status') == 'belum diambil' ? 'selected' : '' }}>Belum Diambil</option>
            <option value="sudah diambil" {{ request('status') == 'sudah diambil' ? 'selected' : '' }}>Sudah Diambil</option>
        </select>
    </form>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($riwayat->isEmpty())
        <p class="text-gray-600">Tidak ada data klaim merchandise.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="border px-3 py-2">#</th>
                        <th class="border px-3 py-2">Pembeli</th>
                        <th class="border px-3 py-2">Merchandise</th>
                        <th class="border px-3 py-2">Tanggal Klaim</th>
                        <th class="border px-3 py-2">Status</th>
                        <th class="border px-3 py-2">Tanggal Ambil</th>
                        <th class="border px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">{{ $index + 1 }}</td>
                            <td class="border px-3 py-2">{{ $item->pembeli->username ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $item->merchandise->nama ?? '-' }}</td>
                            <td class="border px-3 py-2">{{ $item->created_at->format('d-m-Y') }}</td>
                            <td class="border px-3 py-2 capitalize">{{ $item->status }}</td>
                            <td class="border px-3 py-2">
                                {{ $item->tanggal_ambil ? \Carbon\Carbon::parse($item->tanggal_ambil)->format('d-m-Y H:i') : '-' }}
                            </td>
                            <td class="border px-3 py-2">
                                @if($item->status == 'belum diambil')
                                    <form action="{{ route('cs.merchandise.update', $item->id) }}" method="POST" onsubmit="return confirm('Tandai sebagai sudah diambil?')">
                                        @csrf
                                        <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                            Tandai Sudah Diambil
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 italic">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
