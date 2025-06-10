<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Stok Gudang</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Stok Gudang</h3>
    <p>Tanggal Filter: <strong>{{ $tanggal ?? 'Semua Tanggal' }}</strong></p>
    <p>Tanggal Cetak: <strong>{{ $tanggalCetak }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>Kode Barang</th>
                <th>Nama Produk</th>
                <th>ID Penitip</th>
                <th>Nama Penitip</th>
                <th>Tanggal Masuk</th>
                <th>Perpanjangan</th>
                <th>ID Hunter</th>
                <th>Nama Hunter</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $barang)
                <tr>
                    <td>{{ strtoupper(substr($barang->nama, 0, 1)) . $barang->id }}</td>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->penitip->id }}</td>
                    <td>{{ $barang->penitip->username }}</td>
                    <td>{{ \Carbon\Carbon::parse($barang->created_at)->format('d-m-Y') }}</td>
                    <td>{{ $barang->status_perpanjangan ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $barang->hunter_id ?? '-' }}</td>
                    <td>{{ $barang->hunter->nama ?? '-' }}</td>
                    <td>{{ number_format($barang->harga) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
