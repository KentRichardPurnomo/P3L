<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - {{ $kategori }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Penjualan<br>Kategori: {{ $kategori }}</h2>

    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Penitip</th>
                <th>Tanggal Terjual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
                <tr>
                    <td>{{ $barang->nama }}</td>
                    <td>Rp{{ number_format($barang->harga, 0, ',', '.') }}</td>
                    <td>{{ $barang->penitip->username ?? '-' }}</td>
                    <td>{{ $barang->updated_at->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
