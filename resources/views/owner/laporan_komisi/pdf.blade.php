<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Komisi Bulanan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: center; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h3 style="text-align: center;">Laporan Komisi Bulanan</h3>
    <p>Bulan: <strong>{{ $namaBulan }}</strong></p>
    <p>Tahun: <strong>{{ $tahun }}</strong></p>
    <p>Tanggal Cetak: <strong>{{ $tanggalCetak }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>Kode Produk</th>
                <th>Nama Barang</th>
                <th>Harga Jual</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Laku</th>
                <th>Komisi Hunter</th>
                <th>Komisi Owner</th>
                <th>Bonus Penitip</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $d['kode_produk'] }}</td>
                    <td>{{ $d['nama_barang'] }}</td>
                    <td>{{ number_format($d['harga_jual']) }}</td>
                    <td>{{ $d['tanggal_masuk'] }}</td>
                    <td>{{ $d['tanggal_laku'] }}</td>
                    <td>{{ number_format($d['komisi_hunter']) }}</td>
                    <td>{{ number_format($d['komisi_owner']) }}</td>
                    <td>{{ number_format($d['bonus_penitip']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
