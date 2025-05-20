<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 15px; }
        .label { font-weight: bold; display: inline-block; width: 180px; vertical-align: top; }
        .value { display: inline-block; }
        hr { margin: 15px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Nota Penjualan Barang</h2>
        <p>ReuseMart - Pegawai Gudang</p>
        <hr>
    </div>

    <div class="section">
        <span class="label">Nama Barang:</span> <span class="value">{{ $barang->nama }}</span><br>
        <span class="label">Deskripsi:</span> <span class="value">{{ $barang->deskripsi }}</span><br>
        <span class="label">Harga:</span> <span class="value">Rp {{ number_format($barang->harga, 0, ',', '.') }}</span><br>
        <span class="label">Kategori:</span> <span class="value">{{ $barang->kategori->nama ?? '-' }}</span>
    </div>

    <div class="section">
        <span class="label">Pembeli:</span> <span class="value">{{ $barang->transaksi->pembeli->username ?? '-' }}</span><br>
        <span class="label">Tanggal Transaksi:</span> <span class="value">{{ $barang->transaksi->created_at->format('d M Y') }}</span><br>
        <span class="label">Jadwal Pengiriman:</span> <span class="value">{{ \Carbon\Carbon::parse($barang->jadwalPengirimen->jadwal_kirim)->translatedFormat('d F Y, H:i') ?? 'Belum Dijadwalkan' }}</span><br>
        <span class="label">Kurir:</span> <span class="value"> {{ $barang->jadwalPengirimen->pegawai->nama_lengkap ?? '-' }}</span></br>
    </div>

    <div class="section">
        <img src="{{ public_path('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}" 
             alt="Thumbnail" 
             style="max-height: 160px; border: 1px solid #ccc; padding: 5px; border-radius: 4px;">
    </div>
</body>
</html>