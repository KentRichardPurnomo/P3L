@extends('layouts.app-owner')

@section('content')
<div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <div class="mb-4">
            <a href="{{ url('/owner/dashboard') }}"
            class="inline-flex items-center text-green-600 hover:text-green-800 font-semibold">
                ← Kembali
            </a>
    </div>
    <h2 class="text-2xl font-bold mb-6">📊 Laporan Penjualan Bulanan</h2>

    {{-- Pilihan Tahun --}}
    <form method="GET" action="{{ route('owner.laporan.bulanan') }}" class="mb-6">
        <div class="flex items-center space-x-2">
            <label for="tahun" class="font-semibold">Pilih Tahun:</label>
            <select name="tahun" id="tahun" onchange="this.form.submit()" class="border rounded p-2 w-40">
                @for ($i = now()->year; $i >= 2020; $i--)
                    <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>
    </form>

    {{-- Tabel Penjualan --}}
    <table class="table-auto w-full border mb-6 text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-2 py-1 border">Bulan</th>
                <th class="px-2 py-1 border">Jumlah Transaksi</th>
                <th class="px-2 py-1 border">Barang Terjual</th>
                <th class="px-2 py-1 border">Pendapatan Kotor</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; $jumlahBarang = 0; $jumlahTransaksi = 0; @endphp
            @foreach($dataPerBulan as $data)
                @php 
                    $total += $data['pendapatan'];
                    $jumlahBarang += $data['jumlah_barang'];
                    $jumlahTransaksi += $data['jumlah_transaksi'];
                @endphp
                <tr>
                    <td class="border px-2 py-1">{{ $data['bulan'] }}</td>
                    <td class="border px-2 py-1 text-center">{{ $data['jumlah_transaksi'] }}</td>
                    <td class="border px-2 py-1 text-center">{{ $data['jumlah_barang'] }}</td>
                    <td class="border px-2 py-1 text-right">Rp{{ number_format($data['pendapatan'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr class="font-bold bg-gray-100">
                <td class="border px-2 py-1">TOTAL</td>
                <td class="border px-2 py-1 text-center">{{ $jumlahTransaksi }}</td>
                <td class="border px-2 py-1 text-center">{{ $jumlahBarang }}</td>
                <td class="border px-2 py-1 text-right">Rp{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Grafik --}}
    <canvas id="grafik" width="400" height="150"></canvas>

    {{-- Tombol Cetak PDF --}}
    <form id="formCetak" class="mt-6" target="_blank">
        <input type="hidden" name="tahun" id="inputTahun" value="{{ $tahun }}">
        <input type="hidden" name="chart" id="chartBase64">
        <button type="button"
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
            onclick="kirimPdf()">📄 Cetak PDF</button>
    </form>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartReady = false;

        const chart = new Chart(document.getElementById('grafik').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($dataPerBulan->pluck('bulan')) !!},
                datasets: [{
                    label: 'Pendapatan Kotor (Rp)',
                    data: {!! json_encode($dataPerBulan->pluck('pendapatan')) !!},
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    onComplete: () => {
                        chartReady = true;
                    }
                }
            }
        });

        function kirimPdf() {
            if (!chartReady) {
                alert('Tunggu grafik selesai dibuat...');
                return;
            }

            const canvas = document.getElementById('grafik');
            const base64Image = canvas.toDataURL('image/png');

            if (!base64Image || base64Image.length < 100) {
                alert('❌ Gagal ambil grafik. Coba refresh halaman.');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('owner.laporan.bulanan.pdf') }}";
            form.target = '_blank';

            // CSRF
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";
            form.appendChild(csrf);

            // Tahun
            const tahun = document.createElement('input');
            tahun.type = 'hidden';
            tahun.name = 'tahun';
            tahun.value = document.getElementById('inputTahun').value;
            form.appendChild(tahun);

            // Chart image
            const chartInput = document.createElement('input');
            chartInput.type = 'hidden';
            chartInput.name = 'chart';
            chartInput.value = base64Image;
            form.appendChild(chartInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</div>
@endsection
