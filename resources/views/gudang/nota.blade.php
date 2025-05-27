<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        .header { text-align: center; margin-bottom: 20px; }
        .item-image { max-width: 300px; max-height: 300px; display: block; margin: 15px auto; border: 1px solid #eee; }
        .pickup-stamp { color: #008000; font-weight: bold; border: 2px solid #008000; display: inline-block; padding: 5px 10px; transform: rotate(-5deg); margin-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>ReUseMart - Nota Penjualan</h2>
        <p>Tanggal: {{ now()->format('d-m-Y') }}</p>
    </div>

    <h4>Informasi Pembeli</h4>
    <p>Nama: {{ $barang->transaksi->pembeli->username }}</p>
    <p>Email: {{ $barang->transaksi->pembeli->email ?? '-' }}</p>

    <h4>Detail Barang</h4>
    
    @if($barang->gambar)
    <div style="text-align: center;">
        <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar {{ $barang->nama }}" class="item-image">
    </div>
    @endif
    
    <table>
        <tr>
            <th>Nama Barang</th>
            <td>{{ $barang->nama }}</td>
        </tr>
        <tr>
            <th>Harga</th>
            <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $barang->deskripsi }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>
                Sudah Diambil oleh Pembeli
                <div class="pickup-stamp">SUDAH DIAMBIL</div>
            </td>
        </tr>
        <tr>
            <th>Tanggal Pengambilan</th>
            <td>{{ now()->format('d-m-Y H:i') }}</td>
        </tr>
    </table>

    <p style="margin-top: 30px;">Terima kasih telah berbelanja di ReUseMart.</p>
    
    <div style="margin-top: 40px; border-top: 1px dotted #ccc; padding-top: 20px;">
        <p><strong>Catatan:</strong> Simpan nota ini sebagai bukti pembelian.</p>
    </div>
    <div class="section">
        <img src="{{ public_path('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}" 
             alt="Thumbnail" 
             style="max-height: 160px; border: 1px solid #ccc; padding: 5px; border-radius: 4px;">
    </div>
</body>
</html>