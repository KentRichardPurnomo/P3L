<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan - {{ $kategori }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18px;
            margin: 5px 0;
            color: #2c3e50;
        }
        
        .header h2 {
            font-size: 16px;
            margin: 5px 0;
            color: #34495e;
        }
        
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 3px;
        }
        
        .info-box p {
            margin: 5px 0;
            font-size: 11px;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px;
            font-size: 11px;
        }
        
        th { 
            background-color: #2c3e50;
            color: white;
            border: 1px solid #34495e; 
            padding: 10px 8px; 
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        
        td { 
            border: 1px solid #bdc3c7; 
            padding: 8px 6px; 
            vertical-align: top;
        }
        
        .gambar-cell {
            text-align: center;
            width: 80px;
            padding: 5px;
        }
        
        .gambar-barang {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border: 1px solid #bdc3c7;
            border-radius: 4px;
        }
        
        .nama-barang {
            font-weight: bold;
            color: #2c3e50;
            line-height: 1.3;
        }
        
        .harga {
            font-weight: bold;
            color: #27ae60;
            text-align: right;
        }
        
        .penitip {
            background-color: #ecf0f1;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 10px;
            display: inline-block;
            color: #2c3e50;
        }
        
        .tanggal {
            text-align: center;
            color: #7f8c8d;
        }
        
        .summary {
            margin-top: 20px;
            border-top: 2px solid #2c3e50;
            padding-top: 15px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            font-size: 12px;
        }
        
        .total-amount {
            font-size: 16px;
            font-weight: bold;
            color: #27ae60;
            text-align: right;
            margin-top: 10px;
        }
        
        .footer {
            margin-top: 30px;
            border-top: 1px solid #bdc3c7;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #7f8c8d;
        }
        
        /* Styling untuk baris genap */
        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        tbody tr:hover {
            background-color: #e8f4f8;
        }
        
        /* No image placeholder */
        .no-image {
            width: 70px;
            height: 70px;
            background-color: #ecf0f1;
            border: 1px dashed #bdc3c7;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7f8c8d;
            font-size: 10px;
            text-align: center;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <h2>Kategori: {{ $kategori }}</h2>
    </div>

    <div class="info-box">
        <p><strong>Periode:</strong> {{ date('d F Y') }}</p>
        <p><strong>Total Barang:</strong> {{ count($barangs) }} item</p>
        <p><strong>Total Nilai:</strong> Rp{{ number_format($barangs->sum('harga'), 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 80px;">Gambar</th>
                <th style="width: 35%;">Nama Barang</th>
                <th style="width: 20%;">Harga</th>
                <th style="width: 20%;">Penitip</th>
                <th style="width: 15%;">Tanggal Terjual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($barangs as $index => $barang)
                <tr>
                    <td class="gambar-cell">
                        @if($barang->thumbnail && file_exists(public_path('images/barang/' . $barang->id . '/' . $barang->thumbnail)))
                            <img src="{{ public_path('images/barang/' . $barang->id . '/' . $barang->thumbnail) }}" 
                                 alt="{{ $barang->nama }}" 
                                 class="gambar-barang">
                        @else
                            <div class="no-image">
                                Tidak ada<br>gambar
                            </div>
                        @endif
                    </td>
                    <td class="nama-barang">
                        {{ $barang->nama }}
                        @if($barang->deskripsi)
                            <br><small style="color: #7f8c8d; font-weight: normal;">{{ Str::limit($barang->deskripsi, 50) }}</small>
                        @endif
                    </td>
                    <td class="harga">
                        Rp{{ number_format($barang->harga, 0, ',', '.') }}
                    </td>
                    <td>
                        @if($barang->penitip)
                            <span class="penitip">{{ $barang->penitip->username }}</span>
                        @else
                            <span style="color: #bdc3c7;">-</span>
                        @endif
                    </td>
                    <td class="tanggal">
                        {{ $barang->updated_at->format('d/m/Y') }}<br>
                        <small>{{ $barang->updated_at->format('H:i') }}</small>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">
            <span><strong>Total Barang Terjual:</strong></span>
            <span>{{ count($barangs) }} item</span>
        </div>
        <div class="summary-row">
            <span><strong>Rata-rata Harga:</strong></span>
            <span>Rp{{ number_format($barangs->avg('harga'), 0, ',', '.') }}</span>
        </div>
        <div class="total-amount">
            <strong>TOTAL PENJUALAN: Rp{{ number_format($barangs->sum('harga'), 0, ',', '.') }}</strong>
        </div>
    </div>

    <div class="footer">
        <p>Laporan digenerate pada {{ date('d F Y, H:i:s') }}</p>
        <p>© {{ date('Y') }} - Sistem Manajemen Barang Titipan</p>
    </div>
</body>
</html>