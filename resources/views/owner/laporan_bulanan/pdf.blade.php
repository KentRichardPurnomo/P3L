<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Bulanan - {{ $tahun }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Penjualan Bulanan</h2>
    <p style="text-align: center;">Tahun: <strong>{{ $tahun }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Transaksi</th>
                <th>Barang Terjual</th>
                <th>Pendapatan Kotor</th>
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
                    <td>{{ $data['bulan'] }}</td>
                    <td>{{ $data['jumlah_transaksi'] }}</td>
                    <td>{{ $data['jumlah_barang'] }}</td>
                    <td style="text-align: right;">Rp{{ number_format($data['pendapatan'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold; background-color: #f9f9f9;">
                <td>TOTAL</td>
                <td>{{ $jumlahTransaksi }}</td>
                <td>{{ $jumlahBarang }}</td>
                <td style="text-align: right;">Rp{{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    @if(isset($chartImage))
        <h4 style="text-align: center;">Grafik Pendapatan per Bulan</h4>
        <div style="text-align: center;">
            <img src="{{ $chartImage }}" alt="Grafik Penjualan" style="max-width: 100%; height: auto;">
        </div>
    @endif
</body>
</html>
